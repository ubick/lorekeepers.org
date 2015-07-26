<?php
/*
* Project:     EQdkp-Plus Raidlogimport
* License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
* Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
* -----------------------------------------------------------------------
* Began:       2009
* Date:        $Date: 2013-03-24 19:46:58 +0100 (So, 24 Mrz 2013) $
* -----------------------------------------------------------------------
* @author      $Author: hoofy_leon $
* @copyright   2008-2009 hoofy_leon
* @link        http://eqdkp-plus.com
* @package     raidlogimport
* @version     $Rev: 13243 $
*
* $Id: rli_parse.class.php 13243 2013-03-24 18:46:58Z hoofy_leon $
*/

if(!defined('EQDKP_INC'))
{
	header('HTTP/1.0 Not Found');
	exit;
}

if(!class_exists('rli_parser')) {
abstract class rli_parser {
	// name of this parser, to identify it in settings
	public static $name = 'name not set';
	
	// flag wether the log is xml
	public static $xml = true;
	
	/* 	array to check for correct xml-input and allow for outputting problems to user, leave empty for non-xml based parsers.
	 *	array, which describes the xml: array(node => array(node => ''));
	 *		if prefix is "optional:", the node is only checked for completion
	 *		if prefix is "multiple:", all occuring nodes are checked
	 */
	public static $check_array = array();
	
	/*	parse information
	 *	@input	(string)	string to fetch information from		
	 *	@output	(array)		array storing the information as follows, bracketed arguments are (optional), not all types are necessary
	 *						array(
	 *							'zones' => array(name, jointime, leavetime, (difficulty)),
	 *							'bosses' => array(name, time, (difficulty)),
	 *							'members' => array(name, (class), (race), (level), (note)),
	 *							'times' => array(membername, time, type=join/leave, (extra)),
	 *							'items' => array(name, member, cost, (ingameid), (time))
	 *						)
	 */
	public static function parse($input) { return null; }

	/*	check if string is in correct format/contains readable data/return error information
	 *	@input	(string)	string to fetch information from		
	 *	@output	(array)		array giving the feedback
	 *						array(	1 => boolean (passed/failed check),
	 *								2 => node_list (in case of fail array with missing nodes)
	 *						)
	 */
	public static function check($input) { return null; }
	
	/**
	 *	predefined function to check for correct xml
	 *	checks wether all nodes are available (if not optional) and complete.
	 *	returns an array(1 => bool, 2 => array( contains strings of missing/wrong nodes ))
	 *	params: xml => xml to check
	 *			xml_form => array, which describes the xml: array(node => array(node => ''));
	 *					if prefix is "optional:", the node is only checked for completion
	 *					if prefix is "multiple:", all occuring nodes are checked
	 */
	protected static function check_xml_format($xml, $xml_form, $back=array(1 => true), $pre='') {
		foreach($xml_form as $name => $val) {
			$optional = false;
			if(strpos($name, 'optional:') !== false) {
				$name = str_replace('optional:', '', $name);
				$optional = true;
			}
			$multiple = false;
			if(strpos($name, 'multiple:') !== false) {
				$name = str_replace('multiple:', '', $name);
				$multiple = true;
			}
			if($multiple) {
				$pre .= $name.'->';
				foreach($val as $nname => $vval) {
					$optional = false;
					if(strpos($nname, 'optional:') !== false) {
						$nname = str_replace('optional:', '', $nname);
						$optional = true;
					}
					if((!isset($xml->$name->$nname)) AND !$optional) {
						$back[1] = false;
						$back[2][] = $pre.$nname;
					} else {
						if(isset($xml->$name)) {
							if(is_array($vval)) {
								foreach($xml->$name->children() as $child) {
									$back = self::check_xml_format($child, $vval, $back, $pre);
								}
								$pre = substr($pre, 0, -(strlen($nname)+2));
							} else {
								foreach($xml->$name->children() as $child) {
									if((!isset($child) OR trim($child) == '') AND !$optional) {
										$back[1] = false;
										$back[2][] = $pre.$name;
									}
								}
							}
						} else {
							$back[1] = false;
							$back[2][] = $name;
						}
					}
					$pre = '';
				}
			} else {
				if((!isset($xml->$name) OR (trim($xml->$name) == '') AND !is_array($val)) AND !$optional) {
					$back[1] = false;
					$back[2][] = $pre.$name;
				} else {
					if(is_array($val)) {
						$pre .= $name.'->';
						$back = self::check_xml_format($xml->$name, $val, $back, $pre);
						$pre = '';
					}
				}
			}
			if(strpos((string)$val, 'function:') !== false) {
				$func = str_replace('function:', '', $val);
				$back = call_user_func($func, $xml->name, $back);
			}
		}
		return $back;
	}
}
}
?>