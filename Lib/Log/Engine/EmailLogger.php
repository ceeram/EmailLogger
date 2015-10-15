<?php
App::uses('CakeLogInterface', 'Log');
App::uses('CakeEmail', 'Network/Email');
class EmailLogger implements CakeLogInterface {

	public $config = array(
		'levels' => array('warning', 'notice', 'debug', 'info', 'error'),
		'email' => 'email_logger',
		'duplicates' => true,
		'file' => 'email_logger.log'
	);

    public function __construct($config = array()) {
		$this->config = array_merge($this->config, $config);
		$this->config['file'] = LOGS . $this->config['file'];
    }

    public function write($type, $message) {
		extract($this->config);
		if (empty($levels) || in_array($type, $levels)) {
			if ($duplicates || (!$duplicates && strpos(file_get_contents($file), $message) === false)) {
				try {
					CakeEmail::deliver(null, 'EmailLogger: ' . $type, $message, $email);
					if (!$duplicates) {
						$output = $message . "\n";
						file_put_contents($file, $output, FILE_APPEND);
					}
				} catch(Exception $e) {}
			}
		}
    }
}