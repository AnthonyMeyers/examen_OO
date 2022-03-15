<?php

class GoodWeather extends AbstractWeather
{

    public function getWeatherComment():string
    {
        if($this->getdate() === date("d-m-Y")) {

            return str_replace("@weather_description@","vandaag goed",parent::getWeatherComment());

        }
        return str_replace("@weather_description@","goed",parent::getWeatherComment());

    }

}