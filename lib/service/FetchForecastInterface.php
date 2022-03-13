<?php

interface FetchForecastInterface
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

    public function processAllWeatherData($data);

    public function processDayWeatherData();

}