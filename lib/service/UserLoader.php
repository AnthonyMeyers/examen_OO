<?php

class UserLoader
{

    private $dbm;

    public function __construct($dbm)
    {
        $this->dbm = $dbm;
    }


    public function getActiveUser()
    {
        $sql = 'select * from user where usr_email like "'.$_POST["usr_email"].'"';
        $data = $this->dbm->GetData($sql);
        $user = new user();
        $user->setUsrNaam($data[0]["usr_naam"]);
        $user->setUsrId($data[0]["usr_id"]);
        $user->setUsrVoornaam($data[0]["usr_voornaam"]);
        $user->setUsrEmail($data[0]["usr_email"]);
        $user->setUsrTelefoon($data[0]["usr_telefoon"]);
        return $user;
    }

}