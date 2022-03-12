<?php

class JSONForecast implements ForecastLoaderInterface
{

    private $fetch_data;
    private $fetch_today;
    private $forecast_array;
    private $weather_today;

    public function __construct()
{

}

    public function fetchAllWeather($location)
    {
        $API_data = file_get_contents("http://api.weatherapi.com/v1/forecast.json?key=dac85837b7d24e29be8120304221203&q=London&days=7&aqi=no&alerts=no");
        $data = json_decode($API_data,true);
        $this->setFetchData($data);
    }

    public function fetchDayWeather($location)
    {
        $API_data = file_get_contents("http://api.weatherapi.com/v1/forecast.json?key=dac85837b7d24e29be8120304221203&q=London&days=1&aqi=no&alerts=no");
        $data = json_decode($API_data,true);
        $this->setFetchToday($data);
    }

    public function processAllWeatherData($data)
    {
        // TODO: Implement processAllWeatherData() method.
    }

    public function processDayWeatherData()
    {
        // TODO: Implement processDayWeatherData() method.
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