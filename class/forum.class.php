<?php


class forum
{

    private $forumName = FALSE;
    private $threadTitle = FALSE;
    public $clan_name = FALSE;

    public function index($clanName = "Site")
    {
        global $db, $classMethod, $classAction, $z;

        $templateList = "forum_index";
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $db->getTemplate($templateName);
        }

         // If the $clanName is set
         // Then set the $clanID to to the clanNames ID.

        $clan = $db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
        $clan = $clan[0];

         // If the clan cannot be found
         // Then run the invalid_clan function.

        if(!$clan) {
            $this->invalid_clan();
        }

        //Lets See If A clan is set.
        if($clanName == "Site") {
            //If The Forum isn't default. See if A Forum Was Picked.
            $this->forumName = $z->getInput('m');
            $this->threadTitle = $z->getInput('a');
        }
        else {
            $this->forumName = $z->getInput('a');
            $this->threadTitle = $z->getInput('v');
        }

        $this->clan_name = str_replace('_', ' ', $this->forumName);

        if($z->getInput('title')) {
            $this->create_thread();
        }

        if($z->getInput('new_thread')) {
            $threadID = explode('-', $this->threadTitle);
            $threadID = $threadID[1];
            $this->create_reply($threadID);
        }

        if(!empty($this->threadTitle)) {
            //Display Threads
            $body = $this->display_posts();
        }
        elseif(!empty($this->forumName)) {
            //Display Forum Threads
            $body = $this->index_forum($clan['id']);
        }
        else {
            //Display Categories
            $body = $this->index_categorys($clan['id']);
        }

        eval("\$html .= \"$forum_index\";");

        echo $html;
    }

    private function index_categorys($clanId = 1)
    {
	global $db;

	//Load Layout.
        $tpl = $db->getTemplate("forum_index_category");
        $tplForum = $db->getTemplate("forum_index_forum");
        $html = '';

        //Template is Loaded.
        // Lets Loop All the Categorys.
        $category_sql = 'SELECT * FROM category WHERE clanID = ' . $clanId;
        $categorys = $db->fetchQuery($category_sql);

        foreach($categorys as $category) {
            //Lets Load Each Forum Now.
            $forum_sql = 'SELECT * FROM forum WHERE categoryID = ' . $category['id'] . ' AND clanID = ' . $clanId;
            $forums = $db->fetchQuery($forum_sql);

            $forum_html = '';

            foreach($forums as $forum) {
                //Clean Url.
                $url = $_SERVER['REQUEST_URI'] . '/' . str_replace(' ', '_', $forum['name']);
                eval("\$forum_html .= \"$tplForum\";");
            }

            eval("\$html .= \"$tpl\";"); 
        } 

        return $html;
    }

    private function index_forum($clanId = 1)
    {
        global $db;

        //Load Layout.
        $tpl = $db->getTemplate("forum_threads");
        $tplThread = $db->getTemplate("forum_thread_list");
        $html = '';
        $url = '';


        //Template is Loaded.
        // Lets Loop All the Categorys.
        $forum_sql = 'SELECT * FROM forum WHERE `name` = "' . $this->clan_name . '" AND `clanID` = ' . $clanId;
        $forums = $db->fetchQuery($forum_sql);

        foreach($forums as $forum) {
            //Lets Load Each Forum Now.
            $threads_sql = 'SELECT * FROM threads WHERE forumID = ' . $forum['id'] . ' ORDER BY `id` DESC';
            $threads = $db->fetchQuery($threads_sql);
            //die(print_r($threads));
            $thread_html = '';

            foreach($threads as $thread) {
                //$thread['title'] = $bbcode->Parse($thread['title']);
                //$thread['conent'] = $bbcode->Parse($thread['conent']);
                $thread['url'] = $_SERVER['REQUEST_URI'] . '/' . str_replace(' ', '_', $thread['title']) . '-' . $thread['id'];
                eval("\$thread_html .= \"$tplThread\";");
            }

            eval("\$html .= \"$tpl\";");
        }

        return $html;
    }

    private function create_thread()
    {
        global $db, $user, $z;

        $name = str_replace('_', ' ', $this->forumName);

        $array = array(
            'forumID' => $db->fetchItem("id", "forum", "WHERE name = '{$name}'"),
            'uid' => $user->uid,
            'title' => $z->getInput('title'),
            'enabled' => 1
        );
        $db->insertArray('threads', $array);

        //Ight now Lets get the thread id.
        $thread = $db->fetchRow("SELECT * FROM `threads` WHERE `uid` = {$user->uid} ORDER BY `id` DESC");

        $this->create_reply($thread['id']);
    }

    private function display_posts()
    {
        global $db;

        //Include the BBCode Engine
        include("/nbbc-1.4.5/nbbc.php");
        $bbcode = new BBCode();

        //Lets Try To Load The Forum
        $threadId = explode('-', $this->threadTitle);
        $threadId = $threadId['1'];
        $post_html = '';
        $html = '';

        //Load Basic Templates
        $forum_post_tpl = $db->getTemplate("forum_posts");
        $forum_posts_list_tpl = $db->getTemplate("forum_posts_list");

        //set Title URL
        $backUrl = 'javascript:history.go(-1)';

        //Load The Thread Information.
        $thread = $db->fetchRow("SELECT * FROM `threads` WHERE `id` = '{$threadId}'");

        //Load The Forum Info.
        //Need Banner_url, Name, Description.
        $forum = $db->fetchRow("SELECT * FROM `forum` WHERE `id` = '{$thread['forumID']}'");

        //Post SQL and Loop.
        $posts = $db->fetchQuery("SELECT * FROM `post` WHERE `threadID` = '{$threadId}'");

        foreach($posts as $post) {
            $users = $db->fetchRow("SELECT * FROM `users` WHERE `uid` = '{$post['uid']}'");
            $ranks = $db->generateUserHtmlRanks($post['uid']);
            $post['content'] = $bbcode->Parse($post['content']);
            eval("\$post_html .= \"$forum_posts_list_tpl\";");
        }

        eval("\$html .= \"$forum_post_tpl\";");
        return $html;
    }

    private function create_reply($threadId)
    {
        global $user, $db, $z;

        $array = array(
            'threadID' => $threadId,
            'uid' => $user->uid,
            'content' => $z->getInput('message')
        );
        $db->insertArray('post', $array);
    }

    private function invalid_clan()
    {

    }

}
