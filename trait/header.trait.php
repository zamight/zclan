<?php

trait header
{
    private function build($clanName = 'site', $content = NULL)
    {
        $templateList = "site_default";
        $templateListArray = explode(',', $templateList);
        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $clan = $this->z->db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
        $clan = $clan[0];

        
        if($clan['avatar'] == "") {
            $headerlogo = $clan['name'];
        }
        else {
            $headerlogo = "<img src='{$clan['avatar']}' />";
        }

        eval("\$html .= \"$site_default\";");
        return $html;
    }
}