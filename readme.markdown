CakePHP Disqus API Plugin
==============================

A CakePHP Plugin containing a DataSource for interarcting with Disqus web services.
http://disqus.com/api/docs/

Dependencies
-------------
CakePHP ReST DataSource Plugin https://github.com/neilcrookes/CakePHP-ReST-DataSource-Plugin

Configuration
-------------
Configure and use config/config.php.default or copy and set config/disqus_config.php.default
Clone CakePHP ReST DataSource Plugin under plugins/rest

Usage
-------------
1) Manipulate with data

...
$uses = array('Disqus.DisqusPost');
...
function getComments() {
	return $this->DisqusPost->find('list', array('forum'=>Configure::read('Disqus.shortname')));
}
...

See models/disqus_* models for more information

2) Synchronize comments

Use console
cake disqus synchronize_posts