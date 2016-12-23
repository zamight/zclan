<?php
error_reporting(0);

/*
 *	Filename:		index.php
 *	Version:		0.0.1
 *	Description:	Autoload Classes and methods.
 *	Created By:		Cody Wofford
 *
 *	12/15
 *
 */
//TODO: Auto Initiate Class
//Format - zforums.com/class=User&method=Settings
//Format - zforums.com/User/Settings
//Format - zforums.com/c=User&m=Settings
session_start();
define("_DIR_", getcwd());
include _DIR_ . '/z.class.php';
include _DIR_ . '/db.class.php';
include _DIR_ . '/user.class.php';
date_default_timezone_set("UTC");

$z = new z();
$z->db = new db($z);
//$z->user = new user($z);
$z->site_default_name = "OLDRS Clan Management System";
$z->site_url = 'http://localhost/zclan/';
$z->site_urlc = 'http://localhost/zclan/';

//	Setup Variables
$urlArray = explode("/", $z->getInput('c'));

if (!array_key_exists(0, $urlArray) || empty($urlArray[0])) {
    $className = "login";
}
else {
    $className = $urlArray[0];
}

$url = _DIR_ . '/class/' . $className . '.class.php';
if (!file_exists($url)) {
    //Maybe It is just a clan name?
    $className = 'clan';
    $tmp = $urlArray[0];
    unset($urlArray[0]);
    $urlArray = array_values($urlArray);
    $urlArray['clan_name'] = $tmp;
    $z->site_urlc .= $urlArray['clan_name'] . '/';
}
else {
    $urlArray['clan_name'] = 'Site';
}

$z->url_param = $urlArray;

// Then set the $clanID to to the clanNames ID.
$clanName = strtolower($z->url_param['clan_name']);

$clan = $z->db->fetchQuery("SELECT * FROM `clan` WHERE `name` = '{$clanName}'");
$clan = $clan[0];

$z->clanID = $clan['id'];
$z->clanName = $clanName;

$z->user = new user($z);

//	Autoload Classes Function.
function autoloader($class)
{
    include _DIR_ . '/class/' . $class . '.class.php';
}
spl_autoload_register('autoloader');
//	Create class and load method

$class = new $className($z);

/*
if (!$urlArray[1] || !method_exists($class, $urlArray[1])) {
    $classMethod = 'index';
}
else {
    $classMethod = $urlArray[1];
}
*/

$class->index();
$content = ob_get_contents();
ob_end_clean();
print $content;