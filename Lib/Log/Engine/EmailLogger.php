<?php
App::uses('CakeLogInterface', 'Log');
App::uses('CakeEmail', 'Network/Email');
class EmailLogger implements CakeLogInterface {

	public $config = array(
		'levels' => array('warning', 'notice', 'debug', 'info', 'error'),
		'email' => 'email_logger'
	);

    public function __construct($config = array()) {
		$this->config = array_merge($this->config, $config);
    }

    public function write($type, $message) {
		if (empty($this->config['levels']) || in_array($type, $this->config['levels'])) {
			try {
				CakeEmail::deliver(null, 'EmailLogger: ' . $type, $message, $this->config['email']);
			} catch(Exception $e) {

			}
		}
    }
}