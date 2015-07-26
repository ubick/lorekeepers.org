<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-08-15 17:49:30 +0200 (Wed, 15 Aug 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11934 $
 * 
 * $Id: english.php 11934 2012-08-15 15:49:30Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$english_array = array(
	'classes' => array(
		0 => 'Unknown',
		1 => 'Barbarian',
		2 => 'Demon Hunter',
		3 => 'Monk',
		4 => 'Witch Doctor',
		5 => 'Wizard',	
	),
	'roles' => array(
		1 => array(4),
		2 => array(2,4,5),
		3 => array(1,3),
	),
	'lang' => array(
		'diablo3' => 'Diablo 3',
		
		// Roles
		'role1'						=> 'Healer',
		'role2'						=> 'Range',
		'role3'						=> 'Melee',
	),
);
?>