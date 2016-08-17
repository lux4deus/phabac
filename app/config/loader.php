<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces([
    'Vokuro\Models'       => $config->application->modelsDir,
    'Vokuro\Controllers'  => $config->application->controllersDir,
    'Vokuro\Forms'        => $config->application->formsDir,
    'Vokuro'              => $config->application->libraryDir,
    'Watchdog'			  => $config->application->watchdogDir,
    'Ultimate\Acl'        => $config->application->libraryDir."Acl/",
    'Ultimate\Acl\Models' => $config->application->modelsDir."Ultimate/"
]);

$loader->register();

// Use composer autoloader to load vendor classes
require_once BASE_PATH . '/vendor/autoload.php';
