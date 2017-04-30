<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/**
 * Class AppModel
 */
class AppModel extends SQLQuery {
	/**
	 * @var string
     */
	protected $_model;

	/**
	 * AppModel constructor.
     */
	function __construct() {
		
		global $inflect;

		$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$this->_limit = PAGINATE_LIMIT;
		$this->_model = get_class($this);
		$this->_table = strtolower($inflect->pluralize($this->_model));
		if (!isset($this->abstract)) {
			$this->_describe();
		}
	}

	/**
	 *
     */
	function __destruct() {
	}
}
