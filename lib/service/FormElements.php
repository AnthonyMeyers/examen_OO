<?php

class FormElements
{

        private $dbm;
        private $cityLoader;
        private $configuration;
        private $city;

    public function __construct(DBManager $dbm, CityLoader $cityLoader,array $configuration)
    {
        $this->dbm = $dbm;
        $this->cityLoader = $cityLoader;
        $this->configuration = $configuration;
    }

    function MakeSelect()
    {
        $this->city = $this->cityLoader->findOneById($_GET["img_id"]);
        $country = $this->city->getImgLanId();
        $fkey = $this->configuration["make_select_stad"][0];
        $sql = $this->configuration["make_select_stad"][2];
        $dbm = $this->dbm;
        $select = "<select id=$fkey name=$fkey value=$country>";
        $select .= "<option value='0'></option>";

        $data = $dbm->GetData($sql);

        foreach ( $data as $row )
        {
            if ( $row[0] == $country ) $selected = " selected ";
            else $selected = "";

            $select .= "<option $selected value=" . $row[0] . ">" . $row[1] . "</option>";
        }

        $select .= "</select>";

        return $select;
    }

}