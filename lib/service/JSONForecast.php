<?php

class JSONForecast implements FetchForecastInterface
{

    private $dbm;

    public function __construct($dbm)
{
    $this->dbm = $dbm;
}

    public function processCurrentWeatherData()
    {
        $data = $this->fetchCurrentWeather();
        if($data === null){return null;}
        $array = [];
        $array["city_name"] = $data["location"]["name"];
        $array["country_name"] = $data["location"]["country"];
        $array["date"] = $data["location"]["localtime"];
        $array["temp"] = $data["current"]["temp_c"];
        $array["wind_kph"] = $data["current"]["wind_kph"];
        $array["description"] = $data["current"]["condition"]["text"];
        $array["image"] = $data["current"]["condition"]["icon"];

        return $array;
    }

    private function fetchCurrentWeather()
    {

        $subject = $this->dbm->getData('select img_title from image where img_id = "'.$_GET["id"].'"');
        $search_url = "http://api.weatherapi.com/v1/current.json?key=dac85837b7d24e29be8120304221203&q=";
        /*$search_url .= $subject[0]["img_title"];*/
        $search_url .= "&days=1&aqi=no&alerts=no";
            /*forecast*/
            $API_data = @file_get_contents($search_url);
            $data = json_decode($API_data,true);
            if($API_data === FALSE)
            {
                return null;
            }
            return $data;
    }

    public function processAllWeatherData()
    {

        $data = $this->fetchAllWeather();
        $arr=[];
        if($data === null)
        {
            return null;
        }
        $count = count($data["forecast"]["forecastday"]);

        for($i = 0; $i < $count;$i++)
        {
            $arr[$i]["city_name"] = $data["location"]["name"];
            $arr[$i]["country_name"] = $data["location"]["country"];
            $arr[$i]["date"] = $data["forecast"]["forecastday"][$i]["date"];
            $arr[$i]["temp"] = $data["forecast"]["forecastday"][$i]["day"]["maxtemp_c"];
            $arr[$i]["wind_kph"] = $data["forecast"]["forecastday"][$i]["day"]["maxwind_kph"];
            $arr[$i]["description"] = $data["forecast"]["forecastday"][$i]["day"]["condition"]["text"];
            $arr[$i]["image"] = $data["forecast"]["forecastday"][$i]["day"]["condition"]["icon"];
        }

        return $arr;
    }

    private function fetchAllWeather()
    {
        $subject = $this->dbm->getData('select img_title from image where img_id = "'.$_GET["id"].'"');
        $search_url = "http://api.weatherapi.com/v1/forecast.json?key=dac85837b7d24e29be8120304221203&q=";
        /*$search_url .= $subject[0]["img_title"];*/
        $search_url .= "&days=3&aqi=no&alerts=no";

        $API_data = @file_get_contents($search_url);
        $data = json_decode($API_data,true);
        return $data;
    }


}