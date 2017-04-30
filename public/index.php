<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$url = $_GET['url'];
require_once (ROOT . DS . 'core' . DS . 'bootstrap.php');
