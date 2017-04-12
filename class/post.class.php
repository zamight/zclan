<?php

class post
{

    private $action = false;
    private $postId = false;
    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
    }

    public function edit()
    {
        $clanName = $this->z->url_param['clan_name'];
        $templateList = "post_edit_index";
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }


        //If The Forum isn't default. See if A Forum Was Picked.
        $this->action = $this->z->url_param[1];
        $this->postId = $this->z->url_param[2];

        if ($this->postUpdated()) {
            die("updated");
        }
        
        //Get the Msg and display in textarea.
        $message = $this->z->db->fetchItem("content", "post", "WHERE `id` = '{$this->postId}'");

        eval("\$html .= \"$post_edit_index\";");

        echo $html;
    }

    private function postUpdated()
    {
        $postUpdated = false;
        //Was Form submitted?
        if ($this->z->getInput('message')) {
            $table = array("content" => $this->z->getInput('message'));

            $postUpdated = $this->z->db->updateArray('post', $table, "WHERE `id` = {$this->postId} AND `uid` = {$this->z->user->uid}") > 0;
        }

        return $postUpdated;
    }
}










