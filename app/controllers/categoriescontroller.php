<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/**
 * Class CategoriesController
 */
class CategoriesController extends AppController {

    /**
     *
     */
    function beforeAction () {

	}

    /**
     * @param null $categoryId
     *
     */
    function view($categoryId = null) {
        try{
            if(empty($categoryId)){
                throw new Exception('Invalid Category id');
            }
            $this->Category->id = $categoryId;
            $this->Category->showHasOne();
            $this->Category->showHasMany();
            $categoryInfo = $this->Category->search();
            if(empty($categoryInfo)){
                throw new Exception('No Category found.');
            }
            $category= array('success' => 'true', 'data' =>$categoryInfo);
        }catch(Exception $e){
            $category= array('success' => 'false', 'error' =>$e->getMessage());
        }
        $this->set('category',$category);
	}


    /**
     *
     */
    function index() {
        try{
            $this->Category->orderBy('name','ASC');
            $this->Category->showHasOne();
            $this->Category->showHasMany();
            $categorieslist = $this->Category->search();
            $categories= array('success' => 'true', 'data' =>$categorieslist);
        }catch(Exception $e){
            $categories= array('success' => 'false', 'error' =>$e->getMessage());
        }
		$this->set('categories',$categories);
	}

    /**
     *
     */
    function afterAction() {

	}


}