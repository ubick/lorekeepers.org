<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2013-01-12 18:27:09 +0100 (Sat, 12 Jan 2013) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12812 $
 * 
 * $Id: english.php 12812 2013-01-12 17:27:09Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$english_array =  array(
	'classes' => array(
		0 => 'Unknown',
		1 => 'Assassin',
		2 => 'Chanter',
		3 => 'Cleric',
		4 => 'Gladiator',
		5 => 'Ranger',
		6 => 'Sorcerer',
		7 => 'Spiritmaster',
		8 => 'Templar',
	),
	'races' => array(
		'Elyoss',
		'Asmodier'
	),
	'factions' => array(
		'Member',
	),
	'lang' => array(
		'aion' => 'Aion',
		'plate' => 'Plate',
		'cloth' => 'Cloth',
		'leather' => 'Leather',
		'mail' => 'Mail',
		
		// Profile information
		'uc_gender'						=> 'Gender',
		'uc_male'						=> 'Male',
		'uc_female'						=> 'Female',
		'uc_guild'						=> 'Guild',
	),
);
?>