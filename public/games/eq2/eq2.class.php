<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-08-31 21:08:38 +0200 (Fri, 31 Aug 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12010 $
 * 
 * $Id: eq2.class.php 12010 2012-08-31 19:08:38Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('eq2')) {
	class eq2 extends game_generic {
		public static $shortcuts = array('pdh');
		protected $this_game	= 'eq2';
		protected $types		= array('classes', 'races', 'factions', 'filters');
		public $icons			= array('classes', 'races');
		protected $classes		= array();
		protected $races		= array();
		protected $factions		= array();
		protected $filters		= array();
		public $langs			= array('english', 'german');
		public $objects			= array('eq2_soe');
		public $no_reg_obj		= array('eq2_soe');	

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;
		public $version			= '2.0';
		
		public $importers 		= array(
			'char_import'		=> 'charimporter.php',						// filename of the character import
			'char_update'		=> 'charimporter.php',						// filename of the character update, member_id (POST) is passed
			'char_mupdate'		=> 'charimporter.php?massupdate=true',		// filename of the "update all characters" aka mass update
			'guild_import'		=> 'guildimporter.php',						// filename of the guild import
			'guild_imp_rsn'		=> true
		);

		public function __construct(){
			parent::__construct();
			$this->pdh->register_read_module($this->this_game, $this->path . 'pdh/read/'.$this->this_game);
		}

		/**
		* Initialises filters
		*
		* @param array $langs
		*/
		protected function load_filters($langs){
			if(!$this->classes) {
				$this->load_type('classes', $langs);
			}
			foreach($langs as $lang) {
				foreach($this->classes[$this->lang] as $id => $name) {
					$this->filters[$lang][] = array('name' => $name, 'value' => 'class:'.$id);
				}
				$this->filters[$lang] = array_merge($this->filters[$lang], array(
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('very_light', true, $lang), 'value' => 'class:5,6,11,15,23,24'),
					array('name' => $this->glang('light', true, $lang), 'value' => 'class:4,9,13,22'),
					array('name' => $this->glang('medium', true, $lang), 'value' => 'class:1,3,7,8,14,17,21'),
					array('name' => $this->glang('heavy', true, $lang), 'value' => 'class:2,10,12,16,18,20'),
				));
			}
		}

		/**
		* Returns Information to change the game
		*
		* @param bool $install
		* @return array
		*/
		public function get_OnChangeInfos($install=false){
			//classcolors
			$info['class_color'] = array(
				0 => '#E1E1E1',
				1 => '#E1E100',
				2 => '#E10000',
				3 => '#E1E100',
				4 => '#E10000',
				5 => '#0000E1',
				6 => '#0000E1',
				7 => '#00E100',
				8 => '#E1E100',
				9 => '#00E100',
				10 => '#E10000',
				11 => '#0000E1',
				12 => '#00E100',
				13 => '#E10000',
				14 => '#00E100',
				15 => '#0000E1',
				16 => '#E10000',
				17 => '#E1E100',
				18 => '#E10000',
				19 => '#E1E100',
				20 => '#00E100',
				21 => '#E1E100',
				22 => '#00E100',
				23 => '#0000E1',
				24 => '#0000E1',
			);

			//lets do some tweak on the templates dependent on the game
			$info['aq'] = array();

			//Do this SQL Query NOT if the Eqdkp is installed -> only @ the first install
			#if($install){
			#}
			return $info;
		}
	}#class
}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_eq2', eq2::$shortcuts);
?>