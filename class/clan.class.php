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
}