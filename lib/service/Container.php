<?php

class Container
{
    private $configuration;
    private $pdo;
    private $messageService;
    private $cityLoader;
    private $logger;
    private $dbmanager;
    private $publicAccess;
    private $security;
    private $formElements;
    private $sanitization;
    private $HTMLFunctions;
    private $validation;
    private $checkLogin;
    private $saveCredentials;
    private $userLoader;
    private $JSONForecast;
    private $weatherLoader;
    private $PDOForecast;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getPDOForecast()
    {

        if($this->PDOForecast === null)
        {

            $this->PDOForecast = new PDOForecast($this->getDBManager());

        }

        return $this->PDOForecast;

    }

    public function getWeatherLoader()
    {
        if($this->weatherLoader === null)
        {
            $this->weatherLoader = new WeatherLoader($this->getJSONForecast(),$this->getPDOForecast());
        }

        return $this->weatherLoader;
    }

    public function getJSONForecast()
    {
        if($this->JSONForecast === null)
        {
            $this->JSONForecast = new JSONForecast($this->getDBManager(),$this->configuration);
        }

        return $this->JSONForecast;
    }




    public function getUserLoader()
    {
        if($this->userLoader === null)
        {
            $this->getDBManager();
            $this->userLoader = new UserLoader($this->dbmanager);
        }

        return $this->userLoader;
    }

    public function getSaveCredentials()
    {
        if($this->saveCredentials === null)
        {
            $this->getUserLoader();
            $this->getDBManager();
            $this->getSanitization();
            $this->getValidation();
            $this->saveCredentials = new SaveCredentials($this->dbmanager,$this->sanitization,$this->validation,$this->userLoader);
        }
        return $this->saveCredentials;
    }

    public function getCheckLogin()
    {

        if($this->checkLogin === null)
        {

            $this->getDBManager();
            $this->getSanitization();
            $this->getPublicAccess();
            $this->checkLogin = new CheckLogin($this->dbmanager,$this->sanitization, $this->publicAccess);
        }
        return $this->checkLogin;
    }


    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration["db_dsn"],
                $this->configuration["db_user"],
                $this->configuration["db_pass"]
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }

    public function getMessageService()
    {
        if ($this->messageService === null) {

            $this->messageService = new MessageService();
        }

        return $this->messageService;
    }

    public function getCityLoader()
    {
        if ($this->cityLoader === null) {
            $this->getDBManager();
            $this->cityLoader = new CityLoader($this->dbmanager);
        }

        return $this->cityLoader;

    }

    public function getLogger()
    {
        if ($this->logger === null) {
            $this->logger = new Logger();
        }
        return $this->logger;
    }

    public function getDBManager()
    {

        if ($this->dbmanager === null) {
            $this->getLogger();
            $this->dbmanager = new DBManager($this->getPDO(), $this->logger);
        }

        return $this->dbmanager;
    }

    public function getPublicAccess()
    {

        {
            if ($this->publicAccess === null) {
                $this->publicAccess = new PublicAcces($this->configuration);
            }
            return $this->publicAccess;
        }

    }

    public function getSecurity()
    {
        if($this->security === null)
        {
            $this->security = new Security();
        }

        return $this->security;
    }

    public function getFormElements()
    {
        if($this->formElements === null)
        {

            $this->getDBManager();
            $this->getCityLoader();
            $this->formElements = new FormElements($this->dbmanager,$this->cityLoader,$this->configuration);

        }

    return $this->formElements;
    }

    public function getSanitization()
    {
        if($this->sanitization === null)
        {
            $this->sanitization = new Sanitization();
        }

        return $this->sanitization;
    }

    public function getHTMLFunctions()
    {
        if($this->HTMLFunctions === null)
        {
            $this->getSecurity();
            $this->getFormElements();
            $this->getMessageService();
            $this->HTMLFunctions = new HTMLFunctions(
                $this->security,
                $this->formElements,
                $this->messageService,
                $this->configuration);
        }
        return $this->HTMLFunctions;
    }

    public function getValidation()
    {
        if($this->validation === null)
        {
            $this->getDBManager();
            $this->validation = new Validation($this->dbmanager,$this->configuration);

        }

        return $this->validation;
    }

}