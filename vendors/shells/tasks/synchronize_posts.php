<?php
App::import('Helper', 'Time');

/**
 * Synchronize disqus posts with local post_comments table
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class SynchronizePostsTask extends Shell
{
	var $uses = array('Disqus.PostComment', 'Disqus.DisqusThread', 'Disqus.DisqusPost');
	
	function execute()
	{
		$all = null;
		if(isset($this->params['all'])) $all = true;
		
		$this->out('Disqus synchronize posts task.');
		$this->hr();
		
		$forum = Configure::read('Disqus.shortname');
		if(!$forum) {
			$this->out('Failed! Please enter shortname in your config.');
			$this->hr();
			return false;
		}
		
		$this->out('Saving new comments.');
		$options = array('forum'=>$forum);
		if(!$all) $options['limit'] = 100;
		$posts = $this->DisqusPost->find('list', $options);
		if(!$posts['code'] && !empty($posts['response'])) {
			// extracts threads and assign post id
			foreach(array_unique(Set::classicExtract($posts['response'], '{n}.thread')) as $thread_id) {
				$thread = $this->DisqusThread->find('details', array('thread'=>$thread_id));
				if(!$thread['code'] && !empty($thread['response']))
					$post_ids[$thread_id] = reset($thread['response']['identifiers']);
			}
			
			// save new comments
			$Time = new TimeHelper();
			$count = 0;
			foreach ($posts['response'] as $post) {
				if(!$this->PostComment->hasAny(array('uid'=>$post['id']))) {
					$data = array(
						'PostComment' => array(
							'post_id'=>$post_ids[$post['thread']],
							'forum'=>$post['forum'],
							'parent'=>$post['parent'],
							'author'=> "{$post['author']['name']} ({$post['author']['email']})",
							'created'=>$Time->format('Y-m-d H:i:s', $post['createdAt']),
							'uid'=>$post['id'],
							'thread'=>$post['thread'],
							'message'=>$post['message'],
							'ip'=>$post['ipAddress']
						)
					);
					$this->PostComment->create();
					if($this->PostComment->save($data)) $count++;
				}
			}
			$this->out(sprintf('%s comments have been saved.', $count));
		} else {
			$this->out('Failed! Bad result.');
			$this->hr();
			return false;
		}		
		$this->hr();
		
		$this->out('Deleting comments marked as spam or deleted.');
		$posts = array();
		$options = array('forum'=>$forum, 'include'=>'deleted');
		$deleted = $this->DisqusPost->find('list', $options);
		if(!$deleted['code']) $posts = am($posts, $deleted['response']);
		$options = array('forum'=>$forum, 'include'=>'spam');
		$spam = $this->DisqusPost->find('list', $options);
		if(!$spam['code']) $posts = am($posts, $spam['response']);
		if($posts) {
			$conditions=array('PostComment.uid'=>Set::classicExtract($posts, '{n}.id'));
			$count = $this->PostComment->find('count', compact('conditions'));
			$result = $this->PostComment->deleteAll($conditions);
			if($result) {
				$this->out(sprintf('%s comments have been deleted.', $count));
				$this->hr();
			}
		}		
		
		$this->out('Done.');
		$this->hr();
		return false;
	}
}