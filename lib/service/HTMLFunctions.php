<?php

class HTMLFunctions
{

    private $currentFile;
    private $configuration;
    private $security;
    private $formElements;
    private $messageService;

    public function __construct(Security $security,FormElements $formElements,MessageService $messageService, array $configuration)
    {

        $this->configuration = $configuration;
        $this->security = $security;
        $this->formElements = $formElements;
        $this->messageService = $messageService;
    }

    public function PrintHead()
    {
        $head = file_get_contents("templates/head.html");
        print $head;
    }

    public function PrintJumbo( $title = "", $subtitle = "" )
    {

        $jumbo = file_get_contents("templates/jumbo.html");
        $jumbo = str_replace( "@jumbo_title@", $title, $jumbo );
        $jumbo = str_replace( "@jumbo_subtitle@", $subtitle, $jumbo );

        print $jumbo;
    }

    public function PrintNavbar()
    {
        $navbar = file_get_contents("templates/navbar.html");
        if(isset($_SESSION["user"]))
        {
            $arrayUserData = $_SESSION["user"]->getUserFullNameCapitals();
            foreach($arrayUserData as $key => $value)
            {
                $navbar = str_replace("@$key@",$value,$navbar);
            }
        }
        print $navbar;
    }

    public function MergeAllElements($data)
    {
        $template = $this->MergeViewWithData($data);
        $template = $this->MergeViewWithExtraElements($template);
        $template = $this->MergeViewWithErrors($template);
        $template = $this->RemoveEmptyErrorTags($template);
        print $template;
    }

    public function MergeViewWithData( $data)
    {

        $template = file_get_contents($this->getFileName());

        $returnvalue = "";

        foreach ( $data as $row )
        {
            $output = $template;

            foreach( array_keys($row) as $field )  //eerst "img_id", dan "img_title", ...
            {
                $output = str_replace( "@$field@", strval($row["$field"]), $output );
            }

            $returnvalue .= $output;
        }

        if ( $data == [] )
        {
            $returnvalue = $template;
        }

        return $returnvalue;
    }

    public function MergeViewWithExtraElements( $template)
    {
        //removes persistent tags
        $extra_elements = $this->configuration["data_keys_img"];

        $extra_elements['csrf_token'] = $this->security->getCsrf();

        if($this->getFileName() === "./templates/stad_form.html")
        {
            $extra_elements['select_land'] = $this->formElements->MakeSelect();
        };

        foreach ( $extra_elements as $key => $element )
        {
            $template = str_replace( "@$key@", $element, $template );
        }
        return $template;
    }

    public function MergeViewWithErrors( $template)
    {

        foreach ( $this->messageService->GetInputErrors() as $key => $error )
        {
            $template = str_replace( "@$key@", "<p style='color:red'>$error</p>", $template );
        }
        return $template;
    }

    public function RemoveEmptyErrorTags( $template)
    {

        $error_tags[0] = $this->configuration["data_keys_img"];

        foreach ( $error_tags as $row )
        {
            foreach( array_keys($row) as $field )  //eerst "img_id", dan "img_title", ...
            {

                $template = str_replace( "@$field" . "_error@", "", $template );
            }
        }

        return $template;
    }

    private function getFileName()
    {
        $min = strrpos($_SERVER["PHP_SELF"],"/");
        $max = strpos($_SERVER["PHP_SELF"],".php");
        $this->currentFile = "./templates".substr($_SERVER["PHP_SELF"],$min,$max-$min).".html";
        return $this->currentFile;
    }
}