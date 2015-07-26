<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-08-15 17:48:59 +0200 (Wed, 15 Aug 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11933 $
 * 
 * $Id: german.php 11933 2012-08-15 15:48:59Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$german_array = array(
	'classes' => array(
		0 => 'Unbekannt',
		1 => 'Elementarmagier',
		2 => 'Krieger',
		3 => 'Waldläufer',
		4 => 'Nekromant',
		5 => 'Wächter',
		6 => 'Dieb',
		7 => 'Mesmer',
		8 => 'Ingenieur',
	),
	'races' => array(
		'Unknown',
		'Sylvari',
		'Norn',
		'Charr',
		'Asura',
		'Menschen',
	),
	'roles' => array(
		1 => array(8,7,4,3),
		2 => array(1,2,3,4,5,6,7,8),
		3 => array(1,8,5,7,4,2,6,3),
		4 => array(1,8,5,7,4,2,6,3)
	),
	'lang' => array(
		'guildwars2' => 'Guildwars 2',
		
		// Roles
		'role1'						=> 'Heiler',
		'role2'						=> 'Tank',
		'role3'						=> 'DD Fernkampf',
		'role4'						=> 'DD Nahkampf',
	),
);
?>