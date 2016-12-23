<?php

class db
{

    private $dsn = 'mysql:dbname=zforums;host=localhost';
    private $dbuser = 'root';
    private $dbpassword = '';
    private $db = 'mysql';

    function __construct()
    {
        try{
            $this->db = new PDO($this->dsn, $this->dbuser, $this->dbpassword);
        }
        catch (PDOException $e) {
            echo 'Connection failed12: ' . $e->getMessage();
        }
    }

    public function getUsernameByID($uid)
    {
        $query = $this->db->prepare("SELECT display_name FROM users WHERE uid = '{$uid}' LIMIT 1");
        $query->execute();

        $result = $query->fetch();

        return $result['display_name'];
    }

    public function getUserInfo($uid)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE uid = '{$uid}' LIMIT 1");
        $query->execute();

        $result = $query->fetch();

        return $result;
    }

    public function getIDbyUsername($username)
    {
        $query = $this->db->prepare("SELECT uid FROM users WHERE display_name = '{$username}' LIMIT 1");
        $query->execute();

        if($result = $query->fetch()) {
            return $result['uid'];
        }
        else {
            return false;
        }

    }

    public function getIDbyEmail($email)
    {
        $query = $this->db->prepare("SELECT uid FROM users WHERE email = '{$email}' LIMIT 1");
        $query->execute();

        if($result = $query->fetch()) {
            return $result['uid'];
        }
        else {
            return false;
        }

    }

    public function insertArray($table, $array)
    {
        $sqlName = "INSERT INTO {$table} (";
        $sqlValue = ") VALUES (";
        $first = true;
        $counter = 1;
        foreach($array as $name => $value)
        {
            if($first)
            {
                $sqlName .= $name;
                $sqlValue .= "?";
                $first = false;
            }
            else
            {
                $sqlName .= "," . $name;
                $sqlValue .= "," . "?";
            }
        }
        $sql = $sqlName . $sqlValue . ")";
        $query = $this->db->prepare($sql);
        foreach($array as $name => $value)
        {
            $query->bindParam($counter, $array[$name]);
            $counter++;
        }
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function updateArray($table, $array, $where)
    {

        $sqlName = "UPDATE {$table} SET ";
        $first = true;

        foreach($array as $name => $value)
        {
            if($first)
            {
                $sqlName .= $name;
                $sqlName .= "='" . $value . "'";
                $first = false;
            }
            else
            {
                $sqlName .= ", " . $name;
                $sqlName .= "= " . "'" . $value . "'";
            }
        }

        $sql = $sqlName . " " . $where;

        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->rowCount();
    }

    public function fetchRow($sql)
    {
        $query = $this->db->prepare($sql);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function countRows($select)
    {
        $query = $this->db->prepare("SELECT * FROM {$select}");
        $query->execute();

        $result = $query->rowCount();

        return $result;
    }

    public function generateUserHtmlRanks($userID = FALSE, $display = 10)
    {
        if(!userID) {
            false;
        }

        $user_rank_template = $this->getTemplate("user_rank");

        //Reset Variables
        $user_rank = "";
        $counter = 1;

        //Query All the Users Ranks, Display Ea
        $user_group_sql = "SELECT * FROM users_clan_groups WHERE `uid` = {$userID}";
        $user_groups = $this->fetchQuery($user_group_sql);

        foreach ($user_groups as $user_group) {
            if($counter > $display) {
                break;
            }
            $user_clan_group_color = $this->fetchItem("color", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_group = $this->fetchItem("name", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_rank_color = $this->fetchItem("color", "clan_groups", "WHERE `id` = " . $user_group['group_id']);
            $user_clan_permission = $this->fetchItem("name", "clan_groups", "WHERE `id` = " . $user_group['group_id']);

            eval("\$user_rank .= \"$user_rank_template\";");
            $counter++;
        }

        return $user_rank;
    }

    public function getTemplate($templateName)
    {
        $query = $this->db->prepare("SELECT * FROM template WHERE name = '{$templateName}'");
        $query->execute();

        $result = $query->fetch();

        return $result[2];
    }

    public function fetchQuery($sql)
    {
        $query = $this->db->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function fetchItem($select, $from, $where)
	{
		$query = $this->db->prepare("SELECT {$select} FROM {$from} {$where}");
        $query->execute();

        $result = $query->fetch();

        return $result[$select];
	}

    public function updateLootPoints($solo, $assisted, $points, $user_group_id)
    {
            $query = $this->db->prepare("UPDATE users_clan_groups SET solo = solo + ?, assisted = assisted + ?,
                points = points + ?, total = total + ? WHERE id = ?");
            $query->bindValue(1, $solo, PDO::PARAM_INT);
            $query->bindValue(2, $assisted, PDO::PARAM_INT);
            $query->bindValue(3, $points, PDO::PARAM_INT);
            $query->bindValue(4, $solo + $assisted, PDO::PARAM_INT);
            $query->bindValue(5, $user_group_id, PDO::PARAM_INT);
            $query->execute();

        return false;
    }

    public function addPostCountByUid($uid)
    {
        if(!empty($uid)) {
            $query = $this->db->prepare("UPDATE users SET post_count = post_count + 1 WHERE uid = ?");
            $query->bindValue(1, $uid, PDO::PARAM_INT);
            $query->execute();
        }
        return false;
    }

    public function addThreadCountByUid($uid)
    {
        if(!empty($uid)) {
            $query = $this->db->prepare("UPDATE users SET thread_count = thread_count + 1 WHERE uid = ?");
            $query->bindValue(1, $uid, PDO::PARAM_INT);
            $query->execute();
            return true;
        }
        return false;
    }

    public function addReplyCountByThreadId($threadId)
    {
        if(!empty($threadId)) {
            $query = $this->db->prepare("UPDATE threads SET reply_count = reply_count + 1 WHERE id = ?");
            $query->bindValue(1, $threadId, PDO::PARAM_INT);
            $query->execute();
        }
        return false;
    }

    public function deleteItem($table, $field, $value) {
        $sql = "DELETE FROM {$table} WHERE {$field} = :value";
        $query = $this->db->prepare($sql);
        $query->bindParam(':value',$value);
        if(!$query->execute()) {
            die("Couldn't log out.");
        }
    }

    public function deleteItems($table, $where) {
        $sql = "DELETE FROM {$table} {$where}";
        $query = $this->db->prepare($sql);
        if(!$query->execute()) {
            die("Couldn't delete.");
        }
    }
}