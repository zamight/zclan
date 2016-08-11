<?php

trait header
{
    private function build($clanName = 'site', $content = NULL)
    {
        //{$login_index_forms} For forms/msgs.
        global $db, $z, $user, $classMethod;

        $templateList = "site_default";
        $templateListArray = explode(',', $templateList);
        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $db->getTemplate($templateName);
        }

        $clan = $db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
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