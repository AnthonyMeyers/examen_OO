<?php

class PDOForecast implements FetchForecastInterface
{

    private $dbm;

    public function __construct($dbm)
    {
        $this->dbm = $dbm;
    }

    /**
     * get the weather data for a week
     * @return array
     */

    public function getCurrentWeatherData(): array
    {
        $data = $this->fetchDayWeather();
        $array["city_name"] = $data[0]["img_title"];
        $array["country_name"] = $data[0]["lan_land"];
        $array["date"] = $data[0]["img_weer_datum"];
        $array["temp"] = $data[0]["weer_temp"];
        $array["wind_kph"] = $data[0]["weer_wind"];
        $array["description"] = $data[0]["wbg_beschrijving"];
        $array["image"] = "./img/".$data[0]["weer_afbeelding"];
        return $array;
    }

    private function fetchDayWeather(): array
    {
        //Checks if there is any data already registered for today
        $date = date("Y-m-d");
        $sql =
            'select * from img_weer
            inner join image on image.img_id = img_weer.img_weer_id
            inner join land on land.lan_id = image.img_lan_id
            inner join weer on weer.weer_id = img_weer.weer_img_id
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            having img_weer_id = "' . $_GET["id"] . '" and img_weer_datum like "' . $date . '"';
        $data = $this->dbm->getData($sql);

        //If there is no data select a random line and add it to the img_weer table
        //If the user reruns the site it will be the same data
        if (count($data) === 0) {
            $data = $this->PDORegisterFakeWeather($date);
            return $data;
        }
        return $data;
    }

    /**
     * @param string $date
     * @return array
     */

    //Mocht het zijn dat er voor die dag geen weer is geregistreerd
    //Neem dan één van de vorige weerlijnen als voorbeeld en gebruik deze om het programma te laten werken
    //Dit is enkel voor functionaliteit en NIET de bedoeling om openbaar te worden gebruikt
    private function PDORegisterFakeWeather(string $date): array
    {

        $data = $this->dbm->getData("select * from weer order by RAND() limit 1");
        $this->dbm->ExecuteSQL('insert into img_weer (img_weer_id, img_weer_datum, weer_img_id)
                                values ("' . $_GET["id"] . '","' . $date . '","' . $data[0]["weer_id"] . '")');

        $sql =
            'select * from img_weer
            inner join image on image.img_id = img_weer.img_weer_id
            inner join land on land.lan_id = image.img_lan_id
            inner join weer on weer.weer_id = img_weer.weer_img_id
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            having img_weer_id = "' . $_GET["id"] . '" and img_weer_datum like "' . $date . '"';
        $data = $this->dbm->getData($sql);
        return $data;
    }

    public function fetchAllWeather()
    {
        $date = date("Y-m-d");

        for ($i = 0; $i < 3; $i++) {
            $sql =
                'select * from img_weer
            inner join image on image.img_id = img_weer.img_weer_id
            inner join land on land.lan_id = image.img_lan_id
            inner join weer on weer.weer_id = img_weer.weer_img_id
            inner join weer_beschrijving on weer.weer_wbg_id = weer_beschrijving.wbg_id
            having img_weer_id = "' . $_GET["id"] . '" and img_weer_datum like "' . $date . '"';
            $data[$i] = $this->dbm->getData($sql);

            if($data[$i] === null || count($data[$i]) === 0)

            {
                $data[$i] = $this->PDORegisterFakeWeather($date);
            }
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

        }

        return $data;
    }


    public function getAllWeatherData()
    {
        $data = $this->fetchAllWeather();

        foreach($data as $key=> $value)
        {
            $array[$key]["city_name"] = $value[0]["img_title"];
            $array[$key]["country_name"] = $value[0]["lan_land"];
            $array[$key]["date"] = $value[0]["img_weer_datum"];
            $array[$key]["temp"] = $value[0]["weer_temp"];
            $array[$key]["wind_kph"] = $value[0]["weer_wind"];
            $array[$key]["description"] = $value[0]["wbg_beschrijving"];
            $array[$key]["image"] = "./img/".$value[0]["weer_afbeelding"];

        }

        return $array;
    }
}