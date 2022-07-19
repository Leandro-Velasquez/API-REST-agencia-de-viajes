<?php

use Class\Exceptions\FileNotFoundException;

spl_autoload_register(function($class) {
    $dir = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    
    if(file_exists($dir)) {
        include $dir;
    }else {
        include __DIR__ . '/Class/Exceptions/FileNotFoundException.php';
        throw new FileNotFoundException('file not Found
        ');
    }
});
?>