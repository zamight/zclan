<?php

include(_DIR_ . "/trait/header.trait.php");

class manage
{
    use header;

    private $z = null;
    private $content = null;
    private $clanName = null;
    private $clanID = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {

        // Set ClanName
        $this->clanName = strtolower($this->z->url_param['clan_name']);

        if (!$this->z->user->isAdmin) {
            die($this->build($this->clanName, "You don't have permission."));
        }

        $this->clanID = $this->z->db->fetchItem("id", "clan", "WHERE name = '{$this->clanName}'");

        // Navigate User To Correct Method
        switch ($this->z->url_param[1]) {
            case "forum":
                $this->forum();
                break;
            case "user":
                $this->user();
                break;
            case "ban":
                $this->ban();
                break;
            case "setting":
                $this->setting();
                break;
            default:
                $this->navigation();
        }

        print $this->build($this->clanName, $this->content);
    }

    private function forum() {
        switch ($this->z->url_param[2]) {
            case "add":
                $this->forum_add();
                break;
            default:
                $this->forum_default();
        }
    }

    private function forum_add() {
        $templateList = 'manage_forum_add_index,drop_box';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        // If The User Hit The Submit Button
        if($this->z->getInput('forum_add_submitted')) {

            // Check For Any Errors
            $warnings = $this->anyErrorsForForum();
            if(!$warnings) {

                $array = array(
                    'name' => $this->z->getInput('name'),
                    'description' => $this->z->getInput('description'),
                    'enabled' => 1,
                    'sort' => $this->z->getInput('sort'),
                    'clanID' => $this->clanID,
                    'banner_url' => $this->z->getInput('banner_url')
                );

                if ($this->z->getInput('category') == -1) {
                    $this->z->db->insertArray('category', $array);
                    header("Location: {$this->z->site_urlc}forum");
                    exit();
                }
                else {
                    $array['categoryID'] = $this->z->getInput('category');
                    $array['parentID'] = 0;
                    $array['thread_count'] = 0;
                    $array['post_count'] = 0;
                    $array['lastReplyuid'] = 0;
                    $array['moderator_group'] = 0;
                    $array['moderator_uid'] = 0;

                    $this->z->db->insertArray('forum', $array);
                    header("Location: {$this->z->site_urlc}forum");
                    exit();
                }
            }
        }

        $drop_boxs = "";
        // Get All Categories
        $categorySQL = "SELECT id, name, banner_url FROM category WHERE clanID = '{$this->clanID}' ORDER BY sort ASC";
        $categories = $this->z->db->fetchQuery($categorySQL);

        // Go Through Each $categories
        foreach ($categories as $category) {
            eval("\$drop_boxs .= \"$drop_box\";");
        }

        // Make List For categories.

        eval("\$this->content = \"$manage_forum_add_index\";");
    }

    private function anyErrorsForForum()
    {
        $warnings = array();
        $warning_tempalte = $this->z->db->getTemplate('warning_red_alert');

        // Check If Name Field Is Filled Out
        if(empty($this->z->getInput('name'))) {
            $warnings[] = "A name is required!";
        }

        // Check If Sort Is An Integer
        if(!is_numeric($this->z->getInput('sort'))) {
            $warnings[] = "Sort ID must be an integer!";
        }

        //Is the email address valid?
        if(!filter_var($this->z->getInput('banner_url'), FILTER_VALIDATE_URL)) {
            $warnings[] = "Banner URL is not a valid URL!";
        }

        //If there are warnings make the templates.
        if(count($warnings) >= 1) {
            $return = '';
            $warning = implode("<br />", $warnings);
            eval("\$return .= \"$warning_tempalte\";");
            return $return;
        }

        return false;
    }

    private function forum_default() {
        $templateList = 'manage_forum_index,manage_forum_category,manage_forum_forum';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $manage_forum_categoryies = "";

        // Get All Categories
        $categorySQL = "SELECT id, name, banner_url FROM category WHERE clanID = '{$this->clanID}' ORDER BY sort ASC";
        $categories = $this->z->db->fetchQuery($categorySQL);

        // Go Through Each $categories
        foreach ($categories as $category) {

            $manage_forum_forums = "";

            // Get Each Forum
            $forumSQL = "SELECT name FROM forum WHERE categoryID = '{$category['id']}' ORDER BY sort DESC";
            $forums = $this->z->db->fetchQuery($forumSQL);

            // Go Though Each $forums
            foreach ($forums as $forum) {
                eval("\$manage_forum_forums .= \"$manage_forum_forum\";");
            }

            eval("\$manage_forum_categoryies .= \"$manage_forum_category\";");
        }

        eval("\$this->content = \"$manage_forum_index\";");
    }

    private function user() {
        switch ($this->z->url_param[2]) {
            case "add":
                $this->user_add();
                break;
            case "edit":
                $this->user_edit();
                break;
            case "delete":
                $this->user_delete();
                break;
            default:
                $this->user_default();
        }
    }

    private function user_delete() {
        $editUid = $this->z->url_param[3];

        $this->z->db->deleteItems('users_clan_groups', "WHERE `uid` = '{$editUid}' AND `clan_id` = '{$this->clanID}'");
        header("Location: {$this->z->site_urlc}manage/user");
    }

    private function user_edit() {

        $editUid = $this->z->url_param[3];

        $username = $this->z->db->getUsernameByID($editUid);

        // Save User
        if($this->z->getInput('change_settings_btn')) {
            $this->user_edit_save();
            header("Location: {$this->z->site_urlc}manage/user");
            die();
        }

        $tpl_drop_menu = $this->z->db->getTemplate("drop_menu");

        //Loop Through Ea Rank.
        $clanGroupsSQL = "SELECT * FROM clan_groups WHERE enabled = 1 ORDER BY sort DESC";
        $clanGroups = $this->z->db->fetchQuery($clanGroupsSQL);

        // Get User_clan_group.
        $rankID =  $this->z->db->fetchItem("group_id", "users_clan_groups", "WHERE `uid` = '{$editUid}' AND clan_id = '{$this->clanID}'");

        $drop_menu = '';

        // Go Though Each $forums
        foreach($clanGroups as $clanGroup) {
            $value = $clanGroup['id'];
            $name = $clanGroup['name'];
            $checked = "";

            if ($clanGroup['id'] == $rankID) {
                $checked = "selected";
            }

            eval("\$drop_menu .= \"$tpl_drop_menu\";");
        }


        // Setup Template
        $tpl = $this->z->db->getTemplate("manage_user_edit");
        eval("\$this->content = \"$tpl\";");
    }

    private function user_edit_save() {
        $rankID = $this->z->getInput('rank');
        $editUid = $this->z->url_param[3];
        $privilegeID =  $this->z->db->fetchItem("id", "privilege", "WHERE `clan_id` = '{$this->clanID}' AND clan_rank_id = '{$rankID}'");

        $array = array(
            'group_id' => $rankID,
            'privilege_id' => $privilegeID
        );

        $this->z->db->updateArray('users_clan_groups', $array, "WHERE `uid` = '{$editUid}' AND clan_id = '{$this->z->clanID}'");
    }

    private function user_add() {
        $clanDefaultPrivID =  $this->z->db->fetchItem("id", "privilege", "WHERE `clan_id` = '{$this->clanID}' AND clan_rank_id = '3'");

        if ($this->z->url_param[3]) {
            $array = array(
                'uid' => intval($this->z->url_param[3]),
                'clan_id' => $this->clanID,
                'group_id' => 3,
                'solo' => 0,
                'assisted' => 0,
                'points' => 0,
                'total' => 0,
                'privilege_id' => $clanDefaultPrivID
            );

            $this->z->db->insertArray('users_clan_groups', $array);

            header("Location: {$this->z->site_urlc}manage/user");
            die();
        }

        $templateList = 'manage_user_add_list,manage_user_add_block';
        $templateListArray = explode(',', $templateList);

        $manage_user_blocks = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        // Get Each Forum
        $usersSQL = "SELECT uid,display_name,avatar FROM users ORDER BY uid DESC";
        $users = $this->z->db->fetchQuery($usersSQL);

        // Go Though Each $forums
        foreach ($users as $user) {
            $rankID = $this->z->db->fetchItem("group_id", "users_clan_groups", "WHERE `uid` = '{$user['uid']}' AND clan_id = '{$this->clanID}'");

            if ($rankID != 2) {
                $ranks = $this->z->db->generateUserHtmlRanks($user['uid'], 1);
                eval("\$manage_user_blocks .= \"$manage_user_add_block\";");
            }
        }

        eval("\$this->content = \"$manage_user_add_list\";");
    }

    private function user_default() {
        $templateList = 'manage_user_list,manage_user_block';
        $templateListArray = explode(',', $templateList);

        $manage_user_blocks = "";

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        // Load Each Clan Member
        $clanMembersSql = "SELECT * FROM users_clan_groups WHERE clan_id = {$this->clanID}";
        $clanMembers = $this->z->db->fetchQuery($clanMembersSql);

        // Go Though Each $forums
        foreach ($clanMembers as $members) {
            // Get Each Forum
            $rankID = $this->z->db->fetchItem("group_id", "users_clan_groups", "WHERE `uid` = '{$members['uid']}' AND clan_id = '{$this->clanID}'");

            if ($rankID != 2) {
                $usersSQL = "SELECT uid,display_name,avatar FROM users WHERE uid = {$members['uid']}";
                $users = $this->z->db->fetchQuery($usersSQL);

                // Go Though Each $forums
                foreach ($users as $user) {
                    $ranks = $this->z->db->generateUserHtmlRanks($user['uid'], 2);
                    eval("\$manage_user_blocks .= \"$manage_user_block\";");
                }
            }
        }

        eval("\$this->content = \"$manage_user_list\";");
    }

    private function ban() {

    }

    private function setting() {

        if($this->z->getInput('change_settings_btn')) {
            $this->setting_save();
        }

        $warnings = '';

        $clanSQL = "SELECT * FROM clan WHERE `id` = '{$this->z->clanID}' LIMIT 1";
        $clan = $this->z->db->fetchQuery($clanSQL);
        $clan = $clan[0];

        if($clan['owner_uid'] <= 0) {
            $clanOwner = "N/A";
        }
        else {
            $clanOwner = $this->z->db->getUsernameByID($clan['id']);
        }

        if($clan['loot_hs_enabled']) {
            $hs_checked_yes = "checked";
        }
        else {
            $hs_checked_no = "checked";
        }

        $tpl = $this->z->db->getTemplate("manage_settings");
        eval("\$this->content = \"$tpl\";");
    }

    private function setting_save() {
        $array = array(
            'avatar' => $this->z->getInput('avatar'),
            'loot_hs_enabled' => $this->z->getInput('loot_highscore_enabled')
        );

        $this->z->db->updateArray('clan', $array, "WHERE `id` = '{$this->z->clanID}'");
    }

    private function setting_errors()
    {
        $warnings = array();
        $warning_tempalte = $this->z->db->getTemplate('warning_red_alert');

        $formItems = array(
            "user" => "Username",
            "loot_type" => "Loot type",
            "item_value" => "Item value",
            "item" => "Item"
        );

        foreach($formItems as $names => $labels) {
            $$names = $this->z->getInput($names); //Set all as Variables.
            if(!$$names) {
                $warnings[] = $labels . " field is required";
            }
        }

        //Does the username exist?
        if(!$this->z->db->getUsernameByID($user)) {
            $warnings[] = "User doesn't exist.";
        }

        //If there are warnings make the templates.
        if(count($warnings) >= 1) {
            $return = '';
            $warning = implode("<br />", $warnings);
            eval("\$return .= \"$warning_tempalte\";");
            return $return;
        }

        return false;
    }

    private function navigation() {
        $tpl = $this->z->db->getTemplate("manage_navigation_index");
        eval("\$this->content = \"$tpl\";");
    }
}