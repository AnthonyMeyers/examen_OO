<?php

interface ForecastLoaderInterface
{

    /**
     * get the weatherdata for a week
     * @return array
     */
    public function fetchAllWeather($location);


    /**
     * get the weatherdata for a day
     * @return array
     */
    public function fetchDayWeather($location);



    public function processAllWeatherData($data);

    public function processDayWeatherData();

}