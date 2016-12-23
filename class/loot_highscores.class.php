<?php

include(_DIR_ . "/trait/header.trait.php");

class loot_highscores
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
        $this->clanID = $this->z->db->fetchItem("id", "clan", "WHERE name = '{$this->clanName}'");

        // Navigate User To Correct Method
        switch ($this->z->url_param[1]) {
            case "add":
                $this->add_item();
                break;
            case "drop_log":
                $this->showUserLoots();
                break;
            case "delete":
                $this->deleteLoot();
                break;
            default:
                $this->display_highscore();
        }

        print $this->build($this->clanName, $this->content);
    }

    private function add_item() {
        if (!$this->z->user->isAdmin) {
            die("You don't have privilege.");
        }

        $templateList = 'loot_highscores_add_item,loot_highscores_add_member_list';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        // If submitted check for errors.
        //Verify Registeration
        $warnings = '';
        if($this->z->getInput('add_loot')) {
            $warnings = $this->anyLootErrors();
            if (!$warnings) {
                $this->createLoot();
                header("Location: {$this->z->site_urlc}loot_highscores");
                die();
            }
        }

        $user_list_drop_boxs = "";
        // Get All Categories
        $userGroupSql = "SELECT * FROM users_clan_groups WHERE clan_id = '{$this->clanID}'";
        $userGroup = $this->z->db->fetchQuery($userGroupSql);

        foreach ($userGroup as $userG) {
            $username = $this->z->db->getUsernameByID($userG['uid']);
            eval("\$user_list_drop_boxs .= \"$loot_highscores_add_member_list\";");
        }

        eval("\$this->content = \"$loot_highscores_add_item\";");
    }

    private function anyLootErrors()
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

    private function showUserLoots() {
        $userID = $this->z->db->getIDbyUsername($this->z->url_param[2]);
        $username = $this->z->db->getUsernameByID($userID);

        $user_clan_groupID = $this->z->db->fetchItem('id', 'users_clan_groups', "WHERE `uid` = '{$userID}' AND  `clan_id` = '{$this->clanID}'");

        $tpl_index = $this->z->db->getTemplate('loot_highscores_drop_log');
        $loot = $this->z->db->getTemplate('loot_highscore_list_user_drops');

        $types = array(1 => "Solo", 2 => "Assisted");

        $loot_table = "";

        //Get Items
        $itemsJSON = file_get_contents($this->z->site_url . "rs_items.json");
        $itemsJSON = json_decode($itemsJSON, true);
        $itemsJSON = $itemsJSON['items'];

        // Get All Users Loots
        $userLootsSQL = "SELECT * FROM loot_logs WHERE `user_clan_groups_id` = '{$user_clan_groupID}' ORDER BY `id` DESC";
        $items = $this->z->db->fetchQuery($userLootsSQL);

        foreach($items as $item) {
            $itemName = '';
            foreach($itemsJSON as $name) {
                if($name['id'] == $item['item_id']) {
                    $itemName = $name['name'];
                    break;
                }
            }

            eval("\$loot_table .= \"$loot\";");
        }


        eval("\$this->content = \"$tpl_index\";");

    }

    private function deleteLoot() {
        //Get Loot ID
        $id = $this->z->url_param[2];

        $lootSQL = "SELECT * FROM loot_logs WHERE `id` = '{$id}' LIMIT 1";
        $loot = $this->z->db->fetchQuery($lootSQL);
        $loot = $loot[0];
        $solo = 0;
        $assisted = 0;
        $points = 0;

        if($loot['type'] == 2) {
            $assisted = $loot['value'];
        }
        else {
            $solo = $loot['value'];
        }

        if($loot['value'] >= 1000000*61) {
            $points = 3;
        }
        elseif($loot['value'] >= 1000000*31) {
            $points = 2;
        }
        elseif($loot['value'] >= 1000000) {
            $points = 1;
        }

        $this->z->db->updateLootPoints(-$solo, -$assisted, -$points, $loot['user_clan_groups_id']);

        $this->z->db->deleteItem('loot_logs', 'id', $id);
        header("Location: {$this->z->site_urlc}loot_highscores");
        die();
    }

    private function createLoot()
    {
        if (!$this->z->user->isAdmin) {
            die("You don't have privilege.");
        }

        $userID = $this->z->getInput('user');
        $item_id = $this->z->getInput('item');
        $item_value = $this->z->getInput('item_value');
        $loot_type = $this->z->getInput('loot_type');

        $user_clan_groups_id = $this->z->db->fetchItem("id", "users_clan_groups", "WHERE uid = '{$userID}' AND clan_id = '{$this->clanID}'");

        $insertArray = array(
            'user_clan_groups_id' => $user_clan_groups_id,
            'item_id' => $item_id,
            'value' => $item_value,
            'type' => $loot_type
        );

        if($this->z->db->insertArray('loot_logs', $insertArray)) {
            $solo = $assisted = $points = 0;

            // If Type is assisted
            if($loot_type == 2) {
                $assisted = $this->z->getInput('item_value');
            }
            else {
                $solo = $this->z->getInput('item_value');
            }

            if($item_value >= 1000000*61) {
                $points = 3;
            }
            elseif($item_value >= 1000000*31) {
                $points = 2;
            }
            elseif($item_value >= 1000000) {
                $points = 1;
            }

            $this->z->db->updateLootPoints($solo, $assisted, $points, $user_clan_groups_id);

            return true;
        }

        return false;
    }

    private function display_highscore() {
        $templateList = 'loot_highscores_index,loot_highscores_table';
        $templateListArray = explode(',', $templateList);

        //Setup Template Variables.
        foreach ($templateListArray as $templateName) {
            $$templateName = $this->z->db->getTemplate($templateName);
        }

        $orderBy = "total";

        if($this->z->url_param[1] == "sort") {
            if($this->z->url_param[2] == "points") {
                $orderBy = "points";
            }
            elseif($this->z->url_param[2] == "assisted") {
                $orderBy = "assisted";
            }
            elseif($this->z->url_param[2] == "solo") {
                $orderBy = "solo";
            }
            elseif($this->z->url_param[2] == "points") {
                $orderBy = "points";
            }
        }

        $loot_table = "";
        // Get All Categories
        $userGroupSql = "SELECT * FROM users_clan_groups WHERE clan_id = '{$this->clanID}' ORDER BY {$orderBy} DESC";
        $userGroup = $this->z->db->fetchQuery($userGroupSql);

        // Go Through Each $categories
        $i = 1;
        foreach ($userGroup as $userG) {
            $username = $this->z->db->getUsernameByID($userG['uid']);
            $split = $this->formate_numbers($userG['solo']);
            $assisted = $this->formate_numbers($userG['assisted']);
            $total = $this->formate_numbers($userG['total']);
            eval("\$loot_table .= \"$loot_highscores_table\";");
            $i++;
        }

        eval("\$this->content = \"$loot_highscores_index\";");
    }

    private function formate_numbers($n) {
        if($n < 1000) {
            $n_format = number_format($n);
        }
        elseif($n < 1000000) {
            $n_format = number_format($n / 1000, 0) . 'K';
        }
        elseif($n < 1000000000) {
            $n_format = number_format($n / 1000000, 0) . 'M';
        }
        else {
            $n_format = number_format($n / 1000000000, 0) . 'B';
        }

        return $n_format;
    }
}