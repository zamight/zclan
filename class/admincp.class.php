<?php

class admincp
{

    public function index($body = FALSE)
    {
        //{$login_index_forms} For forms/msgs.
        global $db, $z, $user, $classMethod;

        $templateList = "admin_index,admincp_index_body,admincp_nav_link";
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach($templateListArray as $templateName)
        {
            $$templateName = $db->getTemplate($templateName);
        }

        $z->runPlugin("admincp_index_start");

        //Generate Menu
        $menuArray = array();
        $menuArray["index"] = array("icon" => "dashboard", "name" => "Dashboard");
        $menuArray["setting"] = array("icon" => "gear", "name" => "Settings");
        $menuArray["clan"] = array("icon" => "users", "name" => "Clans");
        $menuArray["plugin"] = array("icon" => "plug", "name" => "Plugins");
        $menuArray["user"] = array("icon" => "user", "name" => "Users");

        $z->runPlugin("admincp_index_menu", $menuArray);
        
        //Control Body.$$body_par;
        if(!$body) 
        {
            eval("\$body = \"$admincp_index_body\";");
        }
        
        //Default page, and load pages
        $navMenus = "";
        foreach($menuArray as $method => $menu_settings)
        {
            $icon = $menu_settings['icon'];
            $name = $menu_settings['name'];
            $current_nav = "";

            if($z->getInput('m') == $method)
            {
                $current_nav = "class=\"w3-green\"";
            }

            eval("\$navMenus .= \"$admincp_nav_link\";");
        }

        //Count Users
        $countUsers = $db->countRows("users");
        eval("\$user_count = \"$countUsers\";");

        if($user->isAdmin)
        {
            eval("\$html .= \"$admin_index\";");
        }
        else
        {
            $login = new login();
            $login->index();
        }

        $z->runPlugin("admincp_index_end", $html);

        print $html;
    }

    public function user()
    {
        global $classAction;
        
        switch ($classAction)
        {
            case "list":
                $this->index($this->user_list());
                break;
            default:
                $this->index($this->user_index());
        }
        
        /* TODO LIST ALL USERS WITH A PAGINATION */
        
    }
    
    private function user_index()
    {
        global $db;
        $default_template = $db->getTemplate("admincp_user_index");
        eval("\$return_html = \"$default_template\";");
        return $return_html;
    }
    
    private function user_list($page = 0, $max = 20)
    {
        global $db;
        
        //Lets Get All Users.
        $all_users_sql = "SELECT * FROM users";
        $all_users = $db->fetchQuery($all_users_sql);
        
        $row_template = $db->getTemplate("admincp_user_rows");
        $default_template = $db->getTemplate("admincp_user_info_card");
        $user_rank_template = $db->getTemplate("user_rank");
        
        $return_html = "";
        eval("\$return_html .= \"$row_template\";");
        
        $row_card_count = 1;
        
        foreach($all_users as $index => $user)
        {
            //Reset Variables
            $user_rank = "";
            
            
            //Query All the Users Ranks, Display Ea
            $user_group_sql = "SELECT * FROM users_clan_groups WHERE `uid` = {$user['uid']}";
            $user_groups = $db->fetchQuery($user_group_sql);
            
            foreach($user_groups as $user_group)
            {
                $user_clan_group_color = $db->fetchItem("color", "clan", "WHERE `id` = " . $user_group['clan_id']);
                $user_clan_group = $db->fetchItem("name", "clan", "WHERE `id` = " . $user_group['clan_id']);
                $user_clan_rank_color = $db->fetchItem("color", "clan_groups", "WHERE `id` = " . $user_group['group_id']);
                $user_clan_permission = $db->fetchItem("name", "clan_groups", "WHERE `id` = " . $user_group['group_id']);

                eval("\$user_rank .= \"$user_rank_template\";");
            }
            
            //$user matchs db array.
            eval("\$return_html .= \"$default_template\";");
            
            if($row_card_count % 4 == 0)
            {
                $return_html .= "</div>";
                eval("\$return_html .= \"$row_template\";");
            }
            $row_card_count++;
        }
        $return_html .= "</div>";
        
        return $return_html;
    }

}





























