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
 * $Id: german.php 11484 2011-12-01 07:09:31Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$german_array = array(
	'classes' => array(
		0 => 'Unbekannt',
		1 => 'Ingenieur',
		2 => 'Wissenschaftler',
		3 => 'Taktiker',
	),
	'races' => array(
		//Federation
		'Unknown',
		'Menschen',
		'Vulkanier',
		'Bajoraner',
		'Bolian',
		'Benzite ',
		'Betazoiden',
		'Andorian',
		'Saurian',
		'Trill',
		'Tellariten',
		'Ferengi',
		'Pakled',
		//Klingon Empire
		'Orioner',
		'Gorn',
		'Nausicaaner',
		'Lethean',
		//Shared
		'Klingonen',
		'Liberated Borg',
		'Alien',
	),
	'factions' => array(
		'Föderation',
		'Klingonisches Reich'
	),
	'lang' => array(
		'sto' => 'Star Trek Online',
	),
);

?>