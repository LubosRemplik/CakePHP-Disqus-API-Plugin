<?php
/**
 * http://disqus.com/api/docs/threads/
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class DisqusThread extends DisqusAppModel {
	
	/**
	 * Custom find types available on this model
	 * 
	 * @var array
	 */
	public $_findMethods = array(
		'details' => true,
	);
	
	/**
	 * The options allowed by each of the custom find types
	 * 
	 * @var array
	 */
	public $allowedFindOptions = array(
		'details'  => array('thread', 'thread:ident', 'thread:link', 'related', 'forum'),
  	);
  	
	public function find($type, $options = array()) {
		$this->request['uri']['path'] = 'api/3.0/threads/' . $type . '.json';
		if (array_key_exists($type, $this->allowedFindOptions)) {
			$this->request['uri']['query'] = array_intersect_key($options, array_flip($this->allowedFindOptions[$type]));
		}
		return parent::find('all', $options);
	}
}