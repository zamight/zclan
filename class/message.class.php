<?php

include(_DIR_ . "/trait/header.trait.php");

class message
{
    use header;

    private $clanName;
    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        $this->clanName = $this->z->url_param['clan_name'];

        // Direct User To Correct Function
        switch ($this->z->url_param[1]) {
            case "view":
                $this->showMessage();
                break;
            default:
                $this->listMessages();
        }
    }

    private function listMessages()
    {
        $templateList = 'message_list,message_index';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $userCache = array();
        $readTpl = '';
        $unreadTpl = '';

        //Load All Msgs For User.
        $msgSql = $this->z->db->fetchQuery("SELECT * FROM `message` WHERE `toUid` = {$this->z->user->uid} ORDER BY `id` DESC");

        foreach($msgSql as $message) {

            //Has the user been cached?
            if(!array_key_exists($message['fromUid'], $userCache)) {
                $userCache[$message['fromUid']] = $this->z->db->fetchRow("SELECT * FROM `users` WHERE `uid` = {$message['fromUid']}");
            }

            $author = $userCache[$message['fromUid']];

            // Truncate message preview if to long
            if(strlen($message['message']) > 100) {
                $message['message'] = substr($message['message'], 0, 100) . "...";
            }

            //If Msg has been viewed.
            if($message['viewed']) {
                //Put In Read Category
                eval("\$readTpl .= \"$message_list\";");
            }
            else {
                //Put In Unread Category
                eval("\$unreadTpl .= \"$message_list\";");
            }
        }



        //TODO: Setup Markup For Displaying read Messages

        eval("\$content .= \"$message_index\";");

        print $this->build($this->clanName, $content);
    }

    private function showMessage() {
        // Initialize Template Variables
        $templateList = 'message_list,message_index';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }
    }

}