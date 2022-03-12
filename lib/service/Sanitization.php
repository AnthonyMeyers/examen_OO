<?php

class Sanitization
{

    public function __construct()
    {

    }

    public function prepareForDatabase(array $arr):array
    {
        foreach ( $arr as $key => $value )
        {
            $arr[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
        }

        return $arr;
    }

    public function StripSpaces( array $arr ): array
    {
        foreach ( $arr as $key => $value )
        {
            $arr[$key] = trim($value);
        }

        return $arr;
    }

    public function ConvertSpecialChars( array $arr ): array
    {
        foreach ( $arr as $key => $value )
        {
            $arr[$key] = htmlspecialchars($value, ENT_QUOTES);
        }

        return $arr;
    }
}