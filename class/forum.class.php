<?php


class forum
{

    public function index($clanName = "Site")
    {
        global $db, $classMethod;

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

         // Set clan information for template.

         // Display the default layout.

        //Lets Setup and Display category Empty
        $body = $this->index_categorys($clan['id']);

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
            $forum_sql = 'SELECT * FROM forum WHERE categoryID = ' . $category['id'];
            $forums = $db->fetchQuery($forum_sql);

            $forum_html = '';

            foreach($forums as $forum) {
                eval("\$forum_html .= \"$tplForum\";");
            }

            eval("\$html .= \"$tpl\";"); 
        } 

        return $html;
    }

    private function invalid_clan()
    {

    }

}
