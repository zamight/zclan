<?php

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

include '/class/z.class.php';
include '/class/db.class.php';
include '/class/user.class.php';

//	Setup Variables
$className = $z->getInput('c');
$classMethod = $z->getInput('m');
$classAction = $z->getInput('a');

if(!$className)
{
    $className = "login";
}

//	Autoload Classes Function.
function autoloader($class)
{
    include '/class/' . $class . '.class.php';
}

spl_autoload_register('autoloader');

//	Create class and load method
$class = new $className();

if(!$classMethod || !method_exists($class, $classMethod))
{
    $classMethod = 'index';
}
$class->$classMethod();

$content = ob_get_contents();
ob_end_clean();
print $content;