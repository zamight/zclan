<?php

include("/trait/header.trait.php");

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
        $this->listMessages();
        //print $this->build();
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
        $msgSql = $this->z->db->fetchQuery("SELECT * FROM `message` WHERE `toUid` = {$this->z->user->uid}");

        foreach($msgSql as $message) {

            //Has the user been cached?
            if(!array_key_exists($message['fromUid'], $userCache)) {
                $userCache[$message['fromUid']] = $this->z->db->fetchRow("SELECT * FROM `users` WHERE `uid` = {$message['fromUid']}");
            }

            $author = $userCache[$message['fromUid']];

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
}