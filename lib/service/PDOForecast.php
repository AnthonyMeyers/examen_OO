<?php

class PDOForecast implements FetchForecastInterface
{

    private $dbm;

    public function __construct($dbm)
    {
        $this->dbm = $dbm;
    }

    /**
     * get the weatherdata for a week
     * @return array
     */

    public function processDayWeatherData()
    {
        $data = $this->PDOFetchFakeWeather();
        $array["city_name"] = $data[0]["img_title"];
        $array["country_name"] = $data[0]["lan_land"];
        $array["localtime"] = $data[0]["img_weer_datum"];
        $array["temp"] = $data[0]["weer_temp"];
        $array["wind_kph"] = $data[0]["weer_wind"];
        $array["description"] = $data[0]["wbg_beschrijving"];
        $array["image"] = $data[0]["weer_image"];
        return $array;
    }

    private function PDOFetchFakeWeather()
    {
        //Checks if there is any data already registered for today
        $date = date("Y-m-d");
        $sql=
            'select * from img_weer
            inner join image on image.img_id = img_weer.img_weer_id
            inner join land on land.lan_id = image.img_lan_id
            inner join weer on weer.weer_id = img_weer.weer_img_id
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            having img_weer_id = "'.$_GET["id"].'" and img_weer_datum like "'.$date.'"';
        $data = $this->dbm->getData($sql);

        //If there is no data select a random line and add it to the img_weer table
        //If the user reruns the site it will be the same data
        if(count($data) === 0)
        {
            $data = $this->PDORegisterFakeWeather($date);
        }
        return $data;
    }

    private function PDORegisterFakeWeather($date)
    {

        $data = $this->dbm->getData("select * from weer order by RAND() limit 1");
        $this->dbm->ExecuteSQL('insert into img_weer (img_weer_id, img_weer_datum, weer_img_id)
                                values ("'.$_GET["id"].'","'.$date.'","'.$data[0]["weer_id"].'")');
        $sql =
            'select * from img_weer
            inner join image on image.img_id = img_weer.img_weer_id
            inner join land on land.lan_id = image.img_lan_id
            inner join weer on weer.weer_id = img_weer.weer_img_id
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            having img_weer_id = "'.$_GET["id"].'" and img_weer_datum like "'.$date.'"';
        return $data;
    }

    public function fetchAllWeather($location){}


    /**
     * get the weatherdata for a day
     * @return array
     */

public function processAllWeatherData($data){}



}