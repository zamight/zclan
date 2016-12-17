<?php

class clan
{
    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        $class = $this->z->url_param[0];
        if($class == 'forum') {
            $this->forum();
        }
        elseif($class == 'message') {
            $this->message();
        }
        elseif($class == 'manage') {
            $this->manage();
        }
        elseif($class == 'loot_highscores') {
            $this->loot_highscores();
        }
        elseif($class == 'logout') {
            $this->logout();
        }
        else {
            $this->forum();
        }

    }

    public function forum()
    {
        global $z;
        $forum = new forum($this->z);
        $forum->index($z->getInput('c'));
    }

    public function logout()
    {
        global $z;
        $logout = new logout($this->z);
        $logout->index($z->getInput('c'));
    }

    public function message()
    {
        global $z;
        $forum = new message($this->z);
        $forum->index($z->getInput('c'));
    }

    public function manage() {
        global $z;
        $manage = new manage($this->z);
        $manage->index($z->getInput('c'));
    }

    public function loot_highscores() {
        global $z;
        $loot_highscores = new loot_highscores($this->z);
        $loot_highscores->index($z->getInput('c'));
    }
}