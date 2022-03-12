<?php

class CityLoader
{

    private $dbm;

    public function __construct($dbm)
    {

        $this->dbm =$dbm;

    }

    private function createCityFromData(array $cityData): City
    {
        $city = new City();
        $city->setImgTitle($cityData["img_title"]);
        $city->setImgId($cityData["img_id"]);
        $city->setImgFilename($cityData["img_filename"]);
        $city->setImgWidth($cityData["img_width"]);
        $city->setImgHeight($cityData["img_height"]);
        $city->setImgLanId($cityData["img_lan_id"]);
        $city->setImgDate($cityData["img_date"]);
        return $city;
    }

    //find city by id
    public function findOneById($id): ?City
    {

        $cityArray = $this->dbm->getData('select * from image where img_id = "'.$id.'"');

        if (!$cityArray) return null;

        $city = $this->createCityFromData($cityArray[0]);
        return $city;
    }

    //find all cities
    public function getAllCities()
    {
        $allCities = $this->dbm->getData('SELECT * FROM image');

        if (!$allCities) return null;
        $cities = [];
        foreach($allCities as $key=> $value)
        {
        $cities[$key] = $this->createCityFromData($value);
        }

        return $cities;

    }

    public function createArrayCities()
    {
        $arr = [];
        $data = $this->getAllCities();

    foreach($data as $key => $city)
    {
        $arr[$key]= $city->getCityAsArray();
    }
    return $arr;
}



}