<?php

abstract class AbstractCatering
{

    private $hrc_id;
    private $hrc_naam;
    private $hrc_adres;
    private $hrc_beschrijving;
    private $hrc_type_id;
    private $hrc_klanten;

    abstract function getTotalClients();

    public function __construct()
    {}

    /**
     * @return mixed
     */
    public function getHrcKlanten()
    {
        return $this->hrc_klanten;
    }

    /**
     * @param mixed $hrc_klanten
     */
    public function setHrcKlanten($hrc_klanten): void
    {
        $this->hrc_klanten = $hrc_klanten;
    }

    /**
     * @return mixed
     */
    public function getHrcId()
    {
        return $this->hrc_id;
    }

    /**
     * @param mixed $hrc_id
     */
    public function setHrcId($hrc_id): void
    {
        $this->hrc_id = $hrc_id;
    }

    /**
     * @return mixed
     */
    public function getHrcNaam()
    {
        return $this->hrc_naam;
    }

    /**
     * @param mixed $hrc_naam
     */
    public function setHrcNaam($hrc_naam): void
    {
        $this->hrc_naam = $hrc_naam;
    }

    /**
     * @return mixed
     */
    public function getHrcAdres()
    {
        return $this->hrc_adres;
    }

    /**
     * @param mixed $hrc_adres
     */
    public function setHrcAdres($hrc_adres): void
    {
        $this->hrc_adres = $hrc_adres;
    }

    /**
     * @return mixed
     */
    public function getHrcBeschrijving()
    {
        return $this->hrc_beschrijving;
    }

    /**
     * @param mixed $hrc_beschrijving
     */
    public function setHrcBeschrijving($hrc_beschrijving): void
    {
        $this->hrc_beschrijving = $hrc_beschrijving;
    }

    /**
     * @return mixed
     */
    public function getHrcTypeId()
    {
        return $this->hrc_type_id;
    }

    /**
     * @param mixed $hrc_type_id
     */
    public function setHrcTypeId($hrc_type_id): void
    {
        $this->hrc_type_id = $hrc_type_id;
    }


}