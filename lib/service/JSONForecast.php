<?php

class JSONForecast implements FetchForecastInterface
{

    private $dbm;
    private $configuration;

    public function __construct($dbm,$configuration)
{
    $this->dbm = $dbm;
    $this->configuration = $configuration;
}

    /**
     * @return array|null
     */

    public function getCurrentWeatherData($img_id = 0): ?array
    {
        $data = $this->fetchCurrentWeather($img_id);


        if($data === null|| array_key_exists("error",$data)){return null;}
        $array = [];
        $array["city_name"] = $data["img_title"];
        $array["country_name"] = $data["land"];
        $array["date"] = $data["location"]["localtime"];
        $array["temp"] = $data["current"]["temp_c"];
        $array["wind_kph"] = $data["current"]["wind_kph"];
        $array["description"] = $data["current"]["condition"]["text"];
        $array["image"] = $data["current"]["condition"]["icon"];
        $array["humidity"] = $data["current"]["humidity"];
        $array["current"] = true;

        return $array;
    }

    /**
     * @return array|null
     */

    public function getAllWeatherData(): ?array
    {

        $data = $this->fetchAllWeather();
        $arr=[];
        if($data === null || array_key_exists("error",$data))
        {
            return null;
        }
        $count = count($data["forecast"]["forecastday"]);

        for($i = 0; $i < $count;$i++)
        {

            $arr[$i]["city_name"] = $data["img_title"];
            $arr[$i]["country_name"] = $data["land"];
            $arr[$i]["humidity"] = $data["forecast"]["forecastday"][$i]["day"]["avghumidity"];
            $arr[$i]["date"] = $data["forecast"]["forecastday"][$i]["date"];
            $arr[$i]["temp"] = $data["forecast"]["forecastday"][$i]["day"]["avgtemp_c"];
            $arr[$i]["wind_kph"] = $data["forecast"]["forecastday"][$i]["day"]["maxwind_kph"];
            $arr[$i]["description"] = $data["forecast"]["forecastday"][$i]["day"]["condition"]["text"];
            $arr[$i]["image"] = $data["forecast"]["forecastday"][$i]["day"]["condition"]["icon"];
        }

        return $arr;
    }

    /**
     * @return string
     */
    private function getAPIKey():string
    {
        $configuration = $this->configuration;
        return $configuration["API_key"];
    }

    /**
     * @return array|null
     */
    private function fetchCurrentWeather($img_id = 0):?array
    {

        if($img_id > 0)
            {
                $subject = $this->dbm->getData('select img_weather_location,img_title, lan_land from image inner join land on land.lan_id=img_lan_id where img_id = "'.$img_id.'"');

            }
        else
        {
            $subject = $this->dbm->getData('select img_weather_location,img_title, lan_land from image inner join land on land.lan_id=img_lan_id where img_id = "'.$_GET["id"].'"');
        }

        if($subject === null)
        {
            $_SESSION["msgs"][0] = "Beste ".$_SESSION["user"]->getUsrVoornaam()." deze stad werd niet gevonden.";
            header("location: steden.php");
        }
        $search_url = "http://api.weatherapi.com/v1/current.json?key=".$this->getAPIKey()."&q=";
        $search_url .= $subject[0]["img_weather_location"];
        $search_url .= "&lang=nl&days=1&aqi=no&alerts=no";

        $curl = curl_init($search_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $data= json_decode(curl_exec($curl),true);
        curl_close($curl);

            if($data === FALSE)
            {
                return null;
            }
            $data["land"] = $subject[0]["lan_land"];
            $data["img_title"] = $subject[0]["img_title"];
            return $data;

    }

    /**
     * @return array
     */
    private function fetchAllWeather():array
    {
        $subject = $this->dbm->getData('select img_title,img_weather_location, lan_land from image inner join land on land.lan_id=img_lan_id where img_id = "'.$_GET["id"].'"');
        if($subject === null)
        {
            $_SESSION["msgs"][0] = "Beste ".$_SESSION["user"]->getUsrVoornaam()." deze stad werd niet gevonden.";
            header("location: steden.php");
        }

        $search_url = "http://api.weatherapi.com/v1/forecast.json?key=".$this->getAPIKey()."&q=";
        $search_url .= $subject[0]["img_weather_location"];
        $search_url .= "&lang=nl&days=7&aqi=no&alerts=no";

        $curl = curl_init($search_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $data = json_decode(curl_exec($curl),true);
        curl_close($curl);

        $data["land"] = $subject[0]["lan_land"];
        $data["img_title"] = $subject[0]["img_title"];
        return $data;
    }


}