<?php
/**
 * Using disqus datasource for all models extending this model
 * 
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 */
class DisqusAppModel extends AppModel {
	
	public $useDbConfig = 'disqus';
	
	public $useTable = false;
	
	public $request = array();
	
	public function __construct($id = false, $table = null, $ds = null) {
		$sources = ConnectionManager::sourceList();
		if (!in_array('disqus', $sources)) {
			ConnectionManager::create('disqus', array('datasource' => 'Disqus.DisqusSource'));
		}
		parent::__construct($id, $table, $ds);
	}
	
	public function setDataSourceConfig($config = array()) {
		$ds = $this->getDataSource($this->useDbConfig);
		if (!is_array($ds->config)) {
			$ds->config = array($ds->config);
		}
		$ds->config = array_merge($ds->config, $config);
		return $ds->config;
	}
}