<?php

interface FetchForecastInterface
{

    /**
     * @return array
     */
    public function getCurrentWeatherData():?array;

    /**
     * @return array
     */
    public function getAllWeatherData():?array;



}