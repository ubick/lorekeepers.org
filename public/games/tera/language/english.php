<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2011
 * Date:		$Date: 2011-12-01 08:09:31 +0100 (Thu, 01 Dec 2011) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11484 $
 * 
 * $Id: english.php 11484 2011-12-01 07:09:31Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$english_array =  array(
	'classes' => array(
		0	=> 'Unknown',
		1	=> 'Archer',
		2	=> 'Berserker',
		3	=> 'Lancer',
		4	=> 'Mystic',
		5	=> 'Priest',
		6	=> 'Slayer',
		7	=> 'Sorcerer',
		8	=> 'Warrior'
	),

	'races' => array(
				'Unknown',
				'Aman',
				'Baraka',
				'Castanics',
				'High Elves',
				'Humans',
				'Popori',
				'Elin',
	),
	'factions' => array(
		'Default',
	),
	'lang' => array(
		'tera' => 'Tera Online',
	),
);

?>