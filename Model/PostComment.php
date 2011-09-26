<?php

/**
 * PostComment Model
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class PostComment extends AppModel {
	public $actsAs = array(
		'Containable'
	);
	var $belongsTo = array('Post'=> array('counterCache' => true));
}
