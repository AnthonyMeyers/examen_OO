<?php

abstract class AbstractWeather
{

    private $city_name;
    private $country_name;
    private $localtime;
    private $temp;
    private $wind_speed;
    private $description;
    private $image;

    public function __construct($description)
    {
        $this->setDescription($description);
    }

    public function getDayWeatherAsDataArray():array
    {
        $arr = [];
        foreach($this as $key => $value)
        {
            $arr[0][$key] = $value;
        }
        return $arr;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * @param mixed $city_name
     */
    public function setCityName($city_name): void
    {
        $this->city_name = $city_name;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->country_name;
    }

    /**
     * @param mixed $country_name
     */
    public function setCountryName($country_name): void
    {
        $this->country_name = $country_name;
    }

    /**
     * @return mixed
     */
    public function getLocaltime()
    {
        return $this->localtime;
    }

    /**
     * @param mixed $localtime
     */
    public function setLocaltime($localtime): void
    {
        $this->localtime = $localtime;
    }

    /**
     * @return mixed
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * @param mixed $temp
     */
    public function setTemp($temp): void
    {
        $this->temp = $temp;
    }

    /**
     * @return mixed
     */
    public function getWindSpeed()
    {
        return $this->wind_speed;
    }

    /**
     * @param mixed $wind_speed
     */
    public function setWindSpeed($wind_speed): void
    {
        $this->wind_speed = $wind_speed;
    }



    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }




}