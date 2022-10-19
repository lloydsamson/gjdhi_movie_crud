<?php 

require_once('./UserController.php');
require('throw_403.php');

class UserValidator{
    
    private $data;
    private $errors = [];
    private static $fields = ['email', 'password'];

    public function __construct($post_data)
    {
        $this -> data = $post_data;
    }

    public function validateLogin(){
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in the data");
                return;
            }
        }
        $this->validateEmail("login");
        $this->validatePassword("login");

        if (empty($this->errors)) {
            $_SESSION['email'] = $this->data['email'];
            $_SESSION['user_role'] = $this->getUserRole($this->data['email']);
            $link = "";
            if ($_SESSION['user_role'] === 'admin') {
                $link = 'admin.php';
            }
            if ($_SESSION['user_role'] === 'user') {
                $link = 'user.php';
            }
            
            return array('redirect'=>$link);
        }

        return $this->errors;
    }

    public function validateRegister(){
        foreach(self::$fields as $field){
            if(!array_key_exists($field,$this->data)){
                trigger_error("$field is not present in the data");
                return;
            }
        }
        $this->validateEmail("register");
        $this->validatePassword("register");

       
        if(empty($this->errors)){
            $userController = new UserController($this->data);
            $userController->registerUser();
            $_SESSION['email'] = $this->data['email'];
            $_SESSION['user_role'] = $this->getUserRole($this->data['email']);
            $link = "";
            if ($_SESSION['user_role'] === 'admin') {
                $link = 'admin.php';
            }
            if ($_SESSION['user_role'] === 'user') {
                $link = 'user.php';
            }

            return array('redirect' => $link);
        }

        return $this->errors;
    }

    //auth type means if it's from Register or Login function
    private function validateEmail($authType){
        $val = trim($this->data['email']);
        $isEmailExist = $authType === 'login' ? $this->isEmailExistLogin($val) : $this->isEmailExistRegister($val);

        if($isEmailExist && $authType === "register"){ 
            $this->addError('email_exist', 'This email is already exist.');
        }

        if (!is_null($isEmailExist) &&  $authType === "login"){
            $password = $isEmailExist;
            $this->checkPassword($password);
        }

        if(empty($val)){
            $this->addError('email_error','Email cannot be empty.');
        }else{
            if(!filter_var($val,FILTER_VALIDATE_EMAIL)){
                $this->addError('email_error','Email needs to be valid.');
            }
        }
    }

    private function isEmailExistLogin($email)
    {

        $json_accounts = file_get_contents('../data/users.json');
        $data = json_decode($json_accounts, true);

        foreach ($data as $key => $value) {
            if ($email == $data[$key]['email']) {
                return $data[$key]['password'];
            }
        }
        return false;
    }

    private function isEmailExistRegister($email){

        $json_accounts = file_get_contents('../data/users.json');
        $data = json_decode($json_accounts, true);


        foreach ($data as $key => $value) {
           if($email == $data[$key]['email']){
                return true;
            }
        }
        return false;
    }

    private function validatePassword($authType){
        $val = $this->data['password'];
        
        if(empty($val)){
            $this->addError('password_error','Password cannot be empty.');
        } else if (strlen($val) < 8 && $authType === 'register') {
            $this->addError('password_error','Password must be 8 in length.');
        }
    }

    private function checkPassword($password){
        if (!password_verify($this->data['password'], $password)) {
            $this->addError('password_error','Invalid information. Please try again.');
        }
        return;
    }

    private function getUserRole($email)
    {
        $json_accounts = file_get_contents('../data/users.json');
        $data = json_decode($json_accounts, true);

        foreach ($data as $key => $value) {
            if ($email == $data[$key]['email']) {
                return $data[$key]['role'];
            }
        }
    }


    private function addError($key, $val){
        $this->errors[$key]= $val;
    }
}