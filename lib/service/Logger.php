<?php

class Logger
{
    private $fp;
    private $logfile;

    public function __construct()
    {

        $this->logfile = $_SERVER["DOCUMENT_ROOT"]."/menu/backend/oop1.6/lib/log/log.txt";
        $this->fp = fopen($this->logfile,"a");

    }

    public function Log($msg)
    {

        $msgSave = date("Y-M-d H:i"). " => ".$msg. "\r\n";
        fwrite($this->fp, $msgSave);

    }

    public function ShowLog()
    {

        if (filesize($this->logfile) > 0) {

            $this->fp = fopen($this->logfile,"r");
            print nl2br(fread($this->fp,filesize($this->logfile)));

        }

        fclose($this->fp);

    }
}