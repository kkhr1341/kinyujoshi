<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

\Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
  'Agent' => APPPATH.'classes/agent.php',
  'Validation_Error' => APPPATH . 'classes/validation/error.php',
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
\Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : \Fuel::DEVELOPMENT);

if(\Fuel::$env === 'production') {
    \Autoloader::add_classes(array(
        'Log' => APPPATH . 'classes/log.php', // awslogs
    ));
}

// Initialize the framework with the config file.
\Fuel::init('config.php');
ini_set('default_charset', 'UTF-8');
