<?php

class login
{

    public function index()
    {
        //{$login_index_forms} For forms/msgs.
        global $user, $db, $z, $getActions, $user;

        $templateList = 'login_index,login_index_form,login_index_loggedin,login_index_incorrect';
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach($templateListArray as $templateName)
        {
            $$templateName = $db->getTemplate($templateName);
        }

        $z->runPlugin("login_index_start");


        if(empty($_POST['submit']))
        {
            $login_index_incorrect = "";
        }
        else
        {
            eval("\$login_index_incorrect = \"$login_index_incorrect\";");
        }

        if($user->isLoggedIn)
        {
            eval("\$login_index_forms = \"$login_index_loggedin\";");
        }
        else
        {
            eval("\$login_index_forms = \"$login_index_form\";");
        }

        eval("\$html .= \"$login_index\";");

        $z->runPlugin("login_index_end", $html);

        print $html;
    }

    public function authenticate()
    {
        global $z, $db;
        //Grab Variables.

        $username = $z->getInput("username");
        $password = $z->getInput("password");

        $authorizeFetch = $db->fetchItem("uid", "users", "WHERE display_name = '{$username}' AND password = '{$password}'");

        if($authorizeFetch != FALSE AND $authorizeFetch > 0)
        {
            //Get Session Key
            $session_key = session_id();

            //Lets create the login session
            $insert_array = array(
                'uid' => $authorizeFetch,
                'agent' => 'something',
                'session_id' => $session_key
            );

            if($db->insertArray('session', $insert_array) > 0)
            {
                header('Location: http://localhost/zclan/admincp');
            }
        }

        $this->index();
    }

}