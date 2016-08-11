<?php

class clan
{
    public function index()
    {
        global $z;
        $clanName = $z->getInput('c');
        $clanPage = $z->getInput('m');
        $clanAction = $z->getInput('a');

        if($clanPage == 'forum') {
            $this->forum();
        }
        if($clanPage == 'message') {
            $this->message();
        }

    }

    public function forum()
    {
        global $z;
        $forum = new forum();
        $forum->index($z->getInput('c'));
    }

    public function message()
    {
        global $z;
        $forum = new message();
        $forum->index($z->getInput('c'));
    }
}