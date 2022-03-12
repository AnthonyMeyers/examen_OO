<?php

//ADDMESSAGE GEBRUIKEN IN SAVE & LOGIN CHECK


class MessageService
{
    private $errors;
    private $input_errors;
    private $infos;

    public function __construct()
    {

        if($this->CountNewErrors()>0){
        $this->errors = $_SESSION["errors"];
        }

        if($this->CountNewInputErrors()>0)
        {
            $this->input_errors = $_SESSION["input_errors"];
        }

        if($this->CountNewInfos() > 0)
        {
            $this->infos = $_SESSION["msgs"];
        }

        $_SESSION["msgs"] = null;
        $_SESSION["errors"] = null;
        $_SESSION["input_errors"] = null;
    }

    public function CountErrors()
    {

        return count($this->errors) || 0;

    }

    public function CountInputErrors()
    {

        return count($this->input_errors) || 0;

    }

    public function CountInfos()
    {

        return count($this->infos) || 0;

    }

    public function CountNewErrors()
    {

        if(isset($_SESSION["errors"]) && count($_SESSION["errors"])>0)

        {

            return count($_SESSION["errors"]);

        }

         return null;
    }

    public function CountNewInputErrors()
    {

        if(isset($_SESSION["input_errors"]) && count($_SESSION["input_errors"])>0)

        {

            return count($_SESSION["input_errors"]);

        }

        return null;
    }

    public function CountNewInfos()
    {

        if(isset($_SESSION["msgs"]) && count($_SESSION["msgs"])>0)

        {
            return count($_SESSION["msgs"]);

        }

        return null;

    }

    public function GetInputErrors()
    {
        if($this->input_errors && count($this->input_errors) > 0)

        {

            return $this->input_errors;

        }

    return [];
    }

    public function AddMessage($type, $msg, $key = null)
    {

    if ($key)$_SESSION[$type][$key] = $msg;
    else $_SESSION[$type]=$msg;

    }

    public function ShowErrors()
    {

        return $this->errors;

    }

    public function ShowInfos()
    {

        if($this->infos && count($this->infos) > 0)
        {
            return $this->infos;
        }

        return [];

    }

}