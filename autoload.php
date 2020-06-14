<?php
namespace Flip; 

// Load PSR-4 classes
spl_autoload_register(function($class) {
    if (stripos($class, __NAMESPACE__) === 0)
    {
        require __DIR__ . DIRECTORY_SEPARATOR . 'src' . str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen(__NAMESPACE__))) . '.php';
    }
});

// Load helpers
require 'src/Helpers/Helper.php';