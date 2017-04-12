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
        // Navigate User To Correct Method
        switch ($this->z->url_param[1]) {
            case "verifyCode":
                $this->verifyCode();
                break;
            case "expiredorwrong":
                $this->expiredorwrong();
                break;
            default:
                $this->register();
        }
    }

    private function register()
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
        if ($this->z->getInput('registeration_submitted')) {
            $warnings = $this->anyRegisterationWarnings();
            if (!$warnings) {
                if ($this->createRegisteration()) {
                    $display = $register_success;
                } else {
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

        foreach ($this->formItems as $names => $labels) {
            $$names = $this->z->getInput($names); //Set all as Variables.
            if (!$$names) {
                $warnings[] = $labels . " Field Is Required";
            }
        }

        //Does the username exist?
        if ($this->z->db->getIDbyUsername($username)) {
            $warnings[] = "Username already taken";
        }
        
        //Does the email exist?
        if ($this->z->db->getIDbyEmail($email)) {
            $warnings[] = "Email already taken";
        }

        //Is the email address valid?
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $warnings[] = "Invalid email address";
        }

        //Is the email address long enough?
        if (strlen($password) < 6) {
            $warnings[] = "Password is not long enough";
        }

        //Do Passwords Match?
        if ($password != $retype_password) {
            $warnings[] = "Passwords do not match";
        }

        //If there are warnings make the templates.
        if (count($warnings) >= 1) {
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
            'avatar' => 'https://secure.runescape.com/m=avatar-rs/default_chat.png',
            'post_count' => '0',
            'thread_count' => '0',
            'signature' => '',
            'email' => $this->z->getInput('email'),
            'rsn' => $this->z->getInput('rsn'),
            'verified' => 0
        );

        $uid = $this->z->db->insertArray('users', $insertArray);

        if ($uid) {
            $code = $this->createVerifyCode($uid);
            $this->mailCode($this->z->getInput('email'), $code);
            return true;
        }

        return false;
    }

    private function createVerifyCode($uid)
    {
        $code = md5($uid . time());
        $insertArray = array(
            'uid' => $uid,
            'code' => $code
        );

        $this->z->db->insertArray('email_code', $insertArray);
        return $code;
    }

    private function expiredorwrong()
    {
        print "Incorrect token or expired.";
    }

    private function mailCode($email, $code)
    {
        $to      = $email;
        $subject = 'OLDRS.CC Verify Email';
        $message = "Congratulations for registering at oldrs.cc! To complete your registeration 
        you will need to click the link below to verify your email address is correct. <br /><br />
        <a href=\"{$this->z->site_url}register/verifyCode/{$code}\">Verify Email</a><br /><br />Thank You,<br />OLDRS.CC Staff";
        $headers = 'From: no-reply@oldrs.cc' . "\r\n" .
            'Reply-To: no-reply@oldrs.cc' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n" .
            'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    private function verifyCode()
    {
        $code = $this->z->url_param[2];

        if (!$code) {
            die($this->expiredorwrong());
        }

        // Does the code Exist?
        $codeSQL = $this->z->db->fetchQuery("SELECT * FROM `email_code` WHERE `code` = '{$code}'");
        $codeInfo = $codeSQL[0];

        if (!is_array($codeInfo)) {
            die($this->expiredorwrong());
        }

        // Update User

        $table = array("verified" => 1);
        $this->z->db->updateArray('users', $table, "WHERE `uid` = {$codeInfo['uid']}");
        $this->z->db->deleteItem('email_code', 'code', $codeInfo['code']);

        print "Success!";
    }

}
