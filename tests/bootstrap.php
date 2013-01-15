<?php
/*
 * This file bootstraps the test environment.
 */

error_reporting(E_ALL | E_STRICT);

/*
 * Composer autoload
 */
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    $composerLoader = require_once __DIR__.'/../vendor/autoload.php';
    echo 'OK';
}

// register silently failing autoloader
spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'LGP\Tests\\')) {
        $path = __DIR__.'/'.strtr($class, '\\', '/').'.php';
        if (file_exists($path) && is_readable($path)) {
            require_once $path;

            return true;
        }
    }
    
    return false;
});