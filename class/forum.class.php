<?php

//Include Traits
include("/trait/shoutbox.trait.php");
include("/trait/header.trait.php");

class forum
{

    use shoutbox;
    use header;

    private $forumName = FALSE;
    private $threadTitle = FALSE;
    public $clan_name = FALSE;
    private $z = null;
    
    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        $templateList = "forum_index";
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

         // If the $clanName is set
         // Then set the $clanID to to the clanNames ID.
        $clanName = strtolower($this->z->url_param['clan_name']);

        $clan = $this->z->db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
        $clan = $clan[0];

         // If the clan cannot be found
         // Then run the invalid_clan function.

        if(!$clan) {
            $this->invalid_clan();
        }

        //Was a new shout submitted?
        if($this->z->getInput('shout_new')) {
            $this->shoutbox_add_message($clan['id']);
        }

        //Setup Shoubox
        $shoutboxRows = $this->shoutbox_display($clan['id']);


        $this->forumName = $this->z->url_param[1];
        $this->threadTitle = $this->z->url_param[2];

        $this->clan_name = str_replace('_', ' ', $this->forumName);

        if($this->z->getInput('title')) {
            $this->create_thread();
        }

        if($this->z->getInput('new_thread')) {
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

        //eval("\$html .= \"$forum_index\";");

        //echo $html;

        eval("\$content .= \"$forum_index\";");

        print $this->build($clanName, $content);
    }

    private function index_categorys($clanId = 1)
    {
	//Load Layout.
        $tpl = $this->z->db->getTemplate("forum_index_category");
        $tplForum = $this->z->db->getTemplate("forum_index_forum");
        $html = '';

        //Template is Loaded.
        // Lets Loop All the Categorys.
        $category_sql = 'SELECT * FROM category WHERE clanID = ' . $clanId;
        $categorys = $this->z->db->fetchQuery($category_sql);

        foreach($categorys as $category) {
            //Lets Load Each Forum Now.
            $forum_sql = 'SELECT * FROM forum WHERE categoryID = ' . $category['id'] . ' AND clanID = ' . $clanId;
            $forums = $this->z->db->fetchQuery($forum_sql);

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
        //Load Layout.
        $tpl = $this->z->db->getTemplate("forum_threads");
        $tplThread = $this->z->db->getTemplate("forum_thread_list");
        $html = '';
        $url = '';


        //Template is Loaded.
        // Lets Loop All the Categorys.
        $forum_sql = 'SELECT * FROM forum WHERE `name` = "' . $this->clan_name . '" AND `clanID` = ' . $clanId;
        $forums = $this->z->db->fetchQuery($forum_sql);

        foreach($forums as $forum) {
            //Lets Load Each Forum Now.
            $threads_sql = 'SELECT * FROM threads WHERE forumID = ' . $forum['id'] . ' ORDER BY `id` DESC';
            $threads = $this->z->db->fetchQuery($threads_sql);
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
        $name = str_replace('_', ' ', $this->forumName);

        $array = array(
            'forumID' => $this->z->db->fetchItem("id", "forum", "WHERE name = '{$name}'"),
            'uid' => $this->z->user->uid,
            'title' => $this->z->getInput('title'),
            'enabled' => 1
        );
        $this->z->db->insertArray('threads', $array);

        //Ight now Lets get the thread id.
        $thread = $this->z->db->db->lastInsertId();
        $this->z->db->addThreadCountByUid($this->z->user->uid);
        $this->create_reply($thread);
    }

    private function display_posts()
    {
        //Include the BBCode Engine
        include("/nbbc-1.4.5/nbbc.php");
        $bbcode = new BBCode();

        //Lets Try To Load The Forum
        $threadId = explode('-', $this->threadTitle);
        $threadId = $threadId['1'];
        $post_html = '';
        $html = '';

        //Load Basic Templates
        $forum_post_tpl = $this->z->db->getTemplate("forum_posts");
        $forum_posts_list_tpl = $this->z->db->getTemplate("forum_posts_list");

        //set Title URL
        $backUrl = 'javascript:history.go(-1)';

        //Load The Thread Information.
        $thread = $this->z->db->fetchRow("SELECT * FROM `threads` WHERE `id` = '{$threadId}'");

        //Load The Forum Info.
        //Need Banner_url, Name, Description.
        $forum = $this->z->db->fetchRow("SELECT * FROM `forum` WHERE `id` = '{$thread['forumID']}'");

        //Post SQL and Loop.
        $posts = $this->z->db->fetchQuery("SELECT * FROM `post` WHERE `threadID` = '{$threadId}'");

        foreach($posts as $post) {
            $users = $this->z->db->fetchRow("SELECT * FROM `users` WHERE `uid` = '{$post['uid']}'");
            $ranks = $this->z->db->generateUserHtmlRanks($post['uid']);
            $post['content'] = $bbcode->Parse($post['content']);
            eval("\$post_html .= \"$forum_posts_list_tpl\";");
        }

        eval("\$html .= \"$forum_post_tpl\";");
        return $html;
    }

    private function create_reply($threadId)
    {

    }

    private function invalid_clan()
    {

    }

}
