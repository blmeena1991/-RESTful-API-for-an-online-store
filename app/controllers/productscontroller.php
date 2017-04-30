<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/**
 * Class ProductsController
 */
class ProductsController extends AppController {


    /**
     *
     */
    function beforeAction () {
	}

    /**
     *List the products
     */
    function index() {
        try{
            $this->Product->orderBy('sku_code','ASC');
            $this->Product->showHasOne();
            $this->Product->showHasMany();
            $this->Product->setPage(1);
            $productlist = $this->Product->search();
            $product= array('success' => 'true', 'data' =>$productlist);
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>$e->getMessage());
        }
        $this->set('product',$product);
    }

    /**
     * @param null $id
     * Return Product Info
     */
    function view($id = null) {
        try{
            if(empty($id)){
                throw new Exception('Invalid Product id');
            }
            $this->Product->id = $id;
            $this->Product->showHasOne();
            $this->Product->showHasMany();
            $productinfo = $this->Product->search();

            if(empty($productinfo)){
                throw new Exception('No Product found.');
            }
            $product= array('success' => 'true', 'data' =>$productinfo);
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>$e->getMessage());
        }
		$this->set('product',$product);
	}

    /**
     * @param null $id
     * Return the list of find prosucts
     */
    function find($query = null) {
        try{
            $this->Product->like('product_title',$query);
            $this->Product->showHasOne();
            $this->Product->showHasMany();
            $productinfo = $this->Product->search();

            if(empty($productinfo)){
                throw new Exception('No Product found.');
            }
            $product= array('success' => 'true', 'data' =>$productinfo);
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>$e->getMessage());
        }
        $this->set('product',$product);
    }


    /**
     *    Create a new products
     */
    function add() {
        try{
            if(empty($this->_payload)){
                throw new Exception(json_encode(array('message' => 'Invalid json payload received')));
            }else {
                $payload=$this->_payload;
                if(isset($payload['Product'])){
                    $error=$this->Product->validation($payload['Product']);
                    if(!empty($error)){
                        throw new Exception(json_encode($error));
                    }

                    foreach ($payload['Product'] as $key=>$p) {

                        if($key=='category_name'){
                            $conditions = '`name` = \''.mysql_real_escape_string($p).'\'';
                            $q="SELECT id FROM `categories` WHERE ".$conditions;
                            $category=$this->Product->custom($q);
                            if(!empty($category)) {
                                $this->Product->category_id=$category[0]['Category']['id'];
                            }
                            continue;
                        }

                        $this->Product->$key=$p;

                        if($key=='sku_code'){
                            $conditions = '`sku_code` = \''.mysql_real_escape_string($p).'\'';
                            $q="SELECT id FROM `products` WHERE ".$conditions;
                            $old_prodcuts=$this->Product->custom($q);
                            if(!empty($old_prodcuts)) {
                                $error['sku_code']='Product with this sku code '.$p.' already exists.';
                                throw new Exception(json_encode($error));
                            }
                        }

                    }

                    $product_id = $this->Product->save();

                    if($product_id==-1){
                        throw new Exception(json_encode(array('message'=>'Unable to add the product.Please contact to support.')));
                    }

                    if(isset($payload['Variation'])){
                        foreach($payload['Variation'] as $variation){
                            $data=array('product_id'=>$product_id,'variation_name'=>$variation['Variation']['variation_name'],'variation_value'=>$variation['Variation']['variation_value']);
                            $this->Product->insertRow('variations',$data);
                        }
                    }
                    $product= array('success' => 'true', 'message' => 'Product successfully added with Product Id:'.$product_id);
                }
            }
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>json_decode($e->getMessage(),true));
        }
        $this->set('product',$product);
    }


    /**
     * @param null $id
     * Delete the product based on id
     */
    function delete($id = null) {
        try{
            if(empty($id)){
                throw new Exception('Product id not pass in request');
            }
            $this->Product->id=$id;
            if($this->Product->delete()==-1){
                throw new Exception('Unable to delete the product.Please contact to support.');
            }
            $this->Product->deleteAll('variations','product_id',$id);
            $product= array('success' => 'false', 'message' =>'Product delete successfully.');
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>$e->getMessage());
        }
        $this->set('product',$product);
    }

    /**
     *  Update the products info like sku_code,unit_price ,images etc
     */
    function edit() {
        try{
            if(empty($this->_payload)){
                throw new Exception(json_encode(array('message' => 'Invalid json payload received')));
            }else {
                $payload=$this->_payload;
                if(isset($payload['Product'])){
                    $error=$this->Product->validation($payload['Product']);
                    if(!empty($error)){
                        throw new Exception(json_encode($error));
                    }


                    if(!isset($payload['Product']['id'])) {
                        $error['id'] = 'Product id should be required for update the product';
                        throw new Exception(json_encode($error));
                    }

                    $conditions = '`id` = \''.mysql_real_escape_string($payload['Product']['id']).'\'';
                    $q="SELECT id,sku_code FROM `products` WHERE ".$conditions;
                    $old_prodcuts=$this->Product->custom($q);
                    if(empty($old_prodcuts)) {
                        $error['id']='Product with id '.$payload['Product']['id'].' not  exists.';
                        throw new Exception(json_encode($error));
                    }

                    foreach ($payload['Product'] as $key=>$p) {
                        if($key=='category_name'){
                            $conditions = '`name` = \''.mysql_real_escape_string($p).'\'';
                            $q="SELECT id FROM `categories` WHERE ".$conditions;
                            $category=$this->Product->custom($q);
                            if(!empty($category)) {
                                $this->Product->category_id=$category[0]['Category']['id'];
                            }
                            continue;
                        }

                        if($key=='sku_code'){
                            $conditions = '`sku_code` = \''.mysql_real_escape_string($p).'\'';
                            $q="SELECT id FROM `products` WHERE ".$conditions;
                            $old_prodcuts=$this->Product->custom($q);
                            if(!empty($old_prodcuts)) {
                                if($old_prodcuts[0]['Product']['id']!=$payload['Product']['id']){
                                    $error['sku_code']='Product with this sku code '.$p.' already exists.';
                                    throw new Exception(json_encode($error));
                                }
                            }
                        }

                        $this->Product->$key=$p;

                    }

                    $res=$this->Product->save();

                    if($res==-1){
                        throw new Exception(json_encode(array('message'=>'Unable to update the product.Please contact to support.')));
                    }

                    $product_id= $payload['Product']['id'];
                    if(isset($payload['Variation'])){
                        $this->Product->deleteAll('variations','product_id',$product_id);
                        foreach($payload['Variation'] as $variation){
                            $data=array('product_id'=>$product_id,'variation_name'=>$variation['Variation']['variation_name'],'variation_value'=>$variation['Variation']['variation_value']);
                            $this->Product->insertRow('variations',$data);
                        }
                    }
                    $product= array('success' => 'true', 'message' => 'Product successfully updated with Product Id:'.$product_id);
                }
            }
        }catch(Exception $e){
            $product= array('success' => 'false', 'error' =>json_decode($e->getMessage(),true));
        }
        $this->set('product',$product);
    }

    /**
     *
     */
    function afterAction() {

	}
	

}