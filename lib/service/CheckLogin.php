<?php

class CheckLogin
{

    private $dbm;
    private $sanitization;
    private $publicAccess;

public function __construct(DBManager $dbm, Sanitization $sanitization,PublicAcces $publicAccess)
{
    $this->dbm = $dbm;
    $this->sanitization = $sanitization;
    $this->publicAccess = $publicAccess;
}

function LoginCheck()
{


    if ( $_SERVER['REQUEST_METHOD'] == "POST" )
    {
        //controle CSRF token
        if ( ! key_exists("csrf", $_POST)) die("Missing CSRF");
        if ( ! hash_equals( $_POST['csrf'], $_SESSION['lastest_csrf'] ) ) die("Problem with CSRF");

        $_SESSION['lastest_csrf'] = "";

        //sanitization
        $_POST = $this->sanitization->prepareForDatabase($_POST);


        //validation
        $sending_form_uri = $_SERVER['HTTP_REFERER'];

        //Validaties voor het loginformulier
        if ( true )
        {
            if ( ! key_exists("usr_email", $_POST ) OR strlen($_POST['usr_email']) < 5 )
            {
                $_SESSION['input_errors']['usr_email_error'] = "Het emailadres is niet correct ingevuld";
            }
            if ( ! key_exists("usr_password", $_POST ) OR strlen($_POST['usr_password']) < 8 )
            {
                $_SESSION['input_errors']['usr_password_error'] = "Het wachtwoord is niet correct ingevuld";
            }
        }

        //terugkeren naar afzender als er een fout is
        if ( $_SESSION["input_errors"] && key_exists("input_errors" , $_SESSION ) AND count($_SESSION['input_errors']) > 0 )
        {
            $_SESSION['OLD_POST'] = $_POST;
            header( "Location: " . $sending_form_uri ); exit();
        }

        //search user in database
        $email = $_POST['usr_email'];
        $ww = $_POST['usr_password'];

        $sql = "SELECT * FROM user WHERE usr_email='$email' ";

        $data = $this->dbm->GetData($sql);

        if ( count($data) > 0 )
        {

            $checkPassword = false;
            $user = new user;
            foreach ( $data as $row )
            {
                $user->setUsrId($row["usr_id"]);
                $user->setUsrVoornaam($row["usr_voornaam"]);
                $user->setUsrNaam($row["usr_naam"]);
                $user->setUsrEmail($row["usr_email"]);
                $user->setUsrTelefoon($row["usr_telefoon"]);

                if ( password_verify( $ww, $row['usr_password'] ) ){ $checkPassword = true;};
            }

            if($checkPassword != false)
            {
                $_SESSION['user'] = $user;
                unset($_SESSION["msgs"]);
                $_SESSION['msgs'][] = "Welkom, " . $_SESSION['user']->getUsrVoornaam();
                header("Location: ./steden.php");
                die();

            }
            else
            {

                $this->publicAccess->redirect();
            }
        }

    }

}
}