<?php

class forum
{

    public function index($clanName = "Site")
    {
        global $db;

        $templateList = "forum_index";
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $db->getTemplate($templateName);
        }

         // If the $clanName is set
         // Then set the $clanID to to the clanNames ID.

        $clan = $db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
        $clan = $clan[0];

         // If the clan cannot be found
         // Then run the invalid_clan function.

        if(!$clan) {
            $this->invalid_clan();
        }

         // Set clan information for template.

         // Display the default layout.

        eval("\$html .= \"$forum_index\";");

        echo $html;
    }

    private function invalid_clan()
    {

    }

}