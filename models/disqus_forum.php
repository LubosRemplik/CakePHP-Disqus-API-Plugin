<?php
/**
 * http://disqus.com/api/docs/forums/
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class DisqusForum extends DisqusAppModel {
	
	/**
	 * Custom find types available on this model
	 * 
	 * @var array
	 */
	public $_findMethods = array(
		'listCategories' => true,
		'listPosts' => true,
	);
	
	/**
	 * The options allowed by each of the custom find types
	 * 
	 * @var array
	 */
	public $allowedFindOptions = array(
		'listCategories'  => array('forum', 'since_id', 'cursor', 'limit', 'order'),
		'listPosts'  => array('forum', 'since', 'related', 'cursor', 'limit', 'query', 'include', 'order'),
  	);
  	
	public function find($type, $options = array()) {
		$this->request['uri']['path'] = 'api/3.0/forums/' . $type . '.json';
		if (array_key_exists($type, $this->allowedFindOptions)) {
			$this->request['uri']['query'] = array_intersect_key($options, array_flip($this->allowedFindOptions[$type]));
		}
		return parent::find('all', $options);
	}
}