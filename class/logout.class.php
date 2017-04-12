<?php


class logout
{

    private $z = null;

    public function __construct($z)
    {
        $this->z = $z;
    }

    public function index()
    {
        $this->z->db->deleteItem("session", "session_id", session_id());
        header("Location: {$this->z->site_url}");
        exit();
    }
}