<?php

class WeatherLoader
{

    private $json_forecast;
    private $PDO_forecast;

    public function __construct($json_forecast,$PDO_forecast)
    {
        $this->json_forecast = $json_forecast;
        $this->PDO_forecast = $PDO_forecast;
    }


    /**
     * @return AbstractWeather
     */

    public function getForecastNow($id=0):AbstractWeather
    {

        $data = $this->json_forecast->getCurrentWeatherData($id);

        if($data === null)
        {
            $data = $this->PDO_forecast->getCurrentWeatherData($id);
        }

        $checkWeather = strtolower($data["description"]);

        if($checkWeather === "zonnig" || $checkWeather === "helder" || $checkWeather === "gedeeltelijk bewolkt")
        {

            $weather =  new GoodWeather($data["description"]);

        }
        else
        {

            $weather = new BadWeather($data["description"]);

        }

        $weather = $this->fillWeatherObject($data,$weather);

        if(isset($data["current"]))$weather->setCurrent(true);

        else $weather->setCurrent(false);

        return $weather;
    }

    /**
     * @return array
     */
    private function getForecastNextDays():array
    {

        $data = $this->json_forecast->getAllWeatherData();

        if($data === null){

            $data = $this->PDO_forecast->getAllWeatherData();
        }

        $arr = [];

        foreach($data as $key => $value)
        {
            $checkWeather = strtolower($value["description"]);

            if($checkWeather === "zonnig" || $checkWeather === "vrij" || $checkWeather === "gedeeltelijk bewolkt")

            {

                $weather =  new GoodWeather($value["description"]);

            }
            else
            {

                $weather = new BadWeather($value["description"]);

            }

            $arr[] = $this->fillWeatherObject($value,$weather);

        }

        return $arr;

;    }

    /**
     * @return array
     */
    public function getWeatherForecastArray():array
    {
        $days = $this->getForecastNextDays();

        $arr = [];

        foreach($days as $key => $value)
        {

            $arr[$key]["city_name"] = $value->getCityName($value);
            $arr[$key]["country_name"] = $value->getCountryName($value);
            $arr[$key]["date"] = $value->getDate($value);
            $arr[$key]["weer_temp"] = $value->getWeerTemp($value);
            $arr[$key]["weer_wind"] = $value->getWeerWind($value);
            $arr[$key]["weer_description"] = $value->getWeerDescription($value);
            $arr[$key]["weer_image"] = $value->getWeerImage($value);
            $arr[$key]["weer_comment"] = $value->getWeatherComment();
            $arr[$key]["weer_luchtvochtigheid"] = $value->getWeerLuchtvochtigheid();

        }

        return $arr;

    }

    /**
     * @param $array
     * @param $weather
     * @return AbstractWeather;
     */
    private function fillWeatherObject($array,$weather)
    {

        $weather->setCityName($array["city_name"]);
        $weather->setCountryName($array["country_name"]);
        $weather->setDate($array["date"]);
        $weather->setWeerTemp($array["temp"]);
        $weather->setWeerWind($array["wind_kph"]);
        $weather->setWeerDescription($array["description"]);
        $weather->setWeerImage($array["image"]);
        $weather->setWeerLuchtvochtigheid($array["humidity"]);
        return $weather;

    }

}