<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-03-08 15:39:58 +0100 (Thu, 08 Mar 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: hoofy $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11731 $
 * 
 * $Id: vanguard.class.php 11731 2012-03-08 14:39:58Z hoofy $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('vanguard')) {
	class vanguard extends game_generic {
		public static $shortcuts = array();
		protected $this_game	= 'vanguard';
		protected $types		= array('classes', 'filters', 'roles');
		public $icons			= array('classes');
		protected $factions		= array();
		protected $filters		= array();
		public $langs			= array('english');
		

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;
		public $version			= '2.1';

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
					array('name' => $this->glang('unknown', true, $lang), 'value' => 'class:0,1,4,7,8'),
					array('name' => $this->glang('cloth', true, $lang), 'value' => 'class:5,9,13,14,17,21'),
					array('name' => $this->glang('leather', true, $lang), 'value' => 'class:2,3,11'),
					array('name' => $this->glang('chain', true, $lang), 'value' => 'class:18,19,20'),
					array('name' => $this->glang('plate', true, $lang), 'value' => 'class:6,10,12,16,22'),
				));
			}
		}

		public function get_OnChangeInfos($install=false){

		//Do this SQL Query NOT if the Eqdkp is installed -> only @ the first install
		if($install){
			array_push($info['aq'], "UPDATE __users SET user_style = '32' ;");
			}
			return $info;
		}
	}
}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_vanguard', vanguard::$shortcuts);
?>