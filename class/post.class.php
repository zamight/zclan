<?php

class post
{

    private $action = FALSE;
    private $postId = FALSE;

    public function index($clanName = "site")
    {

    }

    public function edit($clanName = "site")
    {
        global $db, $classMethod, $classAction, $z;

        $templateList = "post_edit_index";
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $db->getTemplate($templateName);
        }

        //Lets Redirect.
        //Any Value?
        //Lets Check to see if its the editor.
        //Lets See If A clan is set.
        if($clanName == "site") {
            //If The Forum isn't default. See if A Forum Was Picked.
            $this->action = $z->getInput('m');
            $this->postId = $z->getInput('a');
        }
        else {
            $this->action = $z->getInput('a');
            $this->postId = $z->getInput('v');
        }

        if($this->postUpdated()) {
            die("updated");
        }
        
        //Get the Msg and display in textarea.
        $message = $db->fetchItem("content", "post", "WHERE `id` = '{$this->postId}'");

        eval("\$html .= \"$post_edit_index\";");

        echo $html;
    }

    private function postUpdated()
    {
        global $z, $db, $user;

        //Was Form submitted?
        if($z->getInput('message'))
        {
            $table = array("content" => $z->getInput('message'));
            if($db->updateArray('post', $table, "WHERE `id` = {$this->postId} AND `uid` = {$user->uid}") > 0)
            {
                return true;
            }
        }

        return false;

    }

}










