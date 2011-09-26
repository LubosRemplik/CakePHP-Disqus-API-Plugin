<?php

/**
 * Disqus Shell
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class DisqusShell extends Shell
{
	public $tasks = array('SynchronizePosts');
	
	public function main()
	{
		$this->help();			
	}
	
	/**
	 * Displays help contents
	 *
	 * @access public
	 */
	function help() {
		$help = <<<TEXT
The Disqus Shell

Use and modify config.php.default

---------------------------------------------------------------
Usage: cake elemental <command> <arg1> -<param1>...
---------------------------------------------------------------
Params:
	-all
		normally it takes 24 hours old posts, with this params it takes all

Commands:
	disqus help
		shows this help message.

	disqus synchronize_posts
		synchronize posts with PostComment model

Example:
	cake disqus synchronize_posts -all
TEXT;
		$this->out($help);
		$this->_stop();
	}
}