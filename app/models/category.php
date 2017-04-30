<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
class Category extends AppModel {
		var $hasMany = array('Product' => 'Product');
		var $hasOne = array('Parent' => 'Category');

}