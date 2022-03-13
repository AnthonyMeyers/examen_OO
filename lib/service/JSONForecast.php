<?php

class JSONForecast implements FetchForecastInterface
{

    private $fetch_data;
    private $fetch_today;
    private $forecast_array;
    private $weather_today;
    private $dbm;

    public function __construct($dbm)
{
    $this->dbm = $dbm;
}

    public function processDayWeatherData()
    {

        $data = $this->fetchDayWeather();
        if($data === null){return null;}
        $array = [];
        $array["city_name"] = $data["location"]["name"];
        $array["country_name"] = $data["location"]["country"];
        $array["localtime"] = $data["location"]["localtime"];
        $array["temp"] = $data["current"]["temp_c"];
        $array["wind_kph"] = $data["current"]["wind_kph"];
        $array["description"] = $data["current"]["condition"]["text"];
        $array["image"] = $data["current"]["condition"]["icon"];
        $this->setWeatherToday($array);
        return $this->getWeatherToday();

    }

    private function fetchDayWeather()
    {

        $subject = $this->dbm->getData('select img_title from image where img_id = "'.$_GET["id"].'"');
        $search_url = "http://api.weatherapi.com/v1/forecast.json?key=dac85837b7d24e29be8120304221203&q=";
        $search_url .= $subject[0]["img_title"];
        $search_url .= "&days=1&aqi=no&alerts=no";

            $API_data = @file_get_contents($search_url);
            $data = json_decode($API_data,true);
            if($API_data === FALSE)
            {
                return null;
            }
            return $data;
    }


    public function fetchAllWeather($location)
    {
        $API_data = file_get_contents("http://api.weatherapi.com/v1/forecast.json?key=dac85837b7d24e29be8120304221203&q=".$location."&days=7&aqi=no&alerts=no");
        $data = json_decode($API_data,true);
        $this->setFetchData($data);
    }


    public function processAllWeatherData($data)
    {
        // TODO: Implement processAllWeatherData() method.
    }




    /**
     * @return mixed
     */
    public function getForecastArray()
    {
        return $this->forecast_array;
    }

    /**
     * @param mixed $forecast_array
     */
    public function setForecastArray($forecast_array): void
    {
        $this->forecast_array = $forecast_array;
    }

    /**
     * @return mixed
     */
    public function getWeatherToday()
    {
        return $this->weather_today;
    }

    /**
     * @param mixed $weather_today
     */
    public function setWeatherToday($weather_today): void
    {
        $this->weather_today = $weather_today;
    }

    /**
     * @return array
     */
    public function getFetchData():array
    {
        return $this->fetch_data;
    }

    /**
     * @param array $fetch_data
     */
    public function setFetchData($fetch_data)
    {
        $this->fetch_data = $fetch_data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFetchToday()
    {
        return $this->fetch_today;
    }

    /**
     * @param mixed $fetch_today
     */
    public function setFetchToday($fetch_today): void
    {
        $this->fetch_today = $fetch_today;
    }



}