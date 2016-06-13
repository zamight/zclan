<?php


class forum
{

    private $forumName = FALSE;

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
        }
        else {
            $this->forumName = $z->getInput('a');
        }

        if(!empty($this->forumName)) {
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

        $forumNameClean = str_replace('_', ' ', $this->forumName);

        //Template is Loaded.
        // Lets Loop All the Categorys.
        $forum_sql = 'SELECT * FROM forum WHERE `name` = "' . $forumNameClean . '" AND `clanID` = ' . $clanId;
        $forums = $db->fetchQuery($forum_sql);

        foreach($forums as $forum) {
            //Lets Load Each Forum Now.
            $threads_sql = 'SELECT * FROM threads WHERE forumID = ' . $forum['id'];
            $threads = $db->fetchQuery($threads_sql);

            $thread_html = '';

            foreach($threads as $thread) {
                eval("\$thread_html .= \"$tplThread\";");
            }

            eval("\$html .= \"$tpl\";");
        }

        return $html;
    }

    private function invalid_clan()
    {

    }

}
