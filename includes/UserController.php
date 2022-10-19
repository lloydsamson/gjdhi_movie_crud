<?php
require('throw_403.php');

class UserController{

    private $data;
    private $link_data_file;
    private $get_data_file;
    private $decoded_data_file;

    public function __construct($form_data){
        $this->data = $form_data;
        $this->link_data_file = '../data/users.json';
        $this->get_data_file = file_get_contents($this->link_data_file);
        $this->decoded_data_file = json_decode($this->get_data_file, true);
    }

    public function registerUser(){
        $hashedPwd = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->decoded_data_file[] = array(
            'email' => $this->data['email'],
            'password' => $hashedPwd,
            'role' => "user",
            'created_at' => date("h:i:sa Y/m/d")
        );
        file_put_contents($this->link_data_file, json_encode($this->decoded_data_file));
    }
        
}