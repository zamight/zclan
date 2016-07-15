-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 15, 2016 at 01:02 AM
-- Server version: 5.6.30
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zforums`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(124) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `clanID` int(11) NOT NULL,
  `banner_url` tinytext NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `enabled`, `sort`, `clanID`, `banner_url`) VALUES
(1, 'Applications', 'Recommended 75 combat to join.', 1, 1, 3, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(2, 'Community', 'zCombat community forums.', 1, 2, 3, 'http://image.prntscr.com/image/c9f4bee0ed47402681a9d3f8deaecada.png'),
(3, 'Test', 'dsfgsdfg', 1, 1, 1, 'http://localhost/zclan/images/snake_helm_green.png'),
(4, 'Applcations', 'Apply To Clan', 1, 1, 2, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(5, 'Support', 'Website Support Forums', 1, 1, 1, 'http://localhost/zclan/images/green_banner_wagner.png');

-- --------------------------------------------------------

--
-- Table structure for table `clan`
--

CREATE TABLE IF NOT EXISTS `clan` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `color` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clan`
--

INSERT INTO `clan` (`id`, `name`, `color`) VALUES
(1, 'site', 'w3-red'),
(2, 'zskillers', 'w3-blue'),
(3, 'zcombat', 'w3-red');

-- --------------------------------------------------------

--
-- Table structure for table `clan_groups`
--

CREATE TABLE IF NOT EXISTS `clan_groups` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `color` tinytext NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isMod` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clan_groups`
--

INSERT INTO `clan_groups` (`id`, `name`, `color`, `isAdmin`, `isMod`) VALUES
(1, 'Admin', 'w3-grey', 0, 1),
(2, 'Founder', 'w3-orange', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `parentID` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(124) NOT NULL,
  `thread_count` int(11) NOT NULL,
  `post_count` int(11) NOT NULL,
  `lastReplyuid` int(11) NOT NULL,
  `moderator_group` varchar(500) NOT NULL,
  `moderator_uid` varchar(500) NOT NULL,
  `enabled` tinytext NOT NULL,
  `sort` int(11) NOT NULL,
  `clanID` int(11) NOT NULL,
  `banner_url` tinytext NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `categoryID`, `parentID`, `name`, `description`, `thread_count`, `post_count`, `lastReplyuid`, `moderator_group`, `moderator_uid`, `enabled`, `sort`, `clanID`, `banner_url`) VALUES
(1, 1, 0, 'Apply Here', 'Submit your application here.', 0, 0, 0, '0', '0', '1', 1, 3, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(2, 2, 0, 'New and Announcements', 'Important clan information.', 0, 0, 0, '0', '0', '1', 1, 3, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(3, 1, 0, 'Dont Apply Here', 'Dont try to apply here', 0, 0, 0, '0', '0', '1', 2, 3, 'https://embed.gyazo.com/b457f1601490a635ae9f12ce4fcacb87.png'),
(4, 3, 0, 'Test', 'asdf', 0, 0, 0, '0', '0', '1', 1, 1, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(5, 4, 0, 'Application For Rank', 'Requirements: 10HP with 750 total level or 10m total exp', 0, 0, 0, '', '', '1', 1, 2, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(6, 4, 0, 'Applications For Smiley', 'Reply To The Thread For Smiley', 0, 0, 0, '0', '0', '1', 1, 2, 'http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png'),
(7, 5, 1, 'Website Support', 'Need assistance with the website?', 0, 0, 0, '0', '0', '1', 1, 1, 'http://localhost/zclan/images/green_banner_wagner.png');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `role` varchar(64) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isMod` tinyint(1) NOT NULL,
  `color` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `name`, `role`, `enabled`, `isAdmin`, `isMod`, `color`) VALUES
(1, 'Full Admin', 'Control over the whole forum.', 1, 1, 1, 'red');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL,
  `threadID` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `threadID`, `uid`, `content`) VALUES
(1, 1, 1, 'This is a test message.'),
(2, 2, 1, '[img]http://[/img]'),
(3, 3, 1, 'sdfgsdfgsdfg\r\n[img]http://image.prntscr.com/image/71482a80d958475282a747872b7eb270.png[/img]'),
(4, 3, 1, '[code]asdfasdf[/code]'),
(5, 3, 1, '[quote]asdfasdtfaery[/quote]'),
(6, 4, 1, '1'),
(7, 4, 1, '1'),
(8, 1, 1, 'Add Another Test'),
(9, 1, 1, 'One more test'),
(10, 5, 2, 'Im not sure how this works yet. Is this right?'),
(11, 5, 1, 'hey'),
(12, 5, 1, '501 yay'),
(13, 5, 1, 'HOW ABOUT NOW'),
(14, 5, 1, 'adsrtgsert'),
(15, 5, 1, 'dfghsdfg'),
(16, 5, 1, 'rtyoipiopiop'),
(17, 5, 1, 'that was dumb'),
(18, 6, 1, 'lets check it out.'),
(19, 6, 1, 'hmmmmmmm'),
(20, 6, 1, 'reply 2'),
(21, 7, 1, 'To get assistance create a new thread explaining the problem with the website you are experiencing.');

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `can_view` tinyint(1) NOT NULL,
  `can_post` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `membership_id`, `forum_id`, `can_view`, `can_post`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `agent` varchar(256) NOT NULL,
  `session_id` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `uid`, `agent`, `session_id`) VALUES
(36, 1, 'something', '8tt7r8dv89qkkkub12d38gg7a7'),
(37, 1, 'something', 'dle3sb2k94bc0tca8ivcojihe6'),
(38, 1, 'something', '8fmk8llnlc97fs56b8u77lchh5'),
(39, 1, 'something', 'fhau13re4evhe0j0c3cab2s530');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `setting` varchar(35) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `setting`) VALUES
(1, 'title', 'oldrs');

-- --------------------------------------------------------

--
-- Table structure for table `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `clanid` int(11) NOT NULL,
  `timestamp` bigint(15) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoutbox`
--

INSERT INTO `shoutbox` (`id`, `uid`, `clanid`, `timestamp`, `message`) VALUES
(1, 1, 1, 20160622172838, 'Hello World!'),
(2, 1, 1, 0, 'sdfg'),
(3, 1, 3, 1, 'fghf'),
(4, 1, 1, 1, 'hey'),
(5, 1, 1, 1, 'test'),
(6, 1, 1, 1, 'test'),
(7, 1, 1, 0, 'one more'),
(8, 1, 3, 1466633172, 'hey zam'),
(9, 2, 3, 1466633201, 'hi'),
(10, 2, 3, 1466633256, 'finally a shoutbox!'),
(11, 2, 1, 1466733569, 'fghjk');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `template` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `name`, `template`) VALUES
(1, 'header', '<!DOCTYPE html>\r\n<html lang=\\"en\\">\r\n<head>\r\n  <title>Bootstrap Example</title>\r\n  <meta charset=\\"utf-8\\">\r\n  <meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n  <link rel=\\"stylesheet\\" href=\\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\\">\r\n  <script src=\\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\\"></script>\r\n  <script src=\\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js\\"></script>\r\n  <style>\r\n  body {\r\n  padding-top: 40px;\r\n  padding-bottom: 40px;\r\n  background-color: #eee;\r\n}\r\n\r\n.form-signin {\r\n  max-width: 330px;\r\n  padding: 15px;\r\n  margin: 0 auto;\r\n}\r\n.form-signin .form-signin-heading,\r\n.form-signin .checkbox {\r\n  margin-bottom: 10px;\r\n}\r\n.form-signin .checkbox {\r\n  font-weight: normal;\r\n}\r\n.form-signin .form-control {\r\n  position: relative;\r\n  height: auto;\r\n  -webkit-box-sizing: border-box;\r\n     -moz-box-sizing: border-box;\r\n          box-sizing: border-box;\r\n  padding: 10px;\r\n  font-size: 16px;\r\n}\r\n.form-signin .form-control:focus {\r\n  z-index: 2;\r\n}\r\n.form-signin input[type=\\"email\\"] {\r\n  margin-bottom: -1px;\r\n  border-bottom-right-radius: 0;\r\n  border-bottom-left-radius: 0;\r\n}\r\n.form-signin input[type=\\"password\\"] {\r\n  margin-bottom: 10px;\r\n  border-top-left-radius: 0;\r\n  border-top-right-radius: 0;\r\n}\r\n/* Sticky footer styles\r\n-------------------------------------------------- */\r\nhtml {\r\n  position: relative;\r\n  min-height: 100%;\r\n}\r\nbody {\r\n  /* Margin bottom by footer height */\r\n  margin-bottom: 60px;\r\n}\r\n.footer {\r\n  position: absolute;\r\n  bottom: 0;\r\n  width: 100%;\r\n  /* Set the fixed height of the footer here */\r\n  height: 60px;\r\n  background-color: #f5f5f5;\r\n}\r\n\r\n\r\n/* Custom page CSS\r\n-------------------------------------------------- */\r\n/* Not required for template or sticky footer method. */\r\n\r\n.container .text-muted {\r\n  margin: 20px 0;\r\n}\r\n\r\n.footer > .container {\r\n  padding-right: 15px;\r\n  padding-left: 15px;\r\n}\r\n\r\ncode {\r\n  font-size: 80%;\r\n}\r\n.forum.table > tbody > tr > td {\r\n    vertical-align: middle;\r\n}\r\n\r\n.forum .fa {\r\n    width: 1em;\r\n    text-align: center;\r\n}\r\n\r\n.forum.table th.cell-stat {\r\n    width: 6em;\r\n}\r\n\r\n.forum.table th.cell-stat-2x {\r\n    width: 14em;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n\r\n<!-- Fixed navbar -->\r\n<nav class=\\"navbar navbar-inverse navbar-fixed-top\\">\r\n  <div class=\\"container\\">\r\n	<div class=\\"navbar-header\\">\r\n	  <button type=\\"button\\" class=\\"navbar-toggle collapsed\\" data-toggle=\\"collapse\\" data-target=\\"#navbar\\" aria-expanded=\\"false\\" aria-controls=\\"navbar\\">\r\n		<span class=\\"sr-only\\">Toggle navigation</span>\r\n		<span class=\\"icon-bar\\"></span>\r\n		<span class=\\"icon-bar\\"></span>\r\n		<span class=\\"icon-bar\\"></span>\r\n	  </button>\r\n	  <!-- <a class=\\"navbar-brand\\" href=\\"#\\">zForums</a> -->\r\n	</div>\r\n	<div id=\\"navbar\\" class=\\"navbar-collapse collapse\\">\r\n	  <ul class=\\"nav navbar-nav\\">\r\n		<li class=\\"active\\"><a href=\\"http://localhost/zforums/local_site/\\">Index</a></li>\r\n		<li><a href=\\"#about\\">Memberlist</a></li>\r\n		<li><a href=\\"#contact\\">Events</a></li>\r\n	  </ul>\r\n	  <ul class=\\"nav navbar-nav navbar-right\\">\r\n		{$isAdmin}\r\n                {$isMod}\r\n                {$logButton}\r\n		<li class=\\"dropdown\\">\r\n		  <a href=\\"#\\" class=\\"dropdown-toggle\\" data-toggle=\\"dropdown\\" role=\\"button\\" aria-haspopup=\\"true\\" aria-expanded=\\"false\\"><span class=\\"caret\\"></span></a>\r\n		  <ul class=\\"dropdown-menu\\">\r\n			<li><a href=\\"#\\">Action</a></li>\r\n			<li><a href=\\"#\\">Another action</a></li>\r\n			<li><a href=\\"#\\">Something else here</a></li>\r\n			<li role=\\"separator\\" class=\\"divider\\"></li>\r\n			<li class=\\"dropdown-header\\">Nav header</li>\r\n			<li><a href=\\"#\\">Separated link</a></li>\r\n			<li><a href=\\"#\\">One more separated link</a></li>\r\n                        <li><input type=\\"text\\" id=\\"username\\" name=\\"username\\" class=\\"form-control\\" placeholder=\\"Email address\\" required autofocus></li>\r\n                        <li><input type=\\"password\\" id=\\"password\\" name=\\"password\\" class=\\"form-control\\" placeholder=\\"Password\\" required></li>\r\n                        <li><button class=\\"btn btn-lg btn-primary btn-square\\" type=\\"submit\\">Sign in</button></li>\r\n		  </ul>\r\n		</li>\r\n	  </ul>\r\n	</div><!--/.nav-collapse -->\r\n  </div>\r\n</nav>\r\n\r\n<div class=\\"container panel panel-default\\">\r\n    <h1 class=\\"pull-left\\"></h1>\r\n	<div class=\\"clearfix\\"></div>\r\n    <ol class=\\"breadcrumb pull-left where-am-i\\">\r\n      <li><a href=\\"#\\">Forums</a></li>\r\n      <li class=\\"active\\">Community</li>\r\n    </ol>\r\n    <div class=\\"clearfix\\"></div>\r\n\r\n'),
(2, 'forum_table_head', '  <table class=\\"table forum table-striped\\">\r\n    <thead>\r\n      <tr>\r\n        <th class=\\"cell-stat\\"></th>\r\n        <th>\r\n          <h3>Important</h3>\r\n        </th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Topics</th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Posts</th>\r\n        <th class=\\"cell-stat-2x hidden-xs hidden-sm\\">Last Post</th>\r\n      </tr>\r\n    </thead>\r\n'),
(3, 'forum_table_foot', '  </table>\r\n</div>\r\n</div>\r\n\r\n    </div> <!-- /container -->\r\n	\r\n    <footer class=\\"footer\\">\r\n      <div class=\\"container\\">\r\n        <p class=\\"text-muted\\">Place sticky footer content here.</p>\r\n      </div>\r\n    </footer>\r\n\r\n</body>\r\n</html>'),
(5, 'footer', '    </div> <!-- /container -->\r\n	\r\n    <footer class="footer">\r\n      <div class="container">\r\n        <p class="text-muted">Place sticky footer content here.</p>\r\n      </div>\r\n    </footer>\r\n\r\n</body>\r\n</html>'),
(6, 'login_loggedin', '{$header}\r\n      <form class=\\"form-signin\\" method=\\"POST\\" action=\\"http://localhost/zforums/local_site/login/verify\\">\r\n        <h2 class=\\"form-signin-heading\\">Already signed in.</h2>\r\n        </div>\r\n      </form>\r\n{$footer}'),
(7, 'category', '{$header}\r\n  <table class=\\"table forum table-striped\\">\r\n{$category_tops}\r\n    </tbody>\r\n  </table>\r\n</div>\r\n</div>\r\n\r\n    </div> <!-- /container -->\r\n\r\n    <footer class=\\"footer\\">\r\n      <div class=\\"container\\">\r\n        <p class=\\"text-muted\\">Place sticky footer content here.</p>\r\n      </div>\r\n    </footer>\r\n\r\n</body>\r\n</html>'),
(9, 'category_table', '      <tr>\r\n        <td class=\\"text-center\\"><span class=\\"glyphicon glyphicon-envelope btn-lg\\"></span></td>\r\n        <td>\r\n          <h4><a href=\\"http://localhost/zforums/local_site/forum/{$forum[''id'']}\\">{$forum[''name'']}</a><br><small>{$forum[''description'']}</small></h4>\r\n        </td>\r\n        <td class=\\"text-center hidden-xs hidden-sm\\"><a href=\\"#\\">{$forum[''thread_count'']}</a></td>\r\n        <td class=\\"text-center hidden-xs hidden-sm\\"><a href=\\"#\\">{$forum[''post_count'']}</a></td>\r\n        <td class=\\"hidden-xs hidden-sm\\">by <a href=\\"#\\">{$forum[''lastReplyuid'']}</a><br><small><i class=\\"fa fa-clock-o\\"></i> 3 months ago</small></td>\r\n      </tr>'),
(8, 'category_top', '  <table class=\\"table forum table-striped\\">\r\n    <thead>\r\n      <tr>\r\n        <th class=\\"cell-stat\\"></th>\r\n        <th>\r\n          <h3>{$categories[''name'']}</h3>\r\n          <small>{$categories[''description'']}</small>\r\n        </th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Topics</th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Posts</th>\r\n        <th class=\\"cell-stat-2x hidden-xs hidden-sm\\">Last Post</th>\r\n      </tr>\r\n    </thead>\r\n{$category_tables}'),
(10, 'forum_top', '  <table class=\\"table forum table-striped\\">\r\n    <thead>\r\n      <tr>\r\n        <th class=\\"cell-stat\\"></th>\r\n        <th>\r\n          <h3>Name Here</h3>\r\n          <small>Description Here</small>\r\n        </th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Posts</th>\r\n        <th class=\\"cell-stat text-center hidden-xs hidden-sm\\">Viewed</th>\r\n        <th class=\\"cell-stat-2x hidden-xs hidden-sm\\">Last Post</th>\r\n      </tr>\r\n    </thead>\r\n<tbody>\r\n{$forum_tables}'),
(11, 'forum_table', '      <tr>\r\n        <td class=\\"text-center\\"><span class=\\"glyphicon glyphicon-envelope btn-lg\\"></span></td>\r\n        <td>\r\n          <h4><a href=\\"http://localhost/zforums/local_site/thread/{$thread[''id'']}\\">{$thread[''title'']}</a><br><small>" .  substr($thread[''content''], 0, 50) . "</small></h4>\r\n        </td>\r\n        <td class=\\"text-center hidden-xs hidden-sm\\"><a href=\\"#\\">{$thread[''reply_count'']}</a></td>\r\n        <td class=\\"text-center hidden-xs hidden-sm\\"><a href=\\"#\\">{$thread[''reply_count'']}</a></td>\r\n        <td class=\\"hidden-xs hidden-sm\\">by <a href=\\"#\\">{$thread[''uid'']}</a><br><small><i class=\\"fa fa-clock-o\\"></i> 3 months ago</small></td>\r\n      </tr>'),
(12, 'forum', '{$header}\r\n{$forum_tops}\r\n    </tbody>\r\n  </table>\r\n</div>\r\n</div>\r\n\r\n    </div> <!-- /container -->\r\n\r\n    <footer class=\\"footer\\">\r\n      <div class=\\"container\\">\r\n        <p class=\\"text-muted\\">Place sticky footer content here.</p>\r\n      </div>\r\n    </footer>\r\n\r\n</body>\r\n</html>'),
(13, 'post_bit', '<div class=\\"media\\">\r\n<div class=\\"media-left\\">\r\n<div class=\\"panel panel-danger\\">\r\n<div class=\\"panel-heading center-text\\">\r\n{$display_name}\r\n</div>\r\n<div class=\\"panel-body\\">\r\n    <a href=\\"#\\">\r\n      <img class=\\"media-object\\" data-src=\\"holder.js/64x64\\" alt=\\"64x64\\" src=\\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTFjZGJlNGMxNyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MWNkYmU0YzE3Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==\\" data-holder-rendered=\\"true\\" style=\\"width: 64px; height: 64px;\\">\r\n    </a>\r\n  </div>\r\n</div>\r\n</div>\r\n<div class=\\"media-body\\">\r\n<div class=\\"panel panel-info\\">\r\n  <div class=\\"panel-heading\\">{$posts[''content'']}</div>\r\n</div>\r\n</div></div>'),
(14, 'post', '{$header}\r\n{$post_bits}\r\n</div>\r\n</div>\r\n\r\n    </div> <!-- /container -->\r\n\r\n    <footer class=\\"footer\\">\r\n      <div class=\\"container\\">\r\n        <p class=\\"text-muted\\">Place sticky footer content here.</p>\r\n      </div>\r\n    </footer>\r\n\r\n</body>\r\n</html>'),
(17, 'index_login_button', '<li><a href=\\"http://localhost/zforums/local_site/login\\">Login</a></li>'),
(15, 'admin_tab', '<li><a href=\\"../navbar/\\">Admin CP</a></li>'),
(37, 'login_index_form', '<div id=\\"id01\\" class=\\"w3-container\\">\r\n  <div class=\\"w3-modal-content w3-card-8 w3-animate-zoom\\" style=\\"max-width:600px\\">\r\n  \r\n    <div class=\\"w3-center\\"><br>\r\n      <img src=\\"http://icons.iconarchive.com/icons/graphicloads/colorful-long-shadow/256/Lock-icon.png\\" alt=\\"Avatar\\" style=\\"width:40%\\" class=\\"w3-circle w3-margin-top\\">\r\n    </div>\r\n\r\n    <div class=\\"w3-container\\">\r\n	<form action=\\"/zclan/login/authenticate\\" method=\\"POST\\">\r\n      <div class=\\"w3-section\\">\r\n        <label><b>Username</b></label>\r\n        <input name=\\"username\\" class=\\"w3-input w3-border w3-hover-border-black w3-margin-bottom\\" type=\\"text\\" placeholder=\\"Enter Username\\">\r\n\r\n        <label><b>Password</b></label>\r\n        <input name=\\"password\\" class=\\"w3-input w3-border w3-hover-border-black\\" type=\\"text\\" placeholder=\\"Enter Password\\">\r\n        \r\n        <button name=\\"submit\\" value=\\"Login\\" class=\\"w3-btn w3-btn-block w3-green w3-section\\">Login</button>\r\n        <input class=\\"w3-check\\" type=\\"checkbox\\" checked=\\"checked\\"> Remember me\r\n      </div>\r\n	  </form>\r\n    </div>\r\n\r\n    <div class=\\"w3-container w3-border-top w3-padding-hor-16 w3-light-grey\\">\r\n      <span class=\\"w3-right w3-padding w3-hide-small\\">Forgot <a href=\\"#\\">password?</a></span>\r\n    </div>\r\n	\r\n{$login_index_incorrect}\r\n\r\n  </div>\r\n</div>'),
(16, 'mod_tab', '<li><a href=\\"../navbar/\\">Mod CP</a></li>'),
(18, 'index_logout_button', '<li><a href=\\"./\\">Logout</a></li>'),
(19, 'w3_header', '<!DOCTYPE html>\r\n<!-- BEGINE HEADER -->\r\n<html>\r\n<title>My Web</title>\r\n<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n\r\n<link rel=\\"stylesheet\\" href=\\"http://www.w3schools.com/lib/w3.css\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\\">\r\n<style>\r\n.w3-theme {color:#fff !important;background-color:#2196F3 !important}\r\n.w3-theme-light {color:#000 !important;background-color:#E3F2FD !important}\r\n.w3-theme-dark {color:#fff !important;background-color:#0D47A1 !important}\r\n.w3-text-theme {color:#2196F3 !important}\r\n.w3-theme-l5 {color:#000 !important;background-color:#E3F2FD !important}\r\n.w3-theme-l4 {color:#000 !important;background-color:#BBDEFB !important}\r\n.w3-theme-l3 {color:#000 !important;background-color:#90CAF9 !important}\r\n.w3-theme-l2 {color:#000 !important;background-color:#64B5F6 !important}\r\n.w3-theme-l1 {color:#fff !important;background-color:#42A5F5 !important}\r\n.w3-theme-d1 {color:#fff !important;background-color:#1E88E5 !important}\r\n.w3-theme-d2 {color:#fff !important;background-color:#1976D2 !important}\r\n.w3-theme-d3 {color:#fff !important;background-color:#1565C0 !important}\r\n.w3-theme-d4 {color:#fff !important;background-color:#0D47A1 !important}\r\n.w3-theme-action {color:#fff !important;background-color:#1565C0 !important}\r\nhtml,body\r\n{\r\n    height:100%;\r\n    width:100%;\r\nbackground-image: url(http://7-themes.com/data_images/out/66/6996006-dock-waters.jpg); background-attachment: fixed;\r\n}\r\n</style>\r\n<div class=\\"w3-topnav w3-xlarge w3-blue w3-center w3-card-4\\">\r\n  <a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a>\r\n  <a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-comments-o w3-xlarge\\"></i></a>\r\n  <a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-group w3-xlarge\\"></i></a>\r\n  <a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-calendar w3-xlarge\\"></i></a>\r\n  <a class=\\"w3-btn w3-blue\\" onclick=\\"document.getElementById(''id01'').style.display=''block''\\" href=\\"#\\"><i class=\\"fa fa-external-link w3-xlarge\\"></i></a>\r\n</div>\r\n<br>\r\n\r\n<div id=\\"id01\\" class=\\"w3-modal w3-card-4\\">\r\n  <div class=\\"w3-modal-content w3-animate-top\\">\r\n		<div class=\\"w3-container\\">\r\n		<span onclick=\\"document.getElementById(''id01'').style.display=''none''\\" class=\\"w3-closebtn\\">x </span>\r\n		  <h2  id=\\"this\\" class=\\"w3-text-theme\\">Login</h2>\r\n		  <div class=\\"w3-group\\">      \r\n			<input class=\\"w3-input\\" type=\\"text\\" required>\r\n			<label class=\\"w3-label\\">Name</label>\r\n		  </div>\r\n		  <div class=\\"w3-group\\">      \r\n			<input class=\\"w3-input\\" type=\\"password\\" required>\r\n			<label class=\\"w3-label\\">Password</label>\r\n		  </div>\r\n		  <label class=\\"w3-checkbox\\">\r\n			<input type=\\"checkbox\\" checked=\\"checked\\">\r\n			<span class=\\"w3-checkmark\\"></span> Stay Logged In\r\n		  </label>\r\n		  <br /><br />\r\n		  <button class=\\"w3-btn w3-theme\\"> Log in </button>\r\n		  <br />\r\n		<br />\r\n    </div>\r\n  </div>\r\n</div>\r\n<div class=\\"w3-container\\">    \r\n  <div class=\\"w3-row\\">\r\n    <div class=\\"w3-col m2\\">\r\n	<br />\r\n    </div>\r\n    <div class=\\"w3-col m8\\">\r\n<!-- END HEADER -->'),
(20, 'w3_category', '{$header}\r\n<!-- BEGIN W3_CATEGORY -->\r\n<div class=\\"w3-container w3-card-4\\"  style=\\"background-color: #FFFFFF;\\">\r\n  <h2 class=\\"w3-text-theme\\">zSkillers Forum</h2>\r\n<br>\r\n{$category_tops}\r\n</div>\r\n    </div>\r\n    <div class=\\"w3-col m2\\">\r\n	<br>\r\n    </div>\r\n  </div>\r\n</div>\r\n<br>\r\n<!-- END W3_CATEGORY -->\r\n{$footer}'),
(21, 'w3_category_top', '<!-- BEGIN W3_CATEGORY_TOP -->\r\n<table class=\\"w3-table w3-striped w3-hoverable\\">\r\n<thead class=\\"w3-blue w3-large\\">\r\n  <th width=\\"25px;\\"></th>\r\n  <th style=\\"width:50%;\\">{$categories[''name'']}</th>\r\n  <th class=\\"w3-center\\"></th>\r\n  <th class=\\"w3-center\\"></th>\r\n  <th class=\\"w3-center\\"></th>\r\n</thead>\r\n\r\n{$category_tables}\r\n</table>\r\n<br />\r\n<!-- END W3_CATEGORY_TOP -->'),
(22, 'w3_category_table', '<!-- BEGIN W3_CATEGORY_TABLE -->\r\n<tr>\r\n  <td><a href=\\"#\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a></td>\r\n  <td class=\\"w3_left\\"><a href=\\"forum/{$forum[''id'']}\\">{$forum[''name'']}</a><br><small>{$forum[''description'']}</small></td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-sticky-note-o\\"></i> {$forum[''thread_count'']}</td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-clone\\"></i> {$forum[''post_count'']}</td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-comment-o\\"></i> {$forum[''lastReplyuid'']}</td>\r\n</tr>\r\n<!-- END W3_CATEGORY_TABLE -->'),
(23, 'w3_footer', '<div class=\\"w3-container w3-card-6\\" style=\\"position:static;bottom:0px;left:0px;right:0px;background-color:#FFFFFF;\\">\r\n  <h5>Footer</h5>\r\n  <p>Footer information goes here</p>\r\n</div>\r\n</body>\r\n</html> '),
(34, '', '<span class="w3-tag w3-small w3-{$color}">{$title}</span>'),
(35, 'login_index', '<!DOCTYPE html>\r\n<html>\r\n<title>W3.CSS</title>\r\n<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://www.w3schools.com/lib/w3.css\\">\r\n<style>\r\nhtml, \r\nbody {\r\n    height: 100%;\r\n}\r\nbody {\r\n    background-image: url(\\"https://i.gyazo.com/eccb3956c24334de45c544d22ba6d375.png\\");\r\n    background-color: #cccccc;\r\n    background-repeat:no-repeat;\r\n    background-size:cover;\r\n	\r\n}\r\n</style>\r\n<body>\r\n\r\n	<div class=\\"w3-container w3-blue-grey\\">\r\n	  <p>OLDRS.CC ADMIN CP LOGIN</p>\r\n	</div>\r\n\r\n\r\n{$login_index_forms}\r\n	\r\n\r\n	<div class=\\"w3-container w3-display-bottommiddle w3-blue-grey\\">\r\n	  <h5>Footer</h5>\r\n	  <p>&copy; Copyright OLDRS.CC</p>\r\n	</div>\r\n</body>\r\n</html> \r\n'),
(24, 'w3_admin_tab', '<a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a>'),
(25, 'w3_mod_tab', '<a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a>'),
(26, 'w3_index_login_button', '<a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a>'),
(27, 'w3_index_logout_button', '<a class=\\"w3-btn w3-blue\\" href=\\"file:///C:/Users/Cody/Desktop/new%20site/category.html\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a>'),
(28, 'w3_forum', '{$header}\r\n\r\n<div class=\\"w3-container w3-card-4\\" style=\\"background-color: #FFFFFF;\\">\r\n  <h2  id=\\"this\\" class=\\"w3-text-theme\\">zSkillers Forum\r\n  <a class=\\"w3-btn-floating-large w3-theme-action w3-right w3-animate-right\\" style=\\"position:relevant;top:-28px;right:16px;\\"><i class=\\"fa fa-file\\"></i></a> </h2>\r\n<br>\r\n\r\n{$forum_tops}\r\n\r\n<br />\r\n</div>\r\n\r\n    \r\n    </div>\r\n    <div class=\\"w3-col m2\\">\r\n	<br>\r\n    </div>\r\n  </div>\r\n</div>\r\n<br>\r\n{$footer}'),
(29, 'w3_forum_top', '<table  id=\\"btn1\\" class=\\"w3-table w3-striped w3-hoverable\\">\r\n<thead>\r\n<tr class=\\"w3-blue w3-large\\">\r\n  <th><i class=\\"fa fa-barcode\\"></i></th>\r\n  <th style=\\"width:50%;\\"></th>\r\n  <th class=\\"w3-center\\"></th>\r\n  <th class=\\"w3-center\\"></th>\r\n  <th class=\\"w3-center\\"></th\r\n</tr>\r\n</thead>\r\n\r\n\r\n{$forum_tables}\r\n</table>'),
(30, 'w3_forum_table', '<tr>\r\n  <td><a href=\\"#\\"><i class=\\"fa fa-home w3-xlarge\\"></i></a></td>\r\n  <td><a href=\\"http://localhost/zforums/local_site/thread/{$thread[''id'']}\\">{$thread[''title'']}</a></td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-clone\\"></i> 50</td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-binoculars\\"></i> 30</td>\r\n  <td class=\\"w3-center\\" style=\\"vertical-align: middle;\\"><i class=\\"fa fa-comment-o\\"></i> Zamight</td>\r\n</tr>'),
(31, 'w3_thread', '{$header}\r\n\r\n<!--Begin w3_threads -->\r\n<!--Begin modal -->\r\n<div id=\\"id01\\" class=\\"w3-modal w3-card-4\\">\r\n	<div class=\\"w3-modal-content w3-animate-top\\">\r\n		<form class=\\"w3-container w3-card-2\\" action=\\"\\" method=\\"POST\\">\r\n		<h2 class=\\"w3-text-theme\\">zSkillers Forum</h2>\r\n		<label>Quick Reply</label>\r\n			<div class=\\"w3-group\\">\r\n				<input class=\\"w3-input\\" type=\\"text\\" required>\r\n				<label>Title</label>\r\n				<br />\r\n			</div>\r\n			<div class=\\"w3-group\\">\r\n				<div class=\\"w3-container\\">\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-smile-o\\"></i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><b>B</b></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i>I</i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><u>U</u></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><b><i class=\\"fa fa-paint-brush\\"></i></b></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-file-image-o\\"></i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\">URL</span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-align-left\\"></i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-align-center\\"></i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-align-right\\"></i></span>\r\n					<span class=\\"w3-btn w3-round  w3-theme\\"><i class=\\"fa fa-quote-left\\"></i></span>\r\n				</div>\r\n				<textarea rows=\\"10\\" class=\\"w3-input w3-border\\"></textarea>\r\n			<label>Message</label>\r\n			</div>\r\n			<button id=\\"exit_post\\" class=\\"w3-btn w3-theme w3-right\\" onclick=\\"document.getElementById(''id01'').style.display=''none''\\"><i class=\\"fa fa-reply\\"></i></button>\r\n		</form>\r\n	</div>\r\n</div>\r\n\r\n<!--End modal -->\r\n			<div class=\\"w3-container w3-card-2\\"   style=\\"background-color: #FFFFFF;\\">\r\n				<h2  id=\\"this\\" class=\\"w3-text-theme\\">zSkillers Forum\r\n				<a id=\\"lock_icon_float\\" class=\\"w3-btn-floating-large w3-theme w3-right w3-animate-right\\" style=\\"position:relevant;top:-28px;right:16px;\\"><i id=\\"lock_icon\\" class=\\"fa fa-unlock\\"></i></a>\r\n				<a id=\\"pin_icon_float\\" class=\\"w3-btn-floating-large w3-theme w3-right w3-animate-right\\" style=\\"position:relevant;top:-28px;right:16px;\\"><i id=\\"pin_icon\\" class=\\"fa fa-level-down\\"></i></a>\r\n				<a class=\\"w3-btn-floating-large w3-theme w3-right w3-animate-right\\" onclick=\\"document.getElementById(''id01'').style.display=''block''\\" style=\\"position:relevant;top:-28px;right:16px;\\"><i class=\\"fa fa-file\\"></i></a> </h2>\r\n				<label class=\\"w3-text-theme\\">Home > General</label>\r\n				<br>\r\n				<div class=\\"w3-container w3-theme\\">\r\n					<h3>&#9776; Do you like Zeah?</h3>\r\n				</div>\r\n				<ul id=\\"ul_posts\\" class=\\"w3-ul\\">\r\n				{$post_bits}\r\n				</ul>\r\n				<br>\r\n				<div class=\\"w3-center\\">\r\n					<ul class=\\"w3-pagination\\">\r\n						<li><a href=\\"#\\"><<</a></li>\r\n						<li><a class=\\"w3-theme\\" href=\\"#\\">1</a></li>\r\n						<li><a href=\\"#\\">>></a></li>\r\n					</ul>\r\n				</div>\r\n			</div>\r\n			<div class=\\"w3-col m2\\">\r\n				&nbsp;\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n\r\n<!--End w3_threads -->\r\n\r\n<script src=\\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\\"></script>\r\n<script>\r\n$(document).ready(function(){\r\n	  	$(\\"#lock_icon_float\\").click(\r\n  function () {\r\n  if($(\\"#lock_icon\\").hasClass(\\"fa-unlock\\"))\r\n  {\r\n	$(\\"#lock_icon\\").removeClass(\\"fa-unlock\\").addClass(\\"fa-lock\\");\r\n  }\r\n  else\r\n  {\r\n  $(\\"#lock_icon\\").removeClass(\\"fa-lock\\").addClass(\\"fa-unlock\\");\r\n  }\r\n  });\r\n  \r\n  	$(\\"#pin_icon_float\\").click(\r\n  function () {\r\n  if($(\\"#pin_icon\\").hasClass(\\"fa-level-up\\"))\r\n  {\r\n	$(\\"#pin_icon\\").removeClass(\\"fa-level-up\\").addClass(\\"fa-level-down\\");\r\n  }\r\n  else\r\n  {\r\n  $(\\"#pin_icon\\").removeClass(\\"fa-level-down\\").addClass(\\"fa-level-up\\");\r\n  }\r\n  });\r\n\r\n  \r\n  $(\\"#exit_post\\").click(function() {\r\n	$(\\"#ul_posts\\").append(\\"<li><div class=\\\\\\"w3-row\\\\\\"><div class=\\\\\\"w3-col w3-container s5 m5 l2\\\\\\">	<h4 class=\\\\\\"w3-center\\\\\\">Dig<br /><img src=\\\\\\"http://zskillers.com/forum/uploads/avatars/avatar_110.png?dateline=1410314283\\\\\\" />		<br /><small><i class=\\\\\\"fa fa-sticky-note-o\\\\\\"></i>100  <i class=\\\\\\"fa fa-clone\\\\\\"></i>100</small></h4></h4></div><div class=\\\\\\"w3-col w3-container s7 m7 l10\\\\\\">	<span class=\\\\\\"w3-tag w3-small w3-indigo\\\\\\">zSkillers Leader</span>	<span class=\\\\\\"w3-tag w3-small w3-blue\\\\\\">Staff Member</span>	  <p>Do you like Zeah? I think it will be a great expantion to Oldschool Runescape. Do you like Zeah? I think it will be a great expantion to Oldschool Runescape. Do you like Zeah? I think it will be a great expantion to Oldschool Runescape. Do you like Zeah? I think it will be a great expantion to Oldschool Runescape. Do you like Zeah? I think it will be a great expantion to Oldschool Runescape.</p><p><hr>Leet tweet peeps/ Cam''t get some fun because im to much love</p></div></div></li>\\");\r\n  $(window).scrollTop($(document).height());\r\n  });\r\n});\r\n</script>\r\n\r\n{$footer}'),
(32, 'w3_post', '<!--Begin w3_post -->\r\n				<li>\r\n				<div class=\\"w3-row\\">\r\n					<div class=\\"w3-col w3-container s5 m5 l2\\">\r\n						<h4 class=\\"w3-center\\">{$display_name}<br /><img src=\\"http://zskillers.com/forum/uploads/avatars/avatar_1.gif?dateline=1423939928\\" />\r\n						<br /><small><i class=\\"fa fa-sticky-note-o\\"></i>zero  <i class=\\"fa fa-clone\\"></i>zero</small></h4>\r\n					</div>\r\n					<div class=\\"w3-col w3-container s7 m7 l10\\">\r\n						{post_privilege}\r\n						{$posts[''content'']}\r\n					</div>\r\n				</div>\r\n				</li>\r\n<!--End w3_post -->'),
(33, 'w3_privilege_tag', '<!--Begin w3_privilege_tag -->\r\n						<span class=\\"w3-tag w3-small w3-red\\">Owner</span>\r\n<!--End w3_privilege_tag -->'),
(38, 'login_index_loggedin', '<div id=\\"id01\\" class=\\"w3-container\\">\r\n  <div class=\\"w3-modal-content w3-card-8 w3-animate-zoom\\" style=\\"max-width:600px\\">\r\n    <div class=\\"w3-container w3-border-top w3-padding-hor-16 w3-red\\">\r\n      <span class=\\"w3-right w3-padding w3-hide-small\\">Already Logged In.</span>\r\n    </div>\r\n  </div>\r\n</div>'),
(39, 'admin_index', '\r\n<!DOCTYPE html>\r\n<html>\r\n<title>W3.CSS</title>\r\n<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n<head>\r\n<link rel=\\"stylesheet\\" href=\\"http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://www.w3schools.com/lib/w3.css\\">\r\n<style>\r\nhtml, \r\nbody {\r\n\r\n}\r\nbody {\r\n    background-image: url(\\"https://i.gyazo.com/eccb3956c24334de45c544d22ba6d375.png\\");\r\n    background-color: #cccccc;\r\n    background-repeat:no-repeat;\r\n    background-size:cover;\r\n	background-attachment: fixed;\r\n	\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n	<div class=\\"w3-container w3-top w3-blue-grey\\">\r\n	  <p>OLDRS.CC ADMIN CP LOGIN</p>\r\n	</div>\r\n\r\n<nav class=\\"w3-sidenav w3-light-grey\\">\r\n{$navMenus}\r\n</nav>\r\n\r\n<div class=\\"w3-main\\" style=\\"margin-left:270px;margin-top:52px;margin-right:40px;\\">\r\n{$body}\r\n</div>\r\n<br />\r\n<footer class=\\"w3-container w3-blue-grey\\">\r\n  <h5 class=\\"w3-center\\">Footer</h5>\r\n  <p class=\\"w3-center\\">Footer information goes here</p>\r\n</footer>\r\n\r\n</body>\r\n</html> '),
(36, 'login_index_incorrect', '	    <div class=\\"w3-container w3-border-top w3-padding-hor-16 w3-red\\">\r\n      <span class=\\"w3-right w3-padding w3-hide-small\\">Incorrect Username or Password</span>\r\n    </div>'),
(46, 'admincp_user_rows', '<div class=\\"w3-row-padding w3-margin-bottom\\" style=\\"padding-top:10px;\\">'),
(47, 'admincp_user_edit', '<div class=\\"w3-row-padding w3-margin-bottom\\" style=\\"padding-top:10px;\\">\r\n<div class=\\"w3-container w3-blue-grey\\">\r\n<h2>Edit User - {$user_edit[''display_name'']}</h2>\r\n</div>\r\n\r\n<form class=\\"w3-container w3-white\\" method=\\"POST\\" action=\\"#\\">\r\n\r\n<p>\r\n<label>Display Name</label>\r\n<input class=\\"w3-input\\" name=\\"display_name\\" type=\\"text\\" value=\\"{$user_edit[''display_name'']}\\"></p>\r\n<p>\r\n<label>Password</label>\r\n<input class=\\"w3-input\\" name=\\"password\\" type=\\"password\\" value=\\"\\"></p>\r\n<p>\r\n<label>Avatar</label>\r\n<input class=\\"w3-input\\" name=\\"avatar\\" type=\\"text\\" value=\\"{$user_edit[''avatar'']}\\"></p>\r\n<p>\r\n<label>Post Count</label>\r\n<input class=\\"w3-input\\" name=\\"post_count\\" type=\\"text\\" value=\\"{$user_edit[''post_count'']}\\"></p>\r\n<p>\r\n<label>Thread Count</label>\r\n<input class=\\"w3-input\\" name=\\"thread_count\\" type=\\"text\\" value=\\"{$user_edit[''thread_count'']}\\"></p>\r\n\r\n<p>\r\n<label>Email</label>\r\n<input class=\\"w3-input\\" name=\\"email\\" type=\\"text\\" value=\\"{$user_edit[''email'']}\\"></p>\r\n\r\n<p>\r\n<label>\r\nClan Rank\r\n</label>\r\n{$user_rank}\r\n</p>\r\n\r\n<p>\r\n<button name=\\"submit\\" class=\\"w3-btn w3-green\\">Save</button>\r\n</p>\r\n</form>\r\n</div>'),
(41, 'admincp_index_body', '	<div class=\\"w3-row-padding w3-margin-bottom\\" style=\\"padding-top:10px;\\">\r\n		<div class=\\"w3-quarter\\">\r\n		  <div class=\\"w3-container w3-blue w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-users w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Clans</h4>\r\n		  </div>\r\n		</div>\r\n		<div class=\\"w3-quarter\\">\r\n		  <div class=\\"w3-container w3-teal w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-plug w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Plugins</h4>\r\n		  </div>\r\n		</div>\r\n		<div class=\\"w3-quarter\\">\r\n		  <div class=\\"w3-container w3-orange w3-text-white w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-user w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>{$user_count}</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Users</h4>\r\n		  </div>\r\n		</div>\r\n	  </div>\r\n	  \r\n\r\n\r\n<div class=\\"w3-container w3-blue-grey\\">\r\n<h2>Default Settings</h2>\r\n</div>\r\n\r\n<form class=\\"w3-container w3-white\\">\r\n\r\n<p>\r\n<label>Site Name</label>\r\n<input class=\\"w3-input\\" type=\\"text\\" value=\\"OLDRS.CC\\"></p>\r\n\r\n<p>\r\n<label>Description</label>\r\n<input class=\\"w3-input\\" type=\\"text\\" value=\\"A Clan Website Dedicated To The Oldschool Runescape Community.\\"></p>\r\n\r\n<label>Enabled</label>\r\n<p>\r\n<input class=\\"w3-radio\\" type=\\"radio\\" name=\\"gender\\" value=\\"male\\" checked>\r\n<label class=\\"w3-validate\\">Yes</label></p>\r\n\r\n<p>\r\n<input class=\\"w3-radio\\" type=\\"radio\\" name=\\"gender\\" value=\\"female\\">\r\n<label class=\\"w3-validate\\">No</label></p>\r\n\r\n</form>'),
(42, 'admincp_user_index', '	<div class=\\"w3-row-padding w3-margin-bottom\\" style=\\"padding-top:10px;\\">\r\n		<div class=\\"w3-quarter\\">\r\n<a href=\\"user/list\\" style=\\" text-decoration: none;\\">\r\n		  <div class=\\"w3-container w3-blue w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-users w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>List All Users</h4>\r\n		  </div>\r\n		</div>\r\n		<div class=\\"w3-quarter\\">\r\n		  <div class=\\"w3-container w3-teal w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-ban w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Ban</h4>\r\n		  </div>\r\n</a>\r\n		</div>\r\n		\r\n<div class=\\"w3-quarter\\">\r\n<a href=\\"user/list\\" style=\\" text-decoration: none;\\">\r\n		  <div class=\\"w3-container w3-light-blue w3-text-white w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-child w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>3</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Groups</h4>\r\n		  </div>\r\n</a>\r\n		</div>\r\n<div class=\\"w3-quarter\\">\r\n<a href=\\"zclan/admincp/user/list\\" style=\\" text-decoration: none;\\">\r\n		  <div class=\\"w3-container w3-indigo w3-text-white w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-balance-scale w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>3</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Permission</h4>\r\n		  </div>\r\n		</div>\r\n</a>\r\n\r\n	  </div>\r\n<a href=\\"user/list\\" style=\\" text-decoration: none;\\">\r\n<div class=\\"w3-row-padding w3-margin-bottom\\" style=\\"padding-top:10px;\\">\r\n		<div class=\\"w3-quarter\\">\r\n		  <div class=\\"w3-container w3-orange w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-trophy w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Award</h4>\r\n		  </div>\r\n</a>\r\n		</div>\r\n		<div class=\\"w3-quarter\\">\r\n<a href=\\"user/list\\" style=\\" text-decoration: none;\\">\r\n		  <div class=\\"w3-container w3-deep-purple w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><i class=\\"fa fa-plug w3-xxxlarge\\"></i></div>\r\n			<div class=\\"w3-right\\">\r\n			  <h3>0</h3>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			<h4>Title Ladder</h4>\r\n		  </div>\r\n</a>\r\n		</div>\r\n		\r\n\r\n\r\n\r\n\r\n	  </div>'),
(40, 'admincp_nav_link', '<a {$current_nav} href=\\"/zclan/admincp/{$method}\\"><span class=\\"fa fa-{$icon}\\"></span> {$name}</a>'),
(44, 'admincp_user_info_card', '<div class=\\"w3-quarter\\">\r\n<a href=\\"edit/{$user[''uid'']}\\"><div class=\\"w3-container w3-blue w3-padding-hor-16\\">\r\n			<div class=\\"w3-left\\"><img src=\\"{$user[''avatar'']}\\"><h4>{$user[''display_name'']}</h4></div>\r\n			<div class=\\"w3-right\\">\r\n			  \r\n  <h4>Post: {$user[''post_count'']}</h4><h4>Thread: {$user[''thread_count'']}</h4>\r\n			</div>\r\n			<div class=\\"w3-clear\\"></div>\r\n			\r\n			{$user_rank}\r\n\r\n</div>\r\n</a>\r\n</div>'),
(45, 'user_rank', '<div style=\\"border:1px solid #000000;display: inline-block; width:100%;max-width: 150px;margin:1px;\\" class=\\"w3-container;\\">\r\n  <div class=\\"{$user_clan_group_color} w3-left\\" style=\\"display:inline-block;border:1px solid #FFFFFF;width:50%;\\">	&nbsp;{$user_clan_group}</div>\r\n  <div class=\\"{$user_clan_rank_color} w3-left\\" style=\\"display:inline-block;border: solid #FFFFFF;border-width: 1px 1px 1px 0px;width:50%;\\"><font style=\\"color: white;\\">	&nbsp;{$user_clan_permission}</font></div>\r\n</div>'),
(48, 'admincp_user_edit_clan_rank', '<div style=\\"border:1px solid #000000;display: inline-block; width:100%;max-width: 250px;margin:1px;\\" class=\\"w3-container;\\">\r\n  <div class=\\"{$user_clan_group_color} w3-left\\" style=\\"display:inline-block;border:1px solid #FFFFFF;width:50%;\\">	&nbsp;{$user_clan_group}</div>\r\n  <div class=\\"{$user_clan_rank_color} w3-left\\" style=\\"display:inline-block;border: solid #FFFFFF;border-width: 1px 1px 1px 0px;width:50%;\\"><font style=\\"color: white;\\">	&nbsp;{$options}</font></div>\r\n</div>'),
(49, 'forum_index', '<!DOCTYPE html>\r\n<html><head><meta http-equiv=\\"Content-Type\\" content=\\"text/html; charset=windows-1252\\"><title>W3.CSS</title>\r\n<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://www.w3schools.com/lib/w3.css\\">\r\n<link rel=\\"stylesheet\\" href=\\"https://fonts.googleapis.com/css?family=Raleway\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\\">\r\n<style>\r\nhtml,body,h1,h2,h3,h4,h5 {font-family: \\"Raleway\\", sans-serif}\r\n.w3-sidenav a,.w3-sidenav h4 {font-weight:bold}\r\n</style>\r\n<script type=\\"text/javascript\\" src=\\"/zclan/bbeditor/ed.js\\"></script>  \r\n</head><body class=\\"w3-light-grey\\" data-gr-c-s-loaded=\\"true\\">\r\n\r\n<!-- w3-content defines a container for fixed size centered content, \r\nand is wrapped around the whole page content, except for the footer in this example -->\r\n<div class=\\"w3-content w3-main\\" style=\\"max-width:1400px\\">\r\n<ul class=\\"w3-navbar w3-light-grey w3-large\\">\r\n  <li><a class=\\"w3-green\\" href=\\"#\\"><i class=\\"fa fa-home w3-large\\"></i></a></li>\r\n  <li><a href=\\"#\\"><i class=\\"fa fa-search w3-large\\"></i></a></li>\r\n  <li><a href=\\"#\\"><i class=\\"fa fa-envelope w3-large\\"></i></a></li>\r\n  <li><a href=\\"#\\"><i class=\\"fa fa-globe w3-large\\"></i></a></li>\r\n  <li><a href=\\"#\\"><i class=\\"fa fa-sign-in w3-large\\"></i></a></li>\r\n</ul>\r\n<!-- Header -->\r\n<div class=\\"w3-container w3-center w3-padding-32\\"> \r\n<div class=\\"w3-overlay w3-hide-large w3-animate-opacity\\" onclick=\\"w3_close()\\" style=\\"cursor:pointer\\" title=\\"close side menu\\"></div>\r\n<span class=\\"w3-opennav w3-hide-large w3-xxlarge w3-hover-text-grey\\" onclick=\\"w3_open()\\"><i class=\\"fa fa-bars\\"></i></span>\r\n  <h1><b>{$clanName} Forums</b></h1>\r\n  <p>Welcome to the clan management system.</p>\r\n</div>\r\n\r\n<!-- About Card on medium screens -->\r\n<div class=\\"w3-hide-large w3-hide-small w3-margin-top w3-margin-bottom\\">\r\n    <div class=\\"w3-container w3-white w3-padding-32\\">\r\n    <img src=\\"./W3.CSS_files/img_avatar_g.jpg\\" alt=\\"Me\\" style=\\"width:150px\\" class=\\"w3-left w3-round-large w3-margin-right\\">\r\n    <span>Just me, myself and I, exploring the universe of uknownment. I have a heart of love and an interest of lorem ipsum and mauris neque quam blog. I want to share my world with you.</span>\r\n  </div>\r\n</div>\r\n\r\n<!-- About Card on small screens -->\r\n<div class=\\"w3-hide-large w3-hide-medium w3-margin-top w3-margin-bottom\\">\r\n  <img src=\\"./W3.CSS_files/img_avatar_g.jpg\\" style=\\"width:100%\\" alt=\\"Me\\">\r\n  <div class=\\"w3-container w3-white\\">\r\n    <h4><b>Zamight</b></h4>\r\n    <p>Just me, myself and I, exploring the universe of uknownment. I have a heart of love and a interest of lorem ipsum and mauris neque quam blog. I want to share my world with you.</p>\r\n  </div>\r\n</div>\r\n\r\n<!-- Grid -->\r\n<div class=\\"w3-row\\">\r\n\r\n<!-- Blog entries -->\r\n<div class=\\"w3-col l8 s12\\">\r\n  <!-- Blog entry -->\r\n{$body}\r\n  <hr>\r\n<!-- END BLOG ENTRIES -->\r\n</div>\r\n\r\n<!-- Introduction menu -->\r\n<div class=\\"w3-col l4 w3-hide-medium w3-hide-small\\">\r\n  <!-- ShoutBox -->\r\n  <div class=\\"w3-card w3-margin\\">\r\n    <div class=\\"w3-container w3-padding\\">\r\n      <h4>Shout Box</h4>\r\n    </div>\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n{$shoutboxRows}\r\n      <li class=\\"w3-padding-16 w3-hide-medium w3-hide-small\\">\r\n        <form action=\\"#\\" method=\\"POST\\"><input name=\\"shout_message\\" class=\\"w3-input w3-border w3-round w3-left w3-margin-right\\" style=\\"width:300px\\" type=\\"text\\"><button value=\\"shout_new\\" type=\\"submit\\" name=\\"shout_new\\" class=\\"w3-btn w3-theme\\"><i class=\\"fa fa-pencil\\"></i> &nbsp;Post</button></form>\r\n      </li> \r\n    </ul>\r\n  </div>\r\n\r\n  <!-- Posts -->\r\n  <div class=\\"w3-card w3-margin\\">\r\n    <div class=\\"w3-container w3-padding\\">\r\n      <h4>Random Skill Top 5</h4>\r\n    </div>\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n      <li class=\\"w3-padding-16\\">\r\n        <img src=\\"./W3.CSS_files/img_workshop.jpg\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\">Zam</span><br>\r\n        <span>500k</span>\r\n      </li>\r\n      <li class=\\"w3-padding-16\\">\r\n        <img src=\\"./W3.CSS_files/img_gondol.jpg\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\">Dig</span><br>\r\n        <span>400k</span>\r\n      </li> \r\n      <li class=\\"w3-padding-16\\">\r\n        <img src=\\"./W3.CSS_files/img_skies.jpg\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\">Jay</span><br>\r\n        <span>2</span>\r\n      </li>   \r\n      <li class=\\"w3-padding-16 w3-hide-medium w3-hide-small\\">\r\n        <img src=\\"./W3.CSS_files/img_rock.jpg\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\">Sack</span><br>\r\n        <span>1</span>\r\n      </li>  \r\n    </ul>\r\n  </div>\r\n  <hr> \r\n  \r\n<!-- END Introduction Menu -->\r\n</div>\r\n\r\n<!-- END GRID -->\r\n</div><br>\r\n\r\n<!-- END w3-content -->\r\n</div>\r\n\r\n<!-- Footer -->\r\n<footer class=\\"w3-container w3-dark-grey w3-padding-32 w3-margin-top\\">\r\n  <p class=\\"w3-right\\">Powered by <a href=\\"http://www.w3schools.com/w3css/default.asp\\" target=\\"_blank\\">OCM</a></p>\r\n</footer>\r\n\r\n<script>\r\n// Script to open and close sidenav\r\nfunction w3_open() {\r\n    document.getElementsByClassName(\\"w3-sidenav\\")[0].style.display = \\"block\\";\r\n    document.getElementsByClassName(\\"w3-overlay\\")[0].style.display = \\"block\\";\r\n}\r\n \r\nfunction w3_close() {\r\n    document.getElementsByClassName(\\"w3-sidenav\\")[0].style.display = \\"none\\";\r\n    document.getElementsByClassName(\\"w3-overlay\\")[0].style.display = \\"none\\";\r\n}\r\n</script>\r\n</body></html>'),
(57, 'register_index', '<html><head><title>W3.CSS</title>\r\n<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://www.w3schools.com/lib/w3.css\\">\r\n<link rel=\\"stylesheet\\" href=\\"https://fonts.googleapis.com/css?family=Raleway\\">\r\n<link rel=\\"stylesheet\\" href=\\"http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\\">\r\n<style>\r\nhtml,body,h1,h2,h3,h4,h5 {font-family: \\"Raleway\\", sans-serif}\r\n.w3-sidenav a,.w3-sidenav h4 {font-weight:bold}\r\n</style>\r\n\r\n<script type=\\"text/javascript\\" src=\\"/zclan/bbeditor/ed.js\\"></script><link href=\\"bbeditor/styles.css\\" rel=\\"stylesheet\\" type=\\"text/css\\">  \r\n</head><body class=\\"w3-light-grey\\" data-gr-c-s-loaded=\\"true\\">\r\n\r\n<!-- w3-content defines a container for fixed size centered content, \r\nand is wrapped around the whole page content, except for the footer in this example -->\r\n<div class=\\"w3-content w3-main\\" style=\\"max-width:1400px\\">\r\n<!-- Header -->\r\n<div class=\\"w3-container w3-center w3-padding-32\\"> \r\n<div class=\\"w3-overlay w3-hide-large w3-animate-opacity\\" onclick=\\"w3_close()\\" style=\\"cursor:pointer\\" title=\\"close side menu\\"></div>\r\n<span class=\\"w3-opennav w3-hide-large w3-xxlarge w3-hover-text-grey\\" onclick=\\"w3_open()\\"></span>\r\n  <h1><b>Old School Runescape Community Clans</b></h1>\r\n  <p>Welcome to the clan management system.</p>\r\n</div>\r\n\r\n<!-- About Card on medium screens -->\r\n<div class=\\"w3-hide-large w3-hide-small w3-margin-top w3-margin-bottom\\">\r\n    \r\n</div>\r\n\r\n<!-- About Card on small screens -->\r\n<div class=\\"w3-hide-large w3-hide-medium w3-margin-top w3-margin-bottom\\">\r\n  <img src=\\"./W3.CSS_files/img_avatar_g.jpg\\" style=\\"width:100%\\" alt=\\"Me\\">\r\n  <div class=\\"w3-container w3-white\\">\r\n    <h4><b>Zamight</b></h4>\r\n    <p>Just me, myself and I, exploring the universe of uknownment. I have a heart of love and a interest of lorem ipsum and mauris neque quam blog. I want to share my world with you.</p>\r\n  </div>\r\n</div>\r\n\r\n<!-- Grid -->\r\n<div class=\\"w3-row\\" style=\\"width:720px;margin: 0 auto;\\">\r\n  {$warnings}\r\n<img src=\\"http://localhost/zclan/images/Poll_Booth_lumbridge.png\\" alt=\\"Nature\\"><div class=\\"w3-container w3-white\\">\r\n  \r\n<h2>Register</h2>\r\n</div>\r\n\r\n<form class=\\"w3-container w3-white\\" action=\\"#\\" method=\\"POST\\">\r\n\r\n<p>\r\n<label>Username</label>\r\n<input class=\\"w3-input\\" name=\\"username\\" type=\\"text\\" value=\\"{$z->getInput(''username'')}\\"></p>\r\n\r\n<p>\r\n<label>Email</label>\r\n<input class=\\"w3-input\\" name=\\"email\\" type=\\"text\\" value=\\"{$z->getInput(''email'')}\\"></p>\r\n\r\n\r\n<p>\r\n<label>Password</label>\r\n<input class=\\"w3-input\\" name=\\"password\\" type=\\"password\\" value=\\"{$z->getInput(''password'')}\\"></p>\r\n<p>\r\n<label>Re-Type Password</label>\r\n<input class=\\"w3-input\\" name=\\"retype_password\\" type=\\"password\\" value=\\"{$z->getInput(''retype_password'')}\\"></p>\r\n<p>\r\n<label>Runescape Username</label>\r\n<input class=\\"w3-input\\" name=\\"rsn\\" type=\\"text\\" value=\\"{$z->getInput(''rsn'')}\\"></p>\r\n  <p><label>Are you 13 or older?</label></p>\r\n  <p><input class=\\"w3-radio\\" type=\\"radio\\" value=\\"yes\\" name=\\"agreeto13\\">\r\n<label class=\\"w3-validate\\">Yes</label></p>\r\n\r\n<p><input class=\\"w3-radio\\" type=\\"radio\\" name=\\"agreeto13\\" value=\\"np\\">\r\n<label class=\\"w3-validate\\">No</label></p>\r\n<p class=\\"w3-right\\">\r\n  <button name=\\"registeration_submitted\\" value=\\"Register\\" class=\\"w3-btn w3-green\\">Register</button>\r\n</p>\r\n  <p></p>\r\n\r\n\r\n\r\n</form>\r\n</div>\r\n  <!-- End forum_posts -->\r\n  <hr>\r\n<!-- END BLOG ENTRIES -->\r\n\r\n<!-- END GRID -->\r\n<br>\r\n\r\n<!-- END w3-content -->\r\n</div>\r\n\r\n<!-- Footer -->\r\n<footer class=\\"w3-container w3-dark-grey w3-padding-32 w3-margin-top\\">\r\n  <p class=\\"w3-right\\">Powered by <a href=\\"http://www.w3schools.com/w3css/default.asp\\" target=\\"_blank\\">OCM</a></p>\r\n</footer>\r\n\r\n<script>\r\n// Script to open and close sidenav\r\nfunction w3_open() {\r\n    document.getElementsByClassName(\\"w3-sidenav\\")[0].style.display = \\"block\\";\r\n    document.getElementsByClassName(\\"w3-overlay\\")[0].style.display = \\"block\\";\r\n}\r\n \r\nfunction w3_close() {\r\n    document.getElementsByClassName(\\"w3-sidenav\\")[0].style.display = \\"none\\";\r\n    document.getElementsByClassName(\\"w3-overlay\\")[0].style.display = \\"none\\";\r\n}\r\n</script>\r\n</body><div style=\\"visibility: hidden; top: -9999px; position: absolute; opacity: 0;\\"></div><div style=\\"visibility: hidden; top: -9999px; position: absolute; opacity: 0;\\"></div></html>');
INSERT INTO `template` (`id`, `name`, `template`) VALUES
(52, 'forum_threads', '<!-- Start forum_threads -->\r\n<div class=\\"w3-margin\\">\r\n  <img src=\\"{$forum[''banner_url'']}\\" alt=\\"Nature\\" style=\\"width:100%\\">\r\n<div class=\\"w3-card-4 w3-white  w3-round-large\\">\r\n    <div class=\\"w3-container w3-white w3-padding-8\\">\r\n      <h3><b>{$forum[''name'']}</b></h3>\r\n      <h5><span class=\\"w3-opacity\\">{$forum[''description'']}</span></h5>\r\n    </div>\r\n\r\n    <div class=\\"w3-container\\">\r\n      <p>\r\n	    <!-- Posts -->\r\n  </p><div class=\\"w3-card-2 w3-margin\\">\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n{$thread_html} \r\n    </ul>\r\n  </div>\r\n\r\n\r\n<div class=\\"w3-card-2 w3-margin\\"><form method=\\"POST\\" action=\\"#\\">\r\n<input class=\\"w3-input w3-border-0\\" name=\\"title\\" required=\\"\\" placeholder=\\"Input Title Here:\\">\r\n    </div>\r\n<div class=\\"w3-card-2 w3-margin\\">\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n    <script>edToolbar(''message''); </script>\r\n    <textarea name=\\"message\\" id=\\"message\\" class=\\"ed\\" style=\\"width:100%;height:200px;\\"></textarea>\r\n        </textarea>\r\n\r\n    </ul>\r\n \r\n</div>\r\n <button name=\\"new_thread\\" class=\\"w3-right w3-btn w3-black w3-margin-right w3-margin-bottom\\">New Thread</button></form>\r\n</div>\r\n</div>\r\n  </div>\r\n  <!-- End forum_threads -->'),
(53, 'forum_thread_list', '	<!-- Start forum_thread_list -->\r\n        <li class=\\"w3-padding-16\\">\r\n		<span class=\\"w3-padding-large w3-right\\"><b>Replies &nbsp;</b> <span class=\\"w3-tag\\">{$thread[''reply_count'']}</span><b>&nbsp; Views &nbsp;</b> <span class=\\"w3-tag\\">{$thread[''view_count'']}</span></span>\r\n        <img src=\\"https://i.gyazo.com/b457f1601490a635ae9f12ce4fcacb87.png\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\"><a href=\\"{$thread[''url'']}\\">{$thread[''title'']}</a></span><br>\r\n        <span>{$thread[''description'']}</span>\r\n      </li>\r\n	<!-- End forum_thread_list -->'),
(55, 'forum_posts_list', '<!-- Start forum_posts_list --> \r\n <li class=\\"w3-padding-16\\"><img src=\\"{$users[''avatar'']}\\" alt=\\"Image\\">\r\n        \r\n        <span class=\\"w3-large\\">{$users[''display_name'']}</span><div class=\\"w3-right\\"><span class=\\"w3-light-grey\\">Post: {$users[''post_count'']}</span><br><span class=\\"w3-light-grey\\">Thread: {$users[''thread_count'']}</span></div><br><br>\r\n\r\n{$ranks}\r\n<br>\r\n      </li>\r\n<li class=\\"w3-padding-16\\">\r\n<span>{$post[''content'']}\r\n</span>\r\n      </li>\r\n	  <!-- End forum_posts_list -->'),
(50, 'forum_index_category', '<!-- Start forum_index_category -->\r\n<div class=\\"w3-margin\\">\r\n  <img src=\\"{$category[''banner_url'']}\\" alt=\\"Nature\\" style=\\"width:100%\\">\r\n<div class=\\"w3-white w3-card-4 w3-round-large\\">\r\n    <div class=\\"w3-container w3-white w3-padding-8\\">\r\n      <h3><b>{$category[''name'']}</b></h3>\r\n      <h5><span class=\\"w3-opacity\\">{$category[''description'']}</span></h5>\r\n    </div>\r\n\r\n    <div class=\\"w3-container\\">\r\n      <p>\r\n	    <!-- Posts -->\r\n  </p><div class=\\"w3-card-2 w3-margin\\">\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n{$forum_html} \r\n    </ul>\r\n  </div>\r\n    </div>\r\n  </div></div>\r\n  <!-- End forum_index_category -->'),
(51, 'forum_index_forum', '	<!-- Start forum_index_forum -->\r\n        <li class=\\"w3-padding-16\\">\r\n		<span class=\\"w3-padding-large w3-right\\"><b>Threads &nbsp;</b> <span class=\\"w3-tag\\">{$forum[''thread_count'']}</span><b>&nbsp; Posts &nbsp;</b> <span class=\\"w3-tag\\">{$forum[''post_count'']}</span></span>\r\n        <img src=\\"https://i.gyazo.com/b457f1601490a635ae9f12ce4fcacb87.png\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\"><a href=''{$url}''>{$forum[''name'']}</a></span><br>\r\n        <span>{$forum[''description'']}</span>\r\n      </li>\r\n	<!-- End forum_index_forum -->'),
(54, 'forum_posts', '<!-- Start forum_posts -->\r\n<div class=\\"w3-margin\\">\r\n  <img src=\\"{$forum[''banner_url'']}\\" alt=\\"Nature\\" style=\\"width:100%\\">\r\n<div class=\\"w3-card-4 w3-white w3-round-large\\">\r\n    <div class=\\"w3-container w3-white w3-padding-8\\">\r\n      <h3><b><a href=\\"{$backUrl}\\">{$forum[''name'']}</a></b></h3>\r\n      <h5><span class=\\"w3-opacity\\">{$forum[''description'']}</span></h5>\r\n    </div>\r\n \r\n    <div class=\\"w3-container w3-white w3-round-large\\">\r\n      <p>\r\n	    <!-- Posts -->\r\n  </p>\r\n  <div class=\\"w3-card-2 w3-margin\\">\r\n    <div class=\\"w3-container w3-padding w3-light-grey\\">\r\n      <h4>{$thread[''title'']}</h4>\r\n    </div>\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n{$post_html} \r\n  </ul></div>\r\n  \r\n<form method=\\"POST\\" action=\\"#\\">\r\n<div class=\\"w3-card-2 w3-margin\\">\r\n    <ul class=\\"w3-ul w3-hoverable w3-white\\">\r\n    <script>edToolbar(''message''); </script>\r\n    <textarea name=\\"message\\" id=\\"message\\" class=\\"ed\\" style=\\"width:100%;height:200px;\\"></textarea>\r\n        </textarea>\r\n\r\n    </ul>\r\n \r\n</div>\r\n <button name=\\"new_thread\\" value=\\"new_thread\\" class=\\"w3-right w3-btn w3-black w3-margin-right w3-margin-bottom\\">New Reply</button></form>\r\n</div>\r\n  </div></div>\r\n  <!-- End forum_posts -->'),
(56, 'shoutbox_row', '<li class=\\"w3-padding-16\\">\r\n        <img src=\\"{$avatar}\\" alt=\\"Image\\" class=\\"w3-left w3-margin-right\\" style=\\"width:50px\\">\r\n        <span class=\\"w3-large\\">{$displayName}</span><br>\r\n        <span>{$shoutbox[''message'']}</span>\r\n      </li>'),
(58, 'warning_red_alert', '<div class=\\"w3-container w3-red\\">\r\n<span onclick=\\"this.parentElement.style.display=''none''\\" class=\\"w3-closebtn\\">&times;</span>\r\n  <h3>Warning!</h3>\r\n  <p>{$warning}</p>\r\n</div> \r\n<br />');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL,
  `forumID` int(11) NOT NULL,
  `parentID` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `reply_count` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(4) NOT NULL,
  `view_count` int(11) NOT NULL,
  `op_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `forumID`, `parentID`, `uid`, `title`, `reply_count`, `enabled`, `view_count`, `op_id`) VALUES
(1, 1, 0, 1, 'This is a title test', 1, 1, 0, 0),
(2, 2, 0, 1, 'test', 1, 1, 0, 0),
(3, 2, 0, 1, 'dfgsdfg', 1, 1, 0, 0),
(4, 2, 0, 1, 'sdfsdf', 1, 1, 0, 0),
(5, 4, 0, 2, 'New Post', 1, 1, 0, 0),
(6, 4, 0, 1, 'lets test this', 2, 1, 0, 0),
(7, 7, 0, 1, 'Need Assistance', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `password` tinytext NOT NULL,
  `layout` varchar(30) NOT NULL,
  `avatar` tinytext NOT NULL,
  `post_count` int(11) NOT NULL,
  `thread_count` int(11) NOT NULL,
  `signature` tinytext NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `display_name`, `password`, `layout`, `avatar`, `post_count`, `thread_count`, `signature`, `email`) VALUES
(1, 'zam', '$2y$10$V1LAMFMtgmLG6IIvouW9OucdlOI2bwdCVwzTWS6fF33RNSf1qmAre', 'w3_', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 4, 2, 'this is my signature', 'cody.e.wofford@gmail.com'),
(2, 'Dig', 'hello', '', 'http://zforums.org/data/avatars/l/0/2.jpg?1453349456', 500000, 0, '', 'dig@mr.awesome.com'),
(3, 'brandin is gay', 'password', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 0, 0, '', ''),
(5, 'afsdf', 'afsdfasdf', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 1, 2, '', ''),
(6, 'fdsgdfg', 'sdfgszedfg', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 3434, 234, '', ''),
(7, 'qwerwqer', 'awserdwer', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 234, 234, '', ''),
(8, 'this noob', 'dfgfdg', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 234, 234, '', ''),
(9, 'hgjghj', 'rtyrety', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 7777, 5655, '', ''),
(10, 'dfg', 'fdg', '', 'http://services.runescape.com/m=rswikiimages/en/2012/12/chat-29024951.gif', 4565, 456, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_clan_groups`
--

CREATE TABLE IF NOT EXISTS `users_clan_groups` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `clan_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_clan_groups`
--

INSERT INTO `users_clan_groups` (`id`, `uid`, `clan_id`, `group_id`) VALUES
(4, 2, 1, 1),
(7, 2, 2, 1),
(8, 1, 1, 2),
(9, 1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan`
--
ALTER TABLE `clan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan_groups`
--
ALTER TABLE `clan_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoutbox`
--
ALTER TABLE `shoutbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `users_clan_groups`
--
ALTER TABLE `users_clan_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `clan`
--
ALTER TABLE `clan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clan_groups`
--
ALTER TABLE `clan_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shoutbox`
--
ALTER TABLE `shoutbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users_clan_groups`
--
ALTER TABLE `users_clan_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
