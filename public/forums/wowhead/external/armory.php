<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Armory Parser
* By: Adam "craCkpot" Koch (support@wowhead-tooltips.com)
**/

/**
    Copyright (C) 2010  Adam Koch

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

include_once(dirname(__FILE__) . '/../config.php');
include_once(dirname(__FILE__) . '/../includes/wowhead_cache.php');

$cache = new wowhead_cache();

// get the vars from the get global
$get_char 	=	(isset($_GET['char'])) ?  urldecode($_GET['char']) : '';
$get_realm 	= 	urldecode(stripslashes($_GET['realm']));
$get_region = 	(array_key_exists('region', $_GET)) ? $_GET['region'] : '';
$get_prop 	= 	(isset($_GET['prop'])) ? $_GET['prop'] : 'char';
$get_guild 	= 	(isset($_GET['guild'])) ? urldecode($_GET['guild']) : '';

if ($get_guild != '')
	$get_prop = 'guild';

if ((empty($get_guild) && empty($get_char)) || empty($get_realm))
{
	$cache->close();
	exit;
}

if ($get_prop == 'char')
{
	$uniquekey = $cache->generateKey($get_char, $get_realm, $get_region);
    $result = $cache->getArmory($uniquekey, $armory_char_cache);
	if ($result)
	{
		header("Content-Type: text/html");
		print utf8_encode(stripslashes($result['tooltip']));
	}
	else
	{
		print "Tooltip information not found.<br/>Cache time may have expired, try reloading the page.<br/>Unique Key: $uniquekey<br/>Name: $get_char<br/>Realm: $get_realm<br/>Region: $get_region";
	}
}

if ($get_prop == 'guild')
{
	$uniquekey = $cache->generateKey($get_guild, $get_realm, $get_region);
    $result = $cache->getGuild($uniquekey, $armory_guild_cache);
	if ($result)
	{
		header("Content-Type: text/html");
		print utf8_encode(stripslashes($result['tooltip']));
	}
	else
	{
		print "Tooltip information not found.<br/><strong>Key:</strong> " . $uniquekey;
	}
}

$cache->close();
?>