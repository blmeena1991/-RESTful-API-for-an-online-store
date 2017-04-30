<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
require_once (ROOT . DS . 'core' . DS . 'encryp.php');

/**
 * Class UsersController
 */
class UsersController extends AppController {

    /**
     *
     */
    function beforeAction () {
	}

    /**
     * @param $username
     */
    function generateToken($username=null) {
        try{
            if(empty($username)){
                   throw new Exception('Please pass the username in request');
            }
            $this->User->where('username',$username);
            $user = $this->User->search();
            if(empty($user)) {
                throw new Exception('User not exists');
            }
            $date = new DateTime('NOW');
            $date->add(new DateInterval('P90D'));
            $time = strtotime($date->format('Y-m-d H:i:s'));
            $api_token = Encryption::encryptIt($time . '-' . $username);

            $this->User->id = $user[0]['User']['id'];
            $this->User->api_token = $api_token;
            $this->User->expire_time = $time;
            $user = $this->User->save();

            if ($user == -1) {
                throw new Exception('Unable to generate new api token .Please contact to support');
            }
            $user = array('success' => 'true', 'api_token' => $api_token, 'expire_time' => $time);
        }catch(Exception $e) {
            $user= array('success' => 'false', 'error'=>$e->getMessage());
        }
        $this->set('user',$user);
	}

    /**
     *
     */
    function createAdmin() {
        try{
            if(empty($this->_payload)){
                throw new Exception('Invalid json payload received');
            }
            $date = new DateTime('NOW');
            $date->add(new DateInterval('P90D'));
            $time = strtotime($date->format('Y-m-d H:i:s'));
            $api_token = Encryption::encryptIt($time . '-' . $this->_payload['username']);
            $this->User->username = $this->_payload['username'];
            $this->User->email = $this->_payload['email'];
            $this->User->role = 'admin';
            $this->User->api_token = $api_token;
            $this->User->expire_time = $time;
            $user = $this->User->save();

            if ($user == -1) {
                throw new Exception('User already exists .');
            }
            $user = array('success' => 'true', 'api_token' => $api_token, 'expire_time' => $time);
        }catch(Exception $e){
            $user= array('success' => 'false', 'error' =>$e->getMessage());
        }
        $this->set('user',$user);
    }

    /**
     *
     */
    function afterAction() {

	}

}