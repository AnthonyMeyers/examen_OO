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

    public function getForecastJSONToday()
    {

            $data = $this->json_forecast->processDayWeatherData();
            if($data === null){
            $data = $this->PDO_forecast->processDayWeatherData();
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
        $weather->setLocaltime($data["localtime"]);
        $weather->setTemp($data["temp"]);
        $weather->setWindSpeed($data["wind_kph"]);
        $weather->setDescription($data["description"]);
        $weather->setImage($data["image"]);

        return $weather;
    }






}