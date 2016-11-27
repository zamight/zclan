<?php

trait shoutbox
{
    private $shoutboxDisplayLimit = false;

    private function shoutbox_display($clanId = 1)
    {
        if(!$this->shoutbox_display_limit) {
            $this->shoutbox_set_display_limit(); //Default is 5.
        }
        
        //Load The Template
        $template = $this->z->db->getTemplate('shoutbox_row');

        //Lets Extract The shouts.
        $shoutboxSql = "SELECT * FROM shoutbox WHERE clanid = {$clanId} ORDER BY id DESC LIMIT 5";
        $shoutboxQuery = $this->z->db->fetchQuery($shoutboxSql);

        $html = '';

        //Loop through each entry.
        foreach($shoutboxQuery as $shoutbox) {
            $displayName = $this->z->db->getUsernameByID($shoutbox['uid']);
            $avatar = $this->z->db->fetchItem("avatar", "users", "WHERE uid = '{$shoutbox['uid']}'");

            eval("\$html .= \"$template\";");
        }

        //Return the Rows.
        return $html;
    }

    private function shoutbox_set_display_limit($i = 5)
    {
        $this->shoutboxDisplayLimit = $i;
    }

    private function shoutbox_add_message($clanId = 1)
    {
        $table = 'shoutbox';
        $array = array(
            'uid' => $this->z->user->uid,
            'clanid' => $clanId,
            'timestamp' => time(),
            'message' => $this->z->getInput('shout_message')
        );

        $this->z->db->insertArray($table, $array);
    }
}