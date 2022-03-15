<?php

class BadWeather extends AbstractWeather
{

    public function getWeatherComment():string
    {
        if($this->getdate() === date("d-m-Y"))
        {

            return str_replace("@weather_description@","vandaag slecht",parent::getWeatherComment());

        }
        return str_replace("@weather_description@","slecht",parent::getWeatherComment());

    }

}