<?php

abstract class AbstractWeather
{

    private $city_name;
    private $country_name;
    private $date;
    private $weer_temp;
    private $weer_wind;
    private $weer_description;
    private $weer_image;
    private $current;

    public function __construct($description)
    {
        $this->weer_description = $description;
        $this->current = false;
    }

    public function getDayWeatherAsDataArray():array
    {
        $arr = [];
        foreach($this as $key => $value)
        {
            $arr[0][$key] = $value;
        }
        $arr[0]["weather_comment"] = $this->getWeatherComment();
        return $arr;
    }

    public function getCurrentWeatherAsDataArray():array
    {
        $arr = [];
        foreach($this as $key => $value)
        {
            if($key === "date")
            {
                if($this->current === true)
                {
                    $arr[0][$key] = "dit moment";
                }
                else
                {
                    $arr[0][$key] = "vandaag";
                }
            }elseif($key === "weer_wind")
            {
                $arr[0][$key] = $value." km/u";
            }
            else{
            $arr[0][$key] = $value;
            }
        }

        $arr[0]["weather_comment"] = "";
        return $arr;
    }

    /**
     * @return string
     */
    public function getWeatherComment():string
    {
        $wind = $this->getWeerWind() > 40 ? "veel" : "weinig";
        $comment = "<p>Het is over het algemeen @weather_description@ weer in ".$this->getCityName().".</p><p> De temperatuur bedraagd ".$this->getWeerTemp()."° C.</p>
                    <p>Er staat ".$wind." wind. De windsnelheid bedraagd ".$this->getWeerWind()." km per uur.</p>";
        return $comment;
    }

    /**
     * @return string
     */
    public function getCityName():string
    {
        return $this->city_name;
    }

    /**
     * @param string $city_name
     * @return AbstractWeather
     */
    public function setCityName(string $city_name): AbstractWeather
    {
        $this->city_name = $city_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryName():string
    {
        return $this->country_name;

    }

    /**
     * @param string $country_name
     * @return AbstractWeather
     */
    public function setCountryName(string $country_name): AbstractWeather
    {
        $this->country_name = $country_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate():string
    {
        return  date("d-m-Y",strtotime($this->date));
    }

    /**
     * @param string $localtime
     * @return AbstractWeather
     */
    public function setDate(string $localtime): AbstractWeather
    {
        $this->date = date("Y-m-d",strtotime($localtime));
        return $this;
    }

    /**
     * @return float
     */
    public function getWeerTemp():float
    {
        return $this->weer_temp;
    }

    /**
     * @param float $temp
     * @return AbstractWeather
     */
    public function setWeerTemp(float $temp):AbstractWeather
    {
        $this->weer_temp = $temp;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeerWind():float
    {
        return $this->weer_wind;
    }

    /**
     * @param float $wind_speed
     * @return AbstractWeather
     */
    public function setWeerWind(float $wind_speed): AbstractWeather
    {
        $this->weer_wind = $wind_speed;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeerDescription():string
    {
        return $this->weer_description;
    }

    /**
     * @param string $description
     * @return AbstractWeather;
     */
    public function setWeerDescription(string $description): AbstractWeather
    {
        $this->weer_description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeerImage()
    {
        return $this->weer_image;
    }

    /**
     * @param mixed
     * @return AbstractWeather
     */
    public function setWeerImage($image): AbstractWeather
    {
        $this->weer_image = $image;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param bool $current
     * @return
     */
    public function setCurrent(bool $current):AbstractWeather
    {
        $this->current = $current;
        return $this;
    }


}