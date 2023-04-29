<?php

function autoLoader($className){
    $path = '../model/';
    $ext = '.php';
    $fullPath = $path.$className.$ext;
    
    include_once $fullPath;
}

spl_autoload_register('autoLoader');

?>