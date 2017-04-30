<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
class Template {
	
	protected $variables = array();
	protected $_controller;
	protected $_action;
	
	function __construct($controller,$action) {
		$this->_controller = $controller;
		$this->_action = $action;
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables = $value;
	}

	/** Display Template **/
	
    function render() {
        $json = new JSON();
        return $json->jsonView($this->variables);
    }

}