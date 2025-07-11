<?php
// define('URL', 'http://localhost/casa-de-infonavit/');
error_reporting(E_ALL);
ini_set('display_errors', '1');

//ini_set('display_errors', 0); // Oculta los errores en pantalla

date_default_timezone_set('America/Mexico_City');

require_once("app/database.php");


//for mvc structure
require_once("app/controller.base.php");
require_once("app/view.base.php");
require_once("app/model.base.php");
require_once("config/config.php");
require_once("app/app.php");

$app = new App();
