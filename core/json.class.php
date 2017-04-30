<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
class JSON {

    function jsonView($data)
    {
        if(is_array($data)){
            echo json_encode($data);
        }
    }
}
