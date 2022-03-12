<?php

class PublicAcces
{

    private $hasAcces = false;
    private $accesPages;

    public function __construct(array $configuration)
    {
        $this->accesPages = $configuration["acces"];
    }

    public function checkAccess()
    {

        foreach($this->accesPages as $key => $value)
        {
            if(strpos($_SERVER["PHP_SELF"],$value )> 0)
            {
                $this->hasAcces = true;
            }
            }

        if ($this->hasAcces === false and !isset($_SESSION['user'])) {

            header("Location: ./no_access.php");
            exit;
        }
    }
        public function redirect()
    {
        $_SESSION["user"] = null;
        header("Location: ./no_access.php");
        exit;
    }
}