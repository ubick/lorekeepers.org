<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2007
 * Date:		$Date: 2013-01-12 22:52:22 +0100 (Sat, 12 Jan 2013) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12817 $
 * 
 * $Id: admin_data.php 12817 2013-01-12 21:52:22Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$settingsdata_admin = array(
	'game' => array(
		'swtorsettings' => array(
			'swtor_faction'	=> array(
				'name'		=> 'swtor_faction',
				'fieldtype'	=> 'dropdown',
				'size'		=> '1',
				'options'	=> registry::register('game')->get('factions'),
				'default'	=> 0
			),
		)
	)
);

?>