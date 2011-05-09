<?php 
/* disqus schema generated on: 2011-05-09 12:24:57 : 1304940297*/
class disqusSchema extends CakeSchema {
	var $name = 'disqus';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $post_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'forum' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'parent' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'author' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'uid' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'thread' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'message' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
?>