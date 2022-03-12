<?php

class Post
{

    private $old_post;

    public function __construct()
    {

        if($_SESSION && array_key_exists("OLD_POST",$_SESSION)){
        $this->old_post = $_SESSION["OLD_POST"];
        unset($_SESSION["OLD_POST"]);
            }
        else
        {
            $this->old_post =  ["img_id"=>"",
        "img_filename"=>"",
        "img_title"=>"",
        "img_width"=>"",
        "img_height"=>"",
        "img_lan_id"=>"",
        "img_date"=>"",
        "usr_id"=>"",
        "usr_voornaam"=>"",
        "usr_naam"=>"",
        "usr_email"=>"",
        "usr_password"=>"",
        "usr_telefoon"=>""];
        }
    }

    public function postData()
    {
        $arr = [];
        foreach($this->old_post as $key => $value)
        {
        $arr[0][$key] = $value;
        }

        return $arr;
    }



}