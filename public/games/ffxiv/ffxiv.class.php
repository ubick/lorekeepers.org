<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2010
 * Date:		$Date: 2012-03-08 15:39:58 +0100 (Thu, 08 Mar 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: hoofy $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11731 $
 * 
 * $Id: ffxiv.class.php 11731 2012-03-08 14:39:58Z hoofy $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('ffxiv')) {
	class ffxiv extends game_generic {
		public static $shortcuts = array();
		protected $this_game	= 'ffxiv';
		protected $types		= array('classes', 'races', 'factions', 'filters');
		public $icons			= array('classes', 'events', 'races', 'ranks');
		protected $classes		= array();
		protected $races		= array();
		protected $filters		= array();
		public $langs			= array('english');

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;
		public $version			= '1.0';

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
				$names = $this->classes[$this->lang];
				$this->filters[$lang][] = array('name' => '-----------', 'value' => false);
				foreach($names as $id => $name) {
					$this->filters[$lang][] = array('name' => $name, 'value' => 'class:'.$id);
				}
				$this->filters[$lang] = array_merge($this->filters[$lang], array(
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('tank', true, $lang), 'value' => 'class:10,11'),
					array('name' => $this->glang('support', true, $lang), 'value' => 'class:1,3,5,6,14,16,17,20'),
					array('name' => $this->glang('damage_dealer', true, $lang), 'value' => 'class:2,4,7,8,9,12,13,18,19'),
				));
			}
		}

		/**
		* Returns ImageTag with class-icon
		*
		* @param int $class_id
		* @param bool $big
		* @param bool $pathonly
		* @return html string
		*/
		public function decorate_classes($class_id, $big=false, $pathonly=false){
			$icon_path = $this->root_path.'games/'.$this->game.'/classes/'.$class_id.(($big) ? '_b.png' : '.gif');
			if($pathonly) {
				return $icon_path;
			}
			return "<img src='".$icon_path."' />";
		}

		public function get_OnChangeInfos($install=false){
			$info['class_color'] = array(
				0	=> '#808080',
				1	=> '#808080',
				2	=> '#808080',
				3	=> '#808080',
				4	=> '#808080',
				5	=> '#808080',
				6	=> '#808080',
				7	=> '#808080',
				8	=> '#808080',
				9	=> '#808080',
				10	=> '#808080',
				11	=> '#808080',
				12	=> '#808080',
				13	=> '#808080',
				14	=> '#808080',
				15	=> '#808080',
				16	=> '#808080',
				17	=> '#808080',
				18	=> '#808080',
			);

			$info['aq'] = array();

			//Do this SQL Query NOT if the Eqdkp is installed -> only @ the first install
			#if($install){
			#}
			return $info;
		}
	}
}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_ffxiv', ffxiv::$shortcuts);
?>