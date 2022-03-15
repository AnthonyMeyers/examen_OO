<?php

//initialize container



$configuration = array(
    "db_dsn"=>"mysql:host=localhost;dbname=steden",
    "db_user"=> "root",
    "db_pass"=>"",
    "acces" => ["/login.php","/register.php","/no_access.php"],
    "make_select_stad" => ["img_lan_id","","select lan_id, lan_land from land"],
    "data_keys_img" =>[
        "img_id"=>"",
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
        "usr_telefoon"=>"",
        "weer_image"=>"",
        "@date@" => "",
        "@city_name@" =>"",
        "@country_name@" => "",
        "weer_description" => "",
        "weer_temp" => "",
        "weer_wind" => "",
        "weer_comment" => ""
    ]

);

?>