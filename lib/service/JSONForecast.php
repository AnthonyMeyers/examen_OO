<?php

class JSONForecast implements FetchForecastInterface
{

    private $dbm;
    private $configuration;

    public function __construct($dbm,$configuration)
{
    $this->dbm = $dbm;
    $this->configuration = $configuration;
}

    public function getCurrentWeatherData()
    {
        $data = $this->fetchCurrentWeather();
        if($data === null|| array_key_exists("error",$data)){return null;}
        $array = [];
        $array["city_name"] = $data["location"]["name"];
        $array["country_name"] = $data["location"]["country"];
        $array["date"] = $data["location"]["localtime"];
        $array["temp"] = $data["current"]["temp_c"];
        $array["wind_kph"] = $data["current"]["wind_kph"];
        $array["description"] = $data["current"]["condition"]["text"];
        $array["image"] = $data["current"]["condition"]["icon"];
        $array["current"] = true;
        return $array;
    }


    private function getAPIKey()
    {
        $configuration = $this->configuration;
        return $configuration["API_key"];
    }

    private function fetchCurrentWeather()
    {

        $subject = $this->dbm->getData('select img_title from image where img_id = "'.$_GET["id"].'"');
        $search_url = "http://api.weatherapi.com/v1/current.json?key=".$this->getAPIKey()."&q=";
        /*$search_url .= $subject[0]["img_title"];*/
        $search_url .= "&lang=nl&days=1&aqi=no&alerts=no";

        $curl = curl_init($search_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $data= json_decode(curl_exec($curl),true);
        curl_close($curl);

            if($data === FALSE)
            {
                return null;
            }
            return $data;
    }

    public function getAllWeatherData()
    {

        $data = $this->fetchAllWeather();
        $arr=[];
        if($data === null || array_key_exists("error",$data))
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
        $search_url .= $subject[0]["img_title"];
        $search_url .= "&lang=nl&days=3&aqi=no&alerts=no";

        $curl = curl_init($search_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $data= json_decode(curl_exec($curl),true);
        curl_close($curl);

        return $data;
    }


}