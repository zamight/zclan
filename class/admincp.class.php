<?php

class admincp
{

    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function user()
    {
        global $classAction;

        switch ($classAction) {
            case "list":
                $this->index($this->user_list());
                break;
            case "edit":
                $this->index($this->user_edit());
                break;
            default:
                $this->index($this->user_index());
        }

        /* TODO LIST ALL USERS WITH A PAGINATION */

    }

    public function index($body = FALSE)
    {

        $templateList = "admin_index,admincp_index_body,admincp_nav_link";
        $templateListArray = explode(',', $templateList);

        $html = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $this->z->runPlugin("admincp_index_start");

        //Generate Menu
        $menuArray = array();
        $menuArray["index"] = array("icon" => "dashboard", "name" => "Dashboard");
        $menuArray["setting"] = array("icon" => "gear", "name" => "Settings");
        $menuArray["clan"] = array("icon" => "users", "name" => "Clans");
        $menuArray["plugin"] = array("icon" => "plug", "name" => "Plugins");
        $menuArray["user"] = array("icon" => "user", "name" => "Users");

        $this->z->runPlugin("admincp_index_menu", $menuArray);

        //Control Body.$$body_par;
        if (!$body) {
            eval("\$body = \"$admincp_index_body\";");
        }

        //Default page, and load pages
        $navMenus = "";
        foreach ($menuArray as $method => $menu_settings) {
            $icon = $menu_settings['icon'];
            $name = $menu_settings['name'];
            $current_nav = "";

            if ($this->z->getInput('m') == $method) {
                $current_nav = "class=\"w3-green\"";
            }

            eval("\$navMenus .= \"$admincp_nav_link\";");
        }

        //Count Users
        $countUsers = $this->z->db->countRows("users");
        eval("\$user_count = \"$countUsers\";");

        if ($this->z->user->isAdmin) {
            eval("\$html .= \"$admin_index\";");
        } else {
            $login = new login();
            $login->index();
        }

        $this->z->runPlugin("admincp_index_end", $html);

        print $html;
    }

    private function user_list($page = 0, $max = 20)
    {
        global $db;

        //Lets Get All Users.
        $all_users_sql = "SELECT * FROM users";
        $all_users = $db->fetchQuery($all_users_sql);

        $row_template = $this->z->db->getTemplate("admincp_user_rows");
        $default_template = $this->z->db->getTemplate("admincp_user_info_card");
        //$user_rank_template = $db->getTemplate("user_rank");

        $return_html = "";
        eval("\$return_html .= \"$row_template\";");

        $row_card_count = 1;

        foreach ($all_users as $index => $user) {
            //Reset Variables
            $user_rank = "";


/*            //Query All the Users Ranks, Display Ea
            $user_group_sql = "SELECT * FROM users_clan_groups WHERE `uid` = {$user['uid']}";
            $user_groups = $db->fetchQuery($user_group_sql);

            foreach ($user_groups as $user_group) {
                $user_clan_group_color = $db->fetchItem("color", "clan", "WHERE `id` = " . $user_group['clan_id']);
                $user_clan_group = $db->fetchItem("name", "clan", "WHERE `id` = " . $user_group['clan_id']);
                $user_clan_rank_color = $db->fetchItem("color", "clan_groups", "WHERE `id` = " . $user_group['group_id']);
                $user_clan_permission = $db->fetchItem("name", "clan_groups", "WHERE `id` = " . $user_group['group_id']);

                eval("\$user_rank .= \"$user_rank_template\";");
            }*/

            $user_rank = $this->z->db->generateUserHtmlRanks($user['uid']);

            //$user matchs db array.
            eval("\$return_html .= \"$default_template\";");

            if ($row_card_count % 4 == 0) {
                $return_html .= "</div>";
                eval("\$return_html .= \"$row_template\";");
            }
            $row_card_count++;
        }
        $return_html .= "</div>";

        return $return_html;
    }

    private function user_edit()
    {

        //If User Submitted Data?
        if (isset($_POST['submit'])) {
            $this->user_edit_save();
        }

        //User ID
        $userID = $this->z->getInput('v');

        //Load and Return Template.
        $admincp_user_edits = $this->z->db->getTemplate("admincp_user_edit");

        //Lets Get User Fields.
        //Query All the User Info
        $user_sql = "SELECT * FROM `users` WHERE `uid` = '{$userID}'";
        $user = $this->z->db->fetchQuery($user_sql);
        $user_edit = $user[0];

        //Reset Variables
        $user_rank = "";
        $user_edit_rank_template = $this->z->db->getTemplate("admincp_user_edit_clan_rank");

        //Query All the Users Ranks, Display Ea
        $user_group_sql = "SELECT * FROM users_clan_groups WHERE `uid` = {$userID}";
        $user_groups = $this->z->db->fetchQuery($user_group_sql);

        foreach ($user_groups as $user_group) {
            $user_clan_group_color = $this->z->db->fetchItem("color", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_group = $this->z->db->fetchItem("name", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_rank_color = $this->z->db->fetchItem("color", "clan_groups", "WHERE `id` = " . $user_group['group_id']);
            $user_clan_permission = $this->z->db->fetchItem("name", "clan_groups", "WHERE `id` = " . $user_group['group_id']);

            //Add Option Menu.
            //Ranks
            $ranks = array("Friend", "Recruit", "Corporal", "Sergeant", "Bronze", "Silver", "Gold", "Clan Owner",
                "Founder", "Admin", "Moderator", "Remove");
            $options = "";

            foreach ($ranks as $rank) {
                if ($rank == $user_clan_permission) {
                    $options .= "<option value=\"{$rank}\" selected>{$rank}</option>";
                } else {
                    $options .= "<option value=\"{$rank}\">{$rank}</option>";
                }
            }
            $options = "<select class=\"{$user_clan_rank_color}\" name=\"ranks[]\">{$options}</select>";
            eval("\$user_rank .= \"$user_edit_rank_template\";");
        }

        eval("\$return_html = \"$admincp_user_edits\";");
        return $return_html;
    }

    /*
     * Edit Users
     */

    private function user_edit_save()
    {

        $array = array(
            "display_name" => $z->getInput('display_name'),
            "avatar" => $z->getInput('avatar'),
            "post_count" => $z->getInput('post_count'),
            "thread_count" => $z->getInput('thread_count'),
            "email" => $z->getInput('email')
        );

        if(strlen($z->getInput('password')) > 7) {
            $array['password'] = password_hash($z->getInput('password'), PASSWORD_BCRYPT);
        }

        $where = "WHERE uid = {$z->getInput('v')}";

        $this->z->db->updateArray("users", $array, $where);
    }

    private function user_index()
    {
        global $db;
        $default_template = $this->z->db->getTemplate("admincp_user_index");
        eval("\$return_html = \"$default_template\";");
        return $return_html;
    }

}