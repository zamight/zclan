<?php

/**
 * Class user
 */
class user
{

    private $arr = array();
    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
        $session_id = session_id();
        $fetchUid = $this->z->db->fetchItem("uid", "session", "WHERE session_id = '{$session_id}'");

        $a = &$this->arr;

        if ($fetchUid >= 1)
        {
            //Get Prividges.
            //Set All Variables.
            $membershipID = $this->z->db->fetchItem("privilege_id", "users_clan_groups", "WHERE `uid` = '{$fetchUid}' AND `clan_id` = '{$this->z->clanID}'");

            //No Permission? Run Default
            if (!$membershipID) {
                $membershipID = 4;
            }
            $membership = $this->z->db->fetchRow("SELECT * FROM privilege WHERE `id` = '{$membershipID}' LIMIT 1");

            $a['membershipID'] = $membershipID;
            $a['layout'] = $this->z->db->fetchItem("layout", "users", "WHERE uid = '{$fetchUid}'");

            foreach ($membership as $index => $value) {
                $a[$index] = $value;
            }

            $a['isLoggedIn'] = true;

            $this->arr['uid'] = $fetchUid;
        }

        return false;
    }

    public function membershipID()
    {
        return $this->membershipID;
    }

    public function authenticate($uid, $password)
    {
        $fetch = $this->z->db->fetchItem("display_name", "users", "WHERE uid = '{$uid}' AND password = '{$password}'");

        if ($fetch) {
            return true;
        } else {
            return false;
        }
    }

    public function __get($name)
    {
        if (isset($this->arr[$name])) {
            return $this->arr[$name];
        }

        return false;
    }

}