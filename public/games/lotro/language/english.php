<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-12-08 12:27:54 +0100 (Sat, 08 Dec 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12569 $
 * 
 * $Id: english.php 12569 2012-12-08 11:27:54Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$english_array = array(
	'classes' => array(
		0 => 'Unknown',
		1 => 'Minstrel',
		2 => 'Captain',
		3 => 'Hunter',
		4 => 'Lore-master',
		5 => 'Burglar',
		6 => 'Guardian',
		7 => 'Champion',
		8 => 'Runekeeper',
		9 => 'Warden',
	),
	'races' => array(
		'Unknown',
		'Man',
		'Hobbit',
		'Elf',
		'Dwarf'
	),
	'factions' => array(
		'Free People',
		'MonsterPlay'
	),
	'roles' => array(
		1 => array(1,8),
		2 => array(6,7,9),
		3 => array(4,5),
		4 => array(3,7,8,9),
		5 => array(2)
	),
	'lang' => array(
		'lotro' => 'The Lord of the Rings Online',
		'heavy' => 'Heavy Armour',
		'medium' => 'Medium Armour',
		'light' => 'Light Armour',
		'role1' => 'Healer',
		'role2' => 'Tank',
		'role3' => 'Crowd Control',
		'role4' => 'Damage Dealer',
		'role5' => 'Supporter',

		// Profile Admin area
		'pk_tab_fs_lotrosettings'					=> 'LOTRO Settings',
		'uc_faction'							=> 'Faction',
		'uc_faction_help'					=> 'Free People / MonsterPlay',
		'uc_fact_pvp'							=> 'MonsterPlay',
		'uc_fact_pve'							=> 'Free People',
		'uc_server_loc'						=> 'Server location',
		'uc_server_loc_help'			=> 'Location of your LOTRO-server',
		'uc_servername'						=> 'Server name',
		'uc_servername_help'			=> 'Name of your LOTRO-server (p.e. Bullroarer)',
		'uc_lockserver'						=> 'Lock the server name for users',
		'uc_lockserver_help'			=> '',
		
		'uc_import_guild'				=> 'Import Guild',
		'uc_import_guild_help'			=> 'Import all characters of a guild',
		'uc_update_all'					=> 'Update all profile information with data from MyLotro',
		'uc_importer_cache'				=> 'Reset importer cache',
		'uc_importer_cache_help'		=> 'Delete all the cached data of the import class.',
		'uc_bttn_update'				=> 'Update',
		
		'uc_class_filter'				=> 'Only character of the class',
		'uc_class_nofilter'				=> 'No filter',
		'uc_guild_name'					=> 'Name of the guild',
		'uc_filter_name'				=> 'Filter',
		'uc_level_filter'				=> 'All characters with a level higher than',
		'uc_imp_novariables'			=> 'You first have to set a realmserver and it\'s location in the settings.',
		'uc_imp_noguildname'			=> 'The name of the guild has not been given.',
		'uc_gimp_loading'				=> 'Loading guild characters, please wait...',
		'uc_gimp_header_fnsh'			=> 'Guild import finished',
		'uc_importcache_cleared'		=> 'The cache of the importer was successfully cleared.',
		"uc_updat_armory" 				=> "Refresh from armory",
		'uc_delete_chars_onimport'		=> 'Delete Chars that have left the guild',
		
		'uc_noprofile_found'			=> 'No profile found',
		'uc_profiles_complete'			=> 'Profiles updated successfully',
		'uc_notyetupdated'				=> 'No new data (inactive character)',
		'uc_notactive'					=> 'This character will be skipped because it is set to inactive',
		'uc_error_with_id'				=> 'Error with this character\'s id, it has been left out',
		'uc_notyourchar'				=> 'ATTENTION: You currently try to import a character that already exists in the database but is not owned by you. For security reasons, this action is not permitted. Please contact an administrator for solving this problem or try to use another character name.',
		'uc_lastupdate'					=> 'Last Update',
		
		'uc_prof_import'				=> 'import',
		'uc_import_forw'				=> 'continue',
		'uc_imp_succ'					=> 'The data has been imported successfully',
		'uc_upd_succ'					=> 'The data has been updated successfully',
		'uc_imp_failed'					=> 'An error occured while updating the data. Please try again.',
		
		'uc_charname'					=> 'Character\'s name',
		'uc_servername'					=> 'Server\'s name',
		'uc_charfound'					=> "The character <b>%1\$s</b> has been found in the armory.",
		'uc_charfound2'					=> "This character was updated on <b>%1\$s</b>.",
		'uc_charfound3'					=> 'ATTENTION: Importing will overwrite the existing data!',
		'uc_armory_confail'				=> 'No connection to the armory. Data could not be transmitted.',
		'uc_armory_imported'			=> 'Imported',
		'uc_armory_impfailed'			=> 'Failed',
		'uc_armory_impduplex'			=> 'already existing',

		'no_data'						=> 'There is no data available for this character. Please check if the right server was chosen in the administration settings.',

		'vocation'						=> 'Vocation',
		'profession1'					=> 'First profession',
		'profession2'					=> 'Second profession',
		'profession3'					=> 'Third profession',
		'profession1_proficiency'		=> 'Proficiency-level first profession',
		'profession2_proficiency'		=> 'Proficiency-level second profession',
		'profession3_proficiency'		=> 'Proficiency-level third profession',
		'profession1_mastery'			=> 'Mastery-level first profession',
		'profession2_mastery'			=> 'Mastery-level second profession',
		'profession3_mastery'			=> 'Mastery-level third profession',
		
		//Events
		'event1' => 'Annùminas: Glinghant',
		'event2' => 'Annùminas: Ost Elendil',
		'event3' => 'Annùminas: Haudh Valandil',
		'event4' => 'Fornost: Wrath of Water',
		'event5' => 'Fornost: Wrath of Earth',
		'event6' => 'Fornost: Wrath of Fire',
		'event7' => 'Fornost: Wrath of Shadow',
		'event8' => 'Great Barrow: The Maze',
		'event9' => 'Great Barrow: Thadúr',
		'event10' => 'Great Barrow: Sambrog',
		'event11' => 'Helegrod: Dragon Wing',
		'event12' => 'Helegrod: Drake Wing',
		'event13' => 'Helegrod: Giant Wing',
		'event14' => 'Helegrod: Spider Wing',
		'event15' => 'Other instances: Halls of Nights',
		'event16' => 'Other instances: Inn of the Forsaken',
		'event17' => 'Other instances: Library of Tham Mírdain',
		'event18' => 'Other instances: School at Tham Mírdain',
		'event19' => 'Isengard: The Tower of Orthanc',
		'event20' => 'Isengard: The Foundry',
		'event21' => 'Isengard: Dargnákh Unleashed',
		'event22' => 'Isengard: Pits of Isengard',
		'event23' => 'Isengard: Fangorn\'s Edge',
		'event24' => 'Isengard: Draigoch\'s Lair',
		'event25' => 'Limlight Gorge: Roots of Fangorn',
		'event26' => 'Skirmish (defensive): Ford of Bruinen',
		'event27' => 'Skirmish (defensive): Siege of Gondamon',
		'event28' => 'Skirmish (defensive): Stand at Amon Súl',
		'event29' => 'Skirmish (defensive): Defence of The Prancing Pony',
		'event30' => 'Skirmish (defensive): Protectors of Thangúlhad',
		'event31' => 'Skirmish (defensive): Battle of the Deep-Way',
		'event32' => 'Skirmish (defensive): Battle of the Way of Smiths',
		'event33' => 'Skirmish (defensive): Battle of the Twenty-first Hall',
		'event34' => 'Skirmish (offensive): Trouble in Tuckborough',
		'event35' => 'Skirmish (offensive): Strike against Dannanglor',
		'event36' => 'Skirmish (offensive): Breaching the Nocromancer\'s Gate',
		'event37' => 'Skirmish (offensive): Assault on the Ringwraiths\' Lair',
		'event38' => 'Skirmish (offensive): The Battel in the Tower',
		'event39' => 'Skirmish (offensive): Thievery and Mischief',
		'event40' => 'Skirmish (offensive): Rescue in Núrz Gháshu',
		'event41' => 'Skirmish (offensive): The Icy Crevasse',
		'event42' => 'Skirmish (offensive): Attack At Dawn',
		'event43' => 'Skirmish (offensive): Storm on Methedras',
		'event44' => 'Skirmish (survival): Barrow-downs',
		'event45' => 'Angmar: Carn Dúm',
		'event46' => 'Angmar: Urugarth',
		'event47' => 'Angmar: Barad Gularan',
		'event48' => 'Angmar: The Rift of Núrz Gháshu',
		'event49' => 'Dol Guldur: Barad Guldur',
		'event50' => 'Dol Guldur: Sammath Gúl',
		'event51' => 'Dol Guldur: Warg-pens of Dol Guldur',
		'event52' => 'Dol Guldur: Dungeons of Dol Guldur',
		'event53' => 'Dol Guldur: Sword-hall of Dol Guldur',
		'event54' => 'Garth Agarwen: Fortress',
		'event55' => 'Garth Agarwen: Arboretum',
		'event56' => 'Garth Agarwen: Barrows',
		'event57' => 'In Their Absence: Feste Dunoth',
		'event58' => 'In Their Absence: Sári-Surma',
		'event59' => 'In Their Absence: Lost Temple',
		'event60' => 'In Their Absence: The Northcotton Farm',
		'event61' => 'In Their Absence: Stoneheight',
		'event62' => 'Lothlórien: Dár Narbugud',
		'event63' => 'Lothlórien: Halls of Crafting',
		'event64' => 'Lothlórien: The Mirror-halls of Lumul-nar',
		'event65' => 'Lothlórien: The Water Wheels: Nalá-dúm',
		'event66' => 'Moria: The Vile Maw',
		'event67' => 'Moria: Filikul',
		'event68' => 'Moria: The Grand Stair',
		'event69' => 'Moria: Skúmfíl',
		'event70' => 'Moria: The Forges of Khazad-dúm',
		'event71' => 'Moria: Fil Gashan',
		'event72' => 'Moria: Dark Delving',
		'event73' => 'Moria: The Sixteenth Hall',
		'event74' => 'Moria: The Forgotten Treasury',
		'event75' => 'Goblins Town: Goblin-town Throne Room',
		'event76' => 'Skirmish (12)',
		'event77' => 'Skirmish (6)',
	),
);
?>