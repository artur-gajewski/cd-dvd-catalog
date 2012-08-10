<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */

// Override server's settings
 error_reporting(E_ALL);
 ini_set('display_errors','On');

// Setup autoloading
include 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run()->send();
