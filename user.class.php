<?php

class user
{
	
	//Variables.
	private $arr = array();
	private $z = null;
	
	function __construct($z)
	{
		$this->z = $z;
		$session_id = session_id();
        $fetchUid = $this->z->db->fetchItem("uid", "session", "WHERE session_id = '{$session_id}'");
		
		$a = &$this->arr;

		if($fetchUid >= 1)
		{
			//Get Prividges.
			//Set All Variables.
			$membershipID = $this->z->db->fetchItem("group_id", "users_clan_groups", "WHERE `uid` = '{$fetchUid}'");
			$membership = $this->z->db->fetchRow("SELECT isAdmin, isMod FROM clan_groups WHERE id = '{$membershipID}' LIMIT 1");
			
			$a['membershipID'] = $membershipID;
			$a['layout'] = $this->z->db->fetchItem("layout", "users", "WHERE uid = '{$fetchUid}'");
			
			if($membership['isAdmin'] == 1)
			{
				$a['isAdmin'] = true;
			}
			if($membership['isMod'] == 1)
			{
				$a['isMod'] = true;
			}
			
			$a['isLoggedIn'] = true;

			$this->arr['uid'] = $fetchUid;
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
		$fetch = $this->z->db->fetchItem("display_name", "users", "WHERE uid = '{$uid}' AND password = '{$password}'");

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