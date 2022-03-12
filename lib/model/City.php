<?php

class City
{
    private $img_id;
    private $img_filename;
    private $img_title;
    private $img_width;
    private $img_height;
    private $img_lan_id;
    private $img_date;



    /**
     * @return mixed
     */
    public function getImgId()
    {
        return $this->img_id;
    }

    /**
     * @param mixed $img_id
     */
    public function setImgId($img_id): void
    {
        $this->img_id = $img_id;
    }

    /**
     * @return mixed
     */
    public function getImgFilename()
    {
        return $this->img_filename;
    }

    /**
     * @param mixed $img_filename
     */
    public function setImgFilename($img_filename): void
    {
        $this->img_filename = $img_filename;
    }

    /**
     * @return mixed
     */
    public function getImgTitle()
    {
        return strtoupper($this->img_title);
    }

    /**
     * @param mixed $img_title
     */
    public function setImgTitle($img_title): void
    {
        $this->img_title = $img_title;
    }

    /**
     * @return mixed
     */
    public function getImgWidth()
    {
        return $this->img_width;
    }

    /**
     * @param mixed $img_width
     */
    public function setImgWidth($img_width): void
    {
        $this->img_width = $img_width;
    }

    /**
     * @return mixed
     */
    public function getImgHeight()
    {
        return $this->img_height;
    }

    /**
     * @param mixed $img_height
     */
    public function setImgHeight($img_height): void
    {
        $this->img_height = $img_height;
    }

    /**
     * @return mixed
     */
    public function getImgLanId()
    {
        return $this->img_lan_id;
    }

    /**
     * @param mixed $img_lan_id
     */
    public function setImgLanId($img_lan_id): void
    {
        $this->img_lan_id = $img_lan_id;
    }

    /**
     * @return mixed
     */
    public function getImgDate()
    {
        return $this->img_date;
    }

    /**
     * @param mixed $img_date
     */
    public function setImgDate($img_date): void
    {
        $this->img_date = $img_date;
    }

    public function getCityAsArray()
    {
        $arr = [];

        foreach( $this as $key => $value )
        {
            if($key == "img_title")
            {
                $arr[$key] = strtoupper($value);
            }
            else
            {
                $arr[$key] = $value;
            }

        }

        return $arr;
    }


}