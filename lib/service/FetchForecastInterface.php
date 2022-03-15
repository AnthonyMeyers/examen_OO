<?php

interface FetchForecastInterface
{

    /**
     * @return mixed
     */
    public function getCurrentWeatherData();

    /**
     * get the weather data for a week
     * @return array
     */

    /**
     * get the weather data for a day
     * @return array
     */

    public function getAllWeatherData();



}