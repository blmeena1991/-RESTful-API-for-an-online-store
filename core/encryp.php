<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 1:54 AM
 */

Class Encryption{
    public static function encryptIt( $q ) {
        $qEncoded=hash('sha256',$q);
        return( $qEncoded );
    }

}