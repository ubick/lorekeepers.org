<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-07-22 22:02:26 +0200 (So, 22. Jul 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11870 $
 * 
 * $Id: bossguides_portal.class.php 11870 2012-07-22 20:02:26Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class bossguides_portal extends portal_generic {
	public static function __shortcuts() {
		$shortcuts = array('user', 'core', 'jquery', 'game', 'config');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

	protected $path		= 'bossguides';
	protected $data		= array(
		'name'			=> 'Bossguides',
		'version'		=> '1.0.2',
		'author'		=> 'Corgan',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Shows you the latest Bossguides',
	);
	protected $positions = array('middle', 'left1', 'left2', 'right','bottom');
	protected $settings	= array(
		'pk_bossguides_accordion'	=> array(
			'name'		=> 'pk_bossguides_accordion',
			'language'	=> 'pk_use_accordion',
			'property'	=> 'checkbox',
			'help'		=> '',
		),
		'pk_bossguides_hide_naxx'	=> array(
			'name'		=> 'pk_bossguides_hide_naxx',
			'language'	=> 'pk_hide_naxxramas',
			'property'	=> 'checkbox',
			'size'		=> '30',
			'help'		=> '',
		),
		'pk_bossguides_hide_malygos'	=> array(
			'name'		=> 'pk_bossguides_hide_malygos',
			'language'	=> 'pk_hide_malygos',
			'property'	=> 'checkbox',
			'size'		=> '30',
			'help'		=> '',
		),
		'pk_bossguides_hide_sartharion'	=> array(
			'name'		=> 'pk_bossguides_hide_sartharion',
			'language'	=> 'pk_hide_sartharion',
			'property'	=> 'checkbox',
			'size'		=> '30',
			'help'		=> '',
		),
		'pk_bossguides_hide_ulduar'	=> array(
			'name'		=> 'pk_bossguides_hide_ulduar',
			'language'	=> 'pk_hide_ulduar',
			'property'	=> 'checkbox',
			'size'		=> '30',
			'help'		=> '',
		),
	);
	protected $install	= array(
		'autoenable'		=> '0',
		'defaultposition'	=> 'right',
		'defaultnumber'		=> '5',
	);

	public function output() {
		$actgame = $this->game->get_game();

		// Set the output: If custom one is entered in the setting output this one
		// $this->config->get for config values, $this->user->lang for language values
		$output = "<table width='100%' class='colorswitch hoverrows'>";

		//instanzen
		foreach ($this->user->lang($actgame) as $k => $v) {	
			if ($k == 'naxxramas' && $this->config->get('pk_bossguides_hide_naxx')) {
				continue ;
			}
			if ($k == 'malygos' && $this->config->get('pk_bossguides_hide_malygos')) {
				continue ;
			}
			if ($k == 'sartharion' && $this->config->get('pk_bossguides_hide_sartharion')) {
				continue ;
			}
			if ($k == 'ulduar' && $this->config->get('pk_bossguides_hide_ulduar')) {
				continue ;
			}else {
				$output .= "<tr><th>".ucfirst($k)."</th></tr>";
				$acc_output = '';

				foreach ($this->user->lang(array($actgame, $k)) as $key => $value) {
					$tmp_output	 = '';
					$tmp_output	.= '<tr><td class="nowrap">';
					$tmp_output	.= '<a href="'.$value.'" target="blank" class="menu_arrow">'.$this->user->lang(array($k, $key, 'short')).'</a> <br/>';
					$tmp_output	.= "</td></tr>";
					$acc_output	.= $tmp_output;
					$output		.=  $tmp_output;
				}
				$accordion[ucfirst($k)] = "<table width='100%' class='colorswitch hoverrows'>".$acc_output."</table>";
			}
		}
		$output .= "</table>";

		// return the output for module manager
		if ($this->config->get('pk_bossguides_accordion') && isset($accordion)){
			return $this->jquery->Accordion('module_bossguides', $accordion);
		}
		return $output;
	}
}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_bossguides_portal', bossguides_portal::__shortcuts());
?>