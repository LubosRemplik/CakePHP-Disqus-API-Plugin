<?php
App::uses('RestSource', 'RestData.Model/DataSource');

/**
 * CakePHP Datasource for accessing the Disqus API
 *
 * @author Luboš Remplík <lubos@lubos.me>
 * @link http://lubos.me
 * @copyright (c) 2011 Luboš Remplík
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class DisqusSource extends RestSource {

	/**
	 * If no config is passed into the constructor, i.e. the config is not in
	 * app/config/database.php check if any config is in the config directory of
	 * the plugin, or in the configure class and use that instead.
	 *
	 * @param array $config
	 */
	public function __construct($config = null) {
		if (!is_array($config)) {
			$config = array();
		}

		// Default config
		$defaults = array(
			'datasource' => 'Disqus.DisqusSource',
		);

		// Try and import the plugins/disqus/config/disqus_config.php file and
		// merge the config with the defaults above
		if (App::import(array('type' => 'File', 'name' => 'Disqus.DISQUS_CONFIG', 'file' => 'config'.DS.'disqus_config.php'))) {
			$DISQUS_CONFIG = new DISQUS_CONFIG();
			if (isset($DISQUS_CONFIG->disqus)) {
				$defaults = array_merge($defaults, $DISQUS_CONFIG->disqus);
			}
		}

		// Add any config from Configure class that you might have added at any
		// point before the model is instantiated.
		if (($configureConfig = Configure::read('Disqus')) != false) {
			$defaults = array_merge($defaults, $configureConfig);
		}

		$config = array_merge($defaults, $config);
		parent::__construct($config);
	}

	/**
	 * Adds in common elements to the request such as the host and extension
	 *
	 * @param AppModel $model The model the operation is called on. Should have a
	 *  request property in the format described in HttpSocket::request
	 * @return mixed Depending on what is returned from RestSource::request()
	 */
	public function request(&$model) {
		if (!isset($model->request['uri']['host'])) {
			$model->request['uri']['host'] = 'disqus.com';
		}

		$model->request['uri']['query']['api_secret'] = $this->config['secret_key'];

		// Get the response from calling request on the Rest Source (it's parent)
		$response = parent::request($model);
		return $response;
	}
}