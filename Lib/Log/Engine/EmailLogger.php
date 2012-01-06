<?php
App::uses('CakeLogInterface', 'Log');
App::uses('CakeEmail', 'Network/Email');
class EmailLogger implements CakeLogInterface {

	public $config = array(
		'levels' => array('warning', 'notice', 'debug', 'info', 'error'),
		'email' => 'email_logger',
		'duplicates' => false
	);

    public function __construct($config = array()) {
		$this->config = array_merge($this->config, array('file' => LOGS . 'email_logger.log'), $config);
    }

    public function write($type, $message) {
		if (empty($this->config['levels']) || in_array($type, $this->config['levels'])) {
			if (!strpos(file_get_contents($this->config['file']), $message)) {
				try {
					CakeEmail::deliver(null, 'EmailLogger: ' . $type, $message, $this->config['email']);
				} catch(Exception $e) {}
			}

			$output = $message . "\n";
			file_put_contents($this->config['file'], $output, FILE_APPEND);

		} elseif ($type == 'clean') {
			file_put_contents($this->config['file'], "");
		}
    }
}