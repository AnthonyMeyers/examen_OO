<?php

class User
{

    private $usr_id;
    private $usr_voornaam;
    private $usr_naam;
    private $usr_email;
    private $usr_telefoon;


    public function getUserFullNameCapitals()
    {
        return ["usr_voornaam"=>strtoupper($this->getUsrVoornaam()),"usr_naam"=>strtoupper($this->getUsrNaam())];
    }

    public function createUserWithPost()
    {
        $user = new user();
            $user->setUsrNaam($_POST["usr_naam"]);
            $user->setUsrId($_POST["usr_id"]);
            $user->setUsrVoornaam($_POST["usr_voornaam"]);
            $user->setUsrEmail($_POST["usr_email"]);
            $user->setUsrTelefoon($_POST["usr_telefoon"]);
        return $user;
    }



    public function getAllUserData()
    {
        $arr = [];
            foreach($this as $key=>$value)
            {
                $arr[$key]=$value;
            }
    return $arr;

    }

    /**
     * @return mixed
     */
    public function getUsrId()
    {
        return $this->usr_id;
    }

    /**
     * @param mixed $usr_id
     */
    public function setUsrId($usr_id): void
    {
        $this->usr_id = $usr_id;
    }

    /**
     * @return mixed
     */
    public function getUsrVoornaam()
    {
        return $this->usr_voornaam;
    }

    /**
     * @param mixed $usr_voornaam
     */
    public function setUsrVoornaam($usr_voornaam): void
    {
        $this->usr_voornaam = $usr_voornaam;
    }

    /**
     * @return mixed
     */
    public function getUsrNaam()
    {
        return $this->usr_naam;
    }

    /**
     * @param mixed $usr_naam
     */
    public function setUsrNaam($usr_naam): void
    {
        $this->usr_naam = $usr_naam;
    }

    /**
     * @return mixed
     */
    public function getUsrEmail()
    {
        return $this->usr_email;
    }

    /**
     * @param mixed $usr_email
     */
    public function setUsrEmail($usr_email): void
    {
        $this->usr_email = $usr_email;
    }

    /**
     * @return mixed
     */
    public function getUsrTelefoon()
    {
        return $this->usr_telefoon;
    }

    /**
     * @param mixed $usr_telefoon
     */
    public function setUsrTelefoon($usr_telefoon): void
    {
        $this->usr_telefoon = $usr_telefoon;
    }



}