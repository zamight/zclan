<?php

class login
{

    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        if($this->z->getInput("submit")) {
            $this->authenticate();
        }

        // Navigate User To Correct Method
        switch ($this->z->url_param[1]) {
            default:
                $this->login_form();
        }
    }

    public function authenticate()
    {

        $username = $this->z->getInput("username");
        $password = $this->z->getInput("password");

        $authorizeFetch = $this->z->db->fetchRow("SELECT * FROM users WHERE display_name = '{$username}'");

        if(isset($authorizeFetch))
        {

            //Verify Password
            if(password_verify($password, $authorizeFetch['password'])) {
                //Get Session Key
                $session_key = session_id();

                //Lets create the login session
                $insert_array = array(
                    'uid' => $authorizeFetch['uid'],
                    'agent' => 'something',
                    'session_id' => $session_key
                );

                if ($this->z->db->insertArray('session', $insert_array) > 0) {
                    header("Location: {$this->z->site_urlc}forum");
                    die();
                }
            }
            return false;
        }
    }

    private function login_form() {
        $templateList = 'login_index,login_index_form,login_index_loggedin,login_index_incorrect';
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach($templateListArray as $templateName)
        {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $this->z->runPlugin("login_index_start");


        if(empty($_POST['submit']))
        {
            $login_index_incorrect = "";
        }
        else
        {
            eval("\$login_index_incorrect = \"$login_index_incorrect\";");
        }

        if($this->z->user->isLoggedIn)
        {
            //If User is logged in
            //Send User to defualt forums.
            header("Location: {$this->z->site_url}forum");
            exit();
        }
        else
        {
            eval("\$login_index_forms = \"$login_index_form\";");
        }

        eval("\$html .= \"$login_index\";");

        $this->z->runPlugin("login_index_end", $html);

        print $html;
    }

}