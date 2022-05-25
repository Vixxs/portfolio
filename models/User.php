<?php

final class User extends ObjectModel{

    public $username;
    public $name;
    public $password;
    public $email;
    public $picture;
    public $admin;
    public $last_connexion;
    public $now_connexion;
    public $connexion_number;
    public $connexion_fail;
    public $locked;
    public $token;
    public $token_date;
    public $google;
    
    function save(){
        parent::save();
        $setting = new Setting();
        if(!$setting->isObjectExistBy('id_user', $this->id)){
            $setting->id_user = $this->id;
            $setting->save();
        }
    }

    function define(){
        $this->table = "users";
        $this->fields = [[
                "name" => "id",
                "type" => "INT(11)",
                "more" => "AUTO_INCREMENT PRIMARY KEY",
            ]  , [
                "name" => "username",
                "type" => "VARCHAR( 50 )",
                "more" => "",
            ] , [
                "name" => "name",
                "type" => "VARCHAR( 50 )",
                "more" => "",
            ] ,[
                "name" => "password",
                "type" => "VARCHAR( 60 )",
                "more" => "",
            ] , [
                "name" => "email",
                "type" => "VARCHAR( 50 )",
                "more" => "NOT NULL"
            ], [
                "name" => "picture",
                "type" => "VARCHAR( 100 )",
                "more" => ""
            ] ,[
                "name"=> "admin",
                "type"=> "BIT(1)",
                "more"=> "DEFAULT 0"
            ],[
                "name"=> "last_connexion",
                "type"=> "TIMESTAMP",
                "more"=> "DEFAULT CURRENT_TIMESTAMP"
            ],[
                "name"=> "now_connexion",
                "type"=> "TIMESTAMP",
                "more"=> "DEFAULT CURRENT_TIMESTAMP"
            ],[
                "name"=> "connexion_number",
                "type"=> "INT(5)",
                "more"=> "DEFAULT 1"
            ],[
                "name"=> "connexion_fail",
                "type"=> "INT(5)",
                "more"=> "DEFAULT 1"
            ],[
                "name"=> "locked",
                "type"=> "BOOLEAN",
                "more"=> "DEFAULT 0"
            ],[
                "name"=> "token",
                "type"=> "VARCHAR( 13 )",
                "more"=> ""
            ],[
                "name"=> "token_date",
                "type"=> "TIMESTAMP",
                "more"=> "DEFAULT CURRENT_TIMESTAMP"
            ],[
                "name"=> "google",
                "type"=> "BIT(1)",
                "more"=> "DEFAULT 0"
            ]
        ];
    }
}