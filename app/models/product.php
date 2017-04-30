<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/**
 * Class Product
 */
class Product extends AppModel {
    /**
     * @var array
     */
    var $hasOne = array('Category' => 'Category');
    /**
     * @var array
     */
    var $hasMany = array('Variation' => 'Variation');


    /**
     * @param $data
     * @return array
     */
    function  validation($data){
         $error=array();
         if(!isset($data['product_title'])){
             $error['product_title']='This field is required';
         }else{
             if(empty($data['product_title'])){
                 $error['product_title']='This field must be some value';
             }
         }
         if(!isset($data['sku_code'])){
             $error['sku_code']='This field is required';
         }else{
             if(empty($data['sku_code'])){
                 $error['sku_code']='This field must be some value';
             }
         }
         if(!isset($data['unit_price'])){
             $error['unit_price']='This field is required';
         }else{
             if(empty($data['unit_price'])){
                 $error['unit_price']='This field must be some value';
             }else if(!is_numeric($data['unit_price'])) {
                 $error['unit_price']='Value should be numeric';
             }
         }
          return  $error;
     }
}