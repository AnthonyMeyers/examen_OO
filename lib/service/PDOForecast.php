<?php

class PDOForecast implements FetchForecastInterface
{

    private $dbm;

    public function __construct($dbm)
    {
        $this->dbm = $dbm;
    }

    /**
     * @return array
     */
    public function getCurrentWeatherData($id = 0): array
    {
        $data = $this->fetchDayWeather($id);

        $array["city_name"] = $data[0]["img_title"];
        $array["country_name"] = $data[0]["lan_land"];
        $array["date"] = $data[0]["weer_datum"];
        $array["temp"] = $data[0]["weer_temp"];
        $array["wind_kph"] = $data[0]["weer_wind"];
        $array["description"] = $data[0]["wbg_beschrijving"];
        $array["image"] = "./img/".$data[0]["wbg_afbeelding"];
        $array["humidity"] = $data[0]["weer_luchtvochtigheid"];

        return $array;
    }

    /**
     * @return array
     */
    public function getAllWeatherData():array
    {

        $data = $this->fetchAllWeather();

        foreach($data as $key=> $value)
        {

            $array[$key]["city_name"] = $value[0]["img_title"];
            $array[$key]["country_name"] = $value[0]["lan_land"];
            $array[$key]["date"] = $value[0]["weer_datum"];
            $array[$key]["temp"] = $value[0]["weer_temp"];
            $array[$key]["wind_kph"] = $value[0]["weer_wind"];
            $array[$key]["description"] = $value[0]["wbg_beschrijving"];
            $array[$key]["image"] = "./img/".$value[0]["wbg_afbeelding"];
            $array[$key]["humidity"] = $value[0]["weer_luchtvochtigheid"];

        }

        return $array;

    }

    /**
     * @param $date
     * @return string
     */
    private function fetchSQLWeather($date,$id = 0):string
    {
        if($id > 0)$search_value = $id;
        else $search_value = $_GET["id"];

        return 'select * from weer
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            inner join image on image.img_id= weer.weer_img_id
            inner join land on land.lan_id = image.img_lan_id
            having weer.weer_img_id = "' . $search_value . '" and weer.weer_datum like "' . $date . '"';
    }

    /**
     * @return array
     */
    private function fetchDayWeather($id = 0): array
    {
        //Checks if there is any data already registered for today
        $date = date("Y-m-d");

        $data = $this->dbm->getData($this->fetchSQLWeather($date,$id));

        //If there is no data select a random line and add it to the img_weer table
        //If the user reruns the site it will be the same data
        if (count($data) === 0) {
            $data = $this->PDORegisterFakeWeather($date);
            return $data;
        }
        return $data;
    }

    /**
     * @return array
     */
    private function fetchAllWeather():?array
    {
        $date = date("Y-m-d");

        //If no data found for that day make it
        for ($i = 0; $i < 7; $i++) {

            $data[$i] = $this->dbm->getData($this->fetchSQLWeather($date));

            if($data[$i] === null || count($data[$i]) === 0)
            {
                $data[$i] = $this->PDORegisterFakeWeather($date);
            }
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

        }

        return $data;
    }

    //Mocht het zijn dat er voor die dag geen weer is geregistreerd
    //Neem dan één van de vorige weerlijnen als voorbeeld en gebruik deze om het programma te laten werken
    //Dit is enkel voor functionaliteit en NIET de bedoeling om openbaar te worden gebruikt
    /**
     * @param string $date
     * @return array
     */
    private function PDORegisterFakeWeather(string $date): array
    {

        $data = $this->dbm->getData("select * from weer order by RAND() limit 1");

        $this->dbm->ExecuteSQL('insert into weer (weer_temp, weer_wind, weer_wbg_id,weer_luchtvochtigheid, weer_img_id,weer_datum)
                                values (" '.$data[0]["weer_temp"] .'",
                                        " '.$data[0]["weer_wind"] .'",
                                        " '.$data[0]["weer_wbg_id"] .'",
                                        "'.$data[0]["weer_luchtvochtigheid"].'",
                                        "'.trim($_GET["id"]).'",
                                        "'.$date.'")');

        $data = $this->dbm->getData($this->fetchSQLWeather($date));

        return $data;
    }

}