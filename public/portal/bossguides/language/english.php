<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2011-08-08 17:25:17 +0200 (Mo, 08. Aug 2011) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 10931 $
 * 
 * $Id: english.php 10931 2011-08-08 15:25:17Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
  'pk_bossguides_headtext'     	=> 'Bossguides',
    'bossguides_name'				=> 'Bossguides',
  'bossguides_desc'				=> 'Shows the latest Bossguides',
  'pk_hide_naxxramas'			=> 'hide Naxxramas',
  'pk_hide_malygos'  			=> 'hide Malygos',
  'pk_hide_sartharion'     		=> 'hide Sartharion',
  'pk_hide_ulduar'     			=> 'hide Ulduar',
  'pk_use_accordion'     		=> 'use Accordion',
);


/******Naxxramas*****/
$lang['naxxramas']['naxxramas'] 	= array('long' => 'Naxxramas', 'short' => 'Naxx');
$lang['naxxramas']['anubrekhan'] 	= array('long' => 'Anub\'Rekhan', 'short' => 'Anub\'Rekhan');
$lang['naxxramas']['faerlina'] 		= array('long' => 'Grand Widow Faerlina', 'short' => 'Faerlina');
$lang['naxxramas']['maexxna'] 		= array('long' => 'Maexxna', 'short' => 'Maexxna');
$lang['naxxramas']['noth'] 			= array('long' => 'Noth the Plaguebringer', 'short' => 'Noth');
$lang['naxxramas']['heigan'] 		= array('long' => 'Heigan the Unclean', 'short' => 'Heigan');
$lang['naxxramas']['loatheb'] 		= array('long' => 'Loatheb', 'short' => 'Loatheb');
$lang['naxxramas']['patchwerk'] 	= array('long' => 'Patchwerk' , 'short' => 'Patchwerk');
$lang['naxxramas']['grobbulus'] 	= array('long' => 'Grobbulus', 'short' => 'Grobbulus');
$lang['naxxramas']['gluth'] 		= array('long' => 'Gluth', 'short' => 'Gluth');
$lang['naxxramas']['thaddius'] 		= array('long' => 'Thaddius', 'short' => 'Thaddius');
$lang['naxxramas']['razuvious'] 	= array('long' => 'Instructor Razuvious', 'short' => 'Razuvious');
$lang['naxxramas']['gothik'] 		= array('long' => 'Gothik the Harvester', 'short' => 'Gothik');
$lang['naxxramas']['horseman'] 		= array('long' => 'The-Four-Horsemen', 'short' => 'Horsemen');
$lang['naxxramas']['sapphiron'] 	= array('long' => 'Sapphiron', 'short' => 'Sapphiron');
$lang['naxxramas']['kelthuzad'] 	= array('long' => 'Kel\'Thuzad', 'short' => 'Kel\'Thuzad');
$lang['naxxramas']['arachnid'] 		= array('long' => 'Arachnid Quarter', 'short' => 'Arachnid Quarter');
$lang['naxxramas']['plague'] 		= array('long' => 'Plague Quarter', 'short' => 'Plague Quarter');
$lang['naxxramas']['construct'] 	= array('long' => 'Construct Quarter', 'short' => 'Construct Quarter');
$lang['naxxramas']['military'] 		= array('long' => 'Military Quarter', 'short' => 'Military Quarter');

/******malygos*****/
$lang['malygos']['malygos'] = array('long' => 'Malygos', 'short' => 'Malygos');

/******sartharion*****/
$lang['sartharion']['sartharion'] = array('long' => 'Sartharion', 'short' => 'Sartharion');


/******ulduar*****/
$lang['ulduar']['ulduar'] 				= array('long' => 'Ulduar', 'short' => 'Ulduar');
$lang['ulduar']['hodir'] 				= array('long' => 'Hodir', 'short' => 'Hodir');
$lang['ulduar']['thorim'] 				= array('long' => 'Thorim', 'short' => 'Thorim');
$lang['ulduar']['council'] 				= array('long' => 'The Iron Council', 'short' => 'The Iron Council');
$lang['ulduar']['freya'] 				= array('long' => 'Freya', 'short' => 'Freya');
$lang['ulduar']['ignis'] 				= array('long' => 'Ignis the Furnace Master', 'short' => 'Ignis');
$lang['ulduar']['leviathan'] 			= array('long' => 'Flame Leviathan', 'short' => 'Flame Leviathan');
$lang['ulduar']['vezax'] 				= array('long' => 'General Vezax', 'short' => 'General Vezax');
$lang['ulduar']['razorscale'] 			= array('long' => 'Razorscale', 'short' => 'Razorscale');
$lang['ulduar']['deconstructor'] 		= array('long' => 'XT 002 Deconstructor', 'short' => 'Deconstructor');
$lang['ulduar']['kologarn'] 			= array('long' => 'Kologarn', 'short' => 'Kologarn');
$lang['ulduar']['auriaya'] 				= array('long' => 'Auriaya', 'short' => 'Auriaya');
$lang['ulduar']['mimiron'] 				= array('long' => 'Mimiron', 'short' => 'Mimiron');
$lang['ulduar']['saron'] 				= array('long' => 'Yogg-Saron', 'short' => 'Yogg-Saron');
$lang['ulduar']['algalon'] 				= array('long' => 'Algalon The Observer', 'short' => 'Algalon');

$bosslinks['WoW']['naxxramas']=array(
	'arachnid' 		=> 'http://www.wowwiki.com/Naxxramas#Arachnid_Quarter',
	'anubrekhan' 	=> 'http://www.wowwiki.com/Anub%27Rekhan',
	'faerlina' 		=> 'http://www.wowwiki.com/Grand_Widow_Faerlina',
	'maexxna' 		=> 'http://www.wowwiki.com/Maexxna',
	'plague' 		=> 'http://www.wowwiki.com/Naxxramas#Plague_Quarter',
	'noth' 			=> 'http://www.wowwiki.com/Noth_the_Plaguebringer',
	'heigan' 		=> 'http://www.wowwiki.com/Heigan_the_Unclean',
	'loatheb' 		=> 'http://www.wowwiki.com/Loatheb',
	'construct' 	=> 'http://www.wowwiki.com/Naxxramas#Construct_Quarter',
	'patchwerk' 	=> 'http://www.wowwiki.com/Patchwerk',
	'grobbulus' 	=> 'http://www.wowwiki.com/Grobbulus',
	'gluth' 		=> 'http://www.wowwiki.com/Gluth',
	'thaddius' 		=> 'http://www.wowwiki.com/Thaddius',
	'military' 		=> 'http://www.wowwiki.com/Naxxramas#Military_Quarter',
	'razuvious' 	=> 'http://www.wowwiki.com/Instructor_Razuvious',
	'gothik' 		=> 'http://www.wowwiki.com/Gothik_the_Harvester',	
	'horseman' 		=> 'http://www.wowwiki.com/Four_Horsemen',
	'sapphiron' 	=> 'http://www.wowwiki.com/Sapphiron',
	'kelthuzad' 	=> 'http://www.wowwiki.com/Kel%27Thuzad'
);

$bosslinks['WoW']['malygos']=array(
	'malygos' 		=> 'http://www.wowwiki.com/Malygos'
);

$bosslinks['WoW']['sartharion']=array(
	'sartharion' 	=> 'http://www.wowwiki.com/Sartharion',	
);


$bosslinks['WoW']['ulduar']=array(
	'ulduar' 					=> 'http://www.wowwiki.com/Ulduar',	
	'hodir' 					=> 'http://www.wowwiki.com/Hodir_%28tactics%29',	
	'thorim' 					=> 'http://www.wowwiki.com/Thorim_%28tactics%29',	
	'council' 					=> 'http://www.wowwiki.com/The_Iron_Council',	
	'freya' 					=> 'http://www.wowwiki.com/Freya_%28tactics%29',	
	'ignis'	 					=> 'http://www.wowwiki.com/Ignis_the_Furnace_Master',	
	'leviathan' 				=> 'http://www.wowwiki.com/Flame_Leviathan',	
	'vezax' 					=> 'http://www.wowwiki.com/General_Vezax',	
	'razorscale' 				=> 'http://www.wowwiki.com/Razorscale',	
	'deconstructor' 			=> 'http://www.wowwiki.com/XT-002_Deconstructor',	
	'kologarn' 					=> 'http://www.wowwiki.com/Kologarn',	
	'auriaya' 					=> 'http://www.wowwiki.com/Auriaya',	
	'mimiron' 					=> 'http://www.wowwiki.com/Mimiron',	
	'saron' 					=> 'http://www.wowwiki.com/Yogg-Saron_%28tactics%29',	
	'algalon' 					=> 'http://www.wowwiki.com/Algalon_the_Observer'
);

?>
