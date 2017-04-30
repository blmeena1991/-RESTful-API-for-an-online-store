<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/**
 * Class AppController
 */
class AppController {

    /**
     * @var string
     */
    protected $_controller;
    /**
     * @var
     */
    protected $_action;
    /**
     * @var Template
     */
    protected $_template;
    /**
     * @var null
     */
    protected $_payload;

    /**
     * @var int
     */
    public $render;



    /**
     * @var array
     */
    public $error_response=array();

    /**
     * AppController constructor.
     * @param $controller
     * @param $action
     * @param null $queryString
     */
    function __construct($controller, $action, $queryString=null) {

		global $inflect;

		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$this->_payload = $queryString;
		$model = ucfirst($inflect->singularize($controller));
		$this->render = 1;
		$this->$model =new $model;
		$this->_template =new Template($controller,$action);

	}

    /**
     * @param $name
     * @param $value
     */
    function set($name, $value) {
		$this->_template->set($name,$value);
	}

    /**
     *
     */
    function __destruct() {
		if ($this->render) {
			$this->_template->render();
		}
	}

}