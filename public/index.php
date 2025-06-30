<?php
require_once '../config/config.php';
require_once '../app/helpers/url_helper.php';
require_once '../app/helpers/session_helper.php';

spl_autoload_register(function($className){
    require_once '../app/core/' . $className . '.php';
});

$app = new App();