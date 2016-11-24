<?php

class register
{

    private $z = null;

    private $formItems = array(
    "username" => "Username",
    "email" => "Email",
    "password" => "Password",
    "retype_password" => "Retype Password",
    "rsn" => "RSN",
    );

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        $templateList = 'register_index,register_success';
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $display = $register_index;

        //Verify Registeration
        $warnings = '';
        if($this->z->getInput('registeration_submitted')) {
            $warnings = $this->anyRegisterationWarnings();
            if (!$warnings) {
                if($this->createRegisteration()) {
                    $display = $register_success;
                }
                else {
                    //$display = $this->z->db->db->errorInfo();
                }
            }
        }

        eval("\$html .= \"$display\";");

        print $html;
    }

    private function anyRegisterationWarnings()
    {
        $warnings = array();
        $warning_tempalte = $this->z->db->getTemplate('warning_red_alert');

        foreach($this->formItems as $names => $labels) {
            $$names = $this->z->getInput($names); //Set all as Variables.
            if(!$$names) {
                $warnings[] = $labels . " Field Is Required";
            }
        }

        //Does the username exist?
        if($this->z->db->getIDbyUsername($username)) {
            $warnings[] = "Username already taken";
        }
        
        //Does the email exist?
        if($this->z->db->getIDbyEmail($email)) {
            $warnings[] = "Email already taken";
        }

        //Is the email address valid?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $warnings[] = "Invalid email address";
        }

        //Is the email address long enough?
        if(strlen($password) < 6) {
            $warnings[] = "Password is not long enough";
        }

        //Do Passwords Match?
        if($password != $retype_password) {
            $warnings[] = "Passwords do not match";
        }

        //If there are warnings make the templates.
        if(count($warnings) >= 1) {
            $return = '';
            $warning = implode("<br />", $warnings);
            eval("\$return .= \"$warning_tempalte\";");
            return $return;
        }

        return false;
    }

    private function createRegisteration()
    {
        $password = password_hash($this->z->getInput('password'), PASSWORD_BCRYPT);

        $insertArray = array(
            'display_name' => $this->z->getInput('username'),
            'password' => $password,
            'layout' => 'w3_',
            'avatar' => 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif',
            'post_count' => '0',
            'thread_count' => '0',
            'signature' => '',
            'email' => $this->z->getInput('email'),
            'rsn' => $this->z->getInput('rsn')
        );

        if($this->z->db->insertArray('users', $insertArray)) {
            return true;
        }

        return false;
    }

}
