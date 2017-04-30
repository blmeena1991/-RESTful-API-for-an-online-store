<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/** Check if environment is development and display errors **/

function setReporting() {
if (DEVELOPMENT_ENVIRONMENT == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
}
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 *  Remove magic quotes for string
 */
function removeMagicQuotes() {
if ( get_magic_quotes_gpc() ) {
	$_GET    = stripSlashesDeep($_GET   );
	$_POST   = stripSlashesDeep($_POST  );
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/**
 * @return mixed
 * Return the request method
 */
function get_request_method(){
    return $_SERVER['REQUEST_METHOD'];
}

/** Secondary Call Function **/

function performAction($controller,$action,$queryString = null,$render = 0) {
	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action,$queryString);
	$dispatch->render = $render;
	return call_user_func_array(array($dispatch,$action),$queryString);
}



/** Main Call Function **/

function requestCall() {
	global $url;
	global $default;

	$queryString = array();

    if (!isset($url)) {
		$controller = $default['controller'];
		$action = $default['action'];
	} else {
		$urlArray = array();
		$urlArray = explode("/",$url);
		$controller = $urlArray[0];
		array_shift($urlArray);
		if (isset($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
		} else {
			$action = 'index'; // Default Action
		}
		$queryString = $urlArray;
	}
    if(get_request_method()=='POST') {
        $queryString = json_decode(file_get_contents("php://input"),true);
        if($queryString === null) {
            $queryString=array();
        }
    }
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $header);
    if(!in_array($action,array('createAdmin','generateToken','find','view','index'))){
        if(!isset($header['token'])){
            $msg=array('success'=>'false','error'=>'API token not set in request');
            echo json_encode($msg);
            exit;
        }
        if(empty($header['token'])){
            $msg=array('success'=>'false','error'=>'API token value missing');
            echo json_encode($msg);
            exit;
        }

        $api_key=$header['token'];
        $sqlObj=new SQLQuery();
        $sqlObj->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $user=$sqlObj->custom('SELECT * FROM users WHERE `api_token`=\''.mysql_real_escape_string($api_key).'\'');

        if(empty($user)){
            $msg=array('success'=>'false','error'=>'Invaild  API token');
            echo json_encode($msg);
            exit;
        }
       if($user[0]['User']['expire_time']< time()){
           $msg=array('success'=>'false','error'=>'API token has been expired Please regenerate the token.');
           echo json_encode($msg);
           exit;
       }
    }

    if($action=='find'){
        $queryString[]= @$header['query'];

    }
	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action,$queryString);

	if ((int)method_exists($controllerName, $action)) {
		call_user_func_array(array($dispatch,"beforeAction"),$queryString);
		call_user_func_array(array($dispatch,$action),$queryString);
		call_user_func_array(array($dispatch,"afterAction"),$queryString);
	} else {
        $dispatch->render=0;
        $msg=array('success'=>'false','error'=>'method not allowed');
        echo json_encode($msg);
        exit(0);
    }
}


/** Autoload any classes that are required **/

function __autoload($className) {
	if (file_exists(ROOT . DS . 'core' . DS . strtolower($className) . '.class.php')) {
		require_once(ROOT . DS . 'core' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
		/* Error Generation Code Here */
	}
}

$cache =& new Cache();
$inflect =& new Inflection();

setReporting();
removeMagicQuotes();
unregisterGlobals();
requestCall();


?>