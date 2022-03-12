<?php

class Security
{

    private $csrf;

    public function __construct()
    {
        $this->csrf = $this->GenerateCSRF();
    }

    function GenerateCSRF( string $formname = "noformname" ): string
    {
        $csrf_key = bin2hex( random_bytes(32) );
        $csrf = hash_hmac( 'sha256', 'PHP1CURSUS SECRET KEY ' . $formname, $csrf_key );

        //store CSRF token in SESSION
        $_SESSION['lastest_csrf'] = $csrf;

        return $csrf;
    }

    /**
     * @return string
     */
    public function getCsrf(): string
    {
        return $this->csrf;
    }

    /**
     * @param string $csrf
     */
    public function setCsrf(string $csrf): void
    {
        $this->csrf = $csrf;
    }




}