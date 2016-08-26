<?php

class db
{

    private $dsn = 'mysql:dbname=zforums;host=localhost';
    private $dbuser = 'root';
    private $dbpassword = 'mysql';
    public  $db = NULL;

   function __construct()
    {
        try{
            $this->db = new PDO($this->dsn, $this->dbuser, $this->dbpassword);
        }
        catch (PDOException $e) {
            echo 'Connection failed12: ' . $e->getMessage();
        }
    }

	//Return a template layout.
    public function getTemplate($templateName)
    {
        $query = $this->db->prepare("SELECT * FROM template WHERE name = '{$templateName}'");
        $query->execute();

        $result = $query->fetch();

        return $result[2];
    }
	
	//Return a Display Name by the uid.
    public function getUsernameByID($uid)
    {
        $query = $this->db->prepare("SELECT display_name FROM users WHERE uid = '{$uid}' LIMIT 1");
        $query->execute();

        $result = $query->fetch();

        return $result['display_name'];
    }
	
	//Return a uid by a display name
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

    //Return a uid by a display name
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
	
	//Get One value from a table, colum, row
	public function fetchItem($select, $from, $where)
	{
		$query = $this->db->prepare("SELECT {$select} FROM {$from} {$where}");
        $query->execute();

        $result = $query->fetch();

        return $result[$select];
	}
	
	//Insert a array into the table. The name of index must match database table names.
	public function insertArray($table, $array)
    {
		$sqlName = "INSERT INTO {$table} (";
		$sqlValue = ") VALUES (";
		$first = true;
		
		foreach($array as $name => $value)
		{
			if($first)
			{
				$sqlName .= $name;
				$sqlValue .= "'" . $value . "'";
				$first = false;
			}
			else
			{
				$sqlName .= "," . $name;
				$sqlValue .= "," . " '" . $value . "'";
			}
		}
		
		$sql = $sqlName . $sqlValue . ")";

        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->rowCount();
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
	
	public function fetchQuery($sql)
    {
        $query = $this->db->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
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

    public function generateUserHtmlRanks($userID = FALSE)
    {
        if(!userID) {
            false;
        }

        $user_rank_template = $this->getTemplate("user_rank");

        //Reset Variables
        $user_rank = "";

        //Query All the Users Ranks, Display Ea
        $user_group_sql = "SELECT * FROM users_clan_groups WHERE `uid` = {$userID}";
        $user_groups = $this->fetchQuery($user_group_sql);

        foreach ($user_groups as $user_group) {
            $user_clan_group_color = $this->fetchItem("color", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_group = $this->fetchItem("name", "clan", "WHERE `id` = " . $user_group['clan_id']);
            $user_clan_rank_color = $this->fetchItem("color", "clan_groups", "WHERE `id` = " . $user_group['group_id']);
            $user_clan_permission = $this->fetchItem("name", "clan_groups", "WHERE `id` = " . $user_group['group_id']);

            eval("\$user_rank .= \"$user_rank_template\";");
        }

        return $user_rank;
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
}