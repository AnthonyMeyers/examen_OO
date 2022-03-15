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
     * make one AbstractWeather object(object good weather/bad weather
     * @return AbstractWeather
     */

    public function getForecastNow():AbstractWeather
    {

            $data = $this->json_forecast->processCurrentWeatherData();
            if($data === null){
            $data = $this->PDO_forecast->processCurrentWeatherData();

            }

            if($data === null)
            {

                die("<br/><h3>Geen weerbericht gevonden</h3>");
            }
        $checkWeather = strtolower($data["description"]);

        if($checkWeather === "sunny" || $checkWeather === "clear" || $checkWeather === "partly cloudy")
        {

            $weather =  new GoodWeather($data["description"]);
        }
        else
        {
            $weather = new BadWeather($data["description"]);
        }

        $weather->setCityName($data["city_name"]);
        $weather->setCountryName($data["country_name"]);
        $weather->setDate($data["date"]);
        $weather->setWeerTemp($data["temp"]);
        $weather->setWeerWind($data["wind_kph"]);
        $weather->setWeerDescription($data["description"]);
        $weather->setWeerImage($data["image"]);

        return $weather;
    }

    public function getForecastTreeDays()
    {

        $data = $this->json_forecast->processAllWeatherData();
        if($data === null){
            $data = $this->PDO_forecast->processAllWeatherData();
        }

        if($data === null)
        {
            die("Geen weerbericht gevonden.");
        }

        $arr = [];
        foreach($data as $key => $value){
        $checkWeather = strtolower($value["description"]);

        if($checkWeather === "sunny" || $checkWeather === "clear" || $checkWeather === "partly cloudy")
        {

            $weather =  new GoodWeather($value["description"]);
        }
        else
        {
            $weather = new BadWeather($value["description"]);
        }
        $weather->setCityName($value["city_name"]);
        $weather->setCountryName($value["country_name"]);
        $weather->setDate($value["date"]);
        $weather->setWeerTemp($value["temp"]);
        $weather->setWeerWind($value["wind_kph"]);
        $weather->setWeerDescription($value["description"]);
        $weather->setWeerImage($value["image"]);
        $arr[] = $weather;
        }

        return $arr;

;    }

    public function createDataArrayWeather()
    {
        $days = $this->getForecastTreeDays();
        $arr = [];

        foreach($days as $key => $value)
        {
            $arr[$key]["city_name"] = $value->getCityName($value);
            $arr[$key]["country_name"] = $value->getCountryName($value);
            $arr[$key]["date"] = $value->getDate($value);
            $arr[$key]["weer_temp"] = $value->getWeerTemp($value);
            $arr[$key]["weer_wind"] = $value->getWeerWind($value)." max km/u";
            $arr[$key]["weer_description"] = $value->getWeerDescription($value);
            $arr[$key]["weer_image"] = $value->getWeerImage($value);
            $arr[$key]["weer_comment"] = $value->getWeatherComment();
        }

        return $arr;
    }

}