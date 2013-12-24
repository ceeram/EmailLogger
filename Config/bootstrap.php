<?php
$options = array('engine' => 'EmailLogger.Email');

try {
	Configure::load('EmailLogger.config');
	$options = array_merge(Configure::read('EmailLogger'), $options);
} catch (ConfigureException $e) {}

App::uses('CakeLog', 'Log');
CakeLog::config('email', $options);