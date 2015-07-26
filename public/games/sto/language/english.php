<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
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
		1	=> 'Engineering',
		2	=> 'Science',
		3	=> 'Tactical',
	),
	'races' => array(
		//Federation
		'Unknown',
		'Human',
		'Vulcan',
		'Bajoran',
		'Bolian',
		'Benzite ',
		'Betazoid',
		'Andorian',
		'Saurian',
		'Trill',
		'Tellarite',
		'Ferengi',
		'Pakled',
		//Klingon Empire
		'Orion',
		'Gorn',
		'Nausicaan',
		'Lethean',
		//Shared
		'Klingon',
		'Liberated Borg',
		'Alien'
	),
	'factions' => array(
		'Federation',
		'Klingon Empire',
	),
	'lang' => array(
		'sto' => 'Star Trek Online',
	),
);

?>