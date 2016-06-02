<?php

class user
{
	
	//Variables.
	private $arr = array();
	
	function __construct()
	{
		global $db;
		$session_id = session_id();
        $fetchUid = $db->fetchItem("uid", "session", "WHERE session_id = '{$session_id}'");
		
		$a = &$this->arr;

		if($fetchUid >= 1)
		{
			//Get Prividges.
			//Set All Variables.
			$membershipID = $db->fetchItem("group_id", "users_clan_groups", "WHERE `uid` = '{$fetchUid}'");
			$membership = $db->fetchRow("SELECT isAdmin, isMod FROM membership WHERE id = '{$membershipID}' LIMIT 1");
			
			$a['membershipID'] = $membershipID;
			$a['layout'] = $db->fetchItem("layout", "users", "WHERE uid = '{$fetchUid}'");
			
			if($membership['isAdmin'] == 1)
			{
				$a['isAdmin'] = true;
			}
			if($membership['isMod'] == 1)
			{
				$a['isMod'] = true;
			}
			
			$a['isLoggedIn'] = true;
		}
		
		return false; 
	}
	
	//Check to see if the user is logged in.
	//Returns: Boolean
    public function membershipID()
    {
		return $this->membershipID;
    }
	
	//See if the user uid and passwords match.
	//Return: Boolean
	public function authenticate($uid, $password)
	{
		global $db;
		
		$fetch = $db->fetchItem("display_name", "users", "WHERE uid = '{$uid}' AND password = '{$password}'");

		if($fetch)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function __get($name)
	{
		if(isset($this->arr[$name]))
		{
			return $this->arr[$name];
		}
		
		return false;
	}
	
}

$user = new user();