<?php
/**
* Wowhead (wowhead.com) Item Link Parser v3 - Parse Script
* By: Adam "craCkpot" Koch (support@wowhead-tooltips.com)
**/

/**
    Copyright (C) 2010  Adam Koch

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/includes/wowhead_armory.php');		// armory
include_once(dirname(__FILE__) . '/includes/wowhead_achievement.php');	// achievements
include_once(dirname(__FILE__) . '/includes/wowhead_craft.php');		// craftables
include_once(dirname(__FILE__) . '/includes/wowhead_enchant.php');		// enchants
include_once(dirname(__FILE__) . '/includes/wowhead_faction.php');		// faction
include_once(dirname(__FILE__) . '/includes/wowhead_guild.php');		// guilds
include_once(dirname(__FILE__) . '/includes/wowhead_item.php');			// items
include_once(dirname(__FILE__) . '/includes/wowhead_itemico.php');		// itemico
include_once(dirname(__FILE__) . '/includes/wowhead_itemset.php');		// itemsets
include_once(dirname(__FILE__) . '/includes/wowhead_npc.php');			// npcs
include_once(dirname(__FILE__) . '/includes/wowhead_object.php');		// objects
include_once(dirname(__FILE__) . '/includes/wowhead_profile.php');		// profiles
include_once(dirname(__FILE__) . '/includes/wowhead_quest.php');		// quests
include_once(dirname(__FILE__) . '/includes/wowhead_recruit.php');		// recruits
include_once(dirname(__FILE__) . '/includes/wowhead_spell.php');		// spells
include_once(dirname(__FILE__) . '/includes/wowhead_zones.php');		// zones

// check to make sure that the correct PHP version is used and SimpleXML is enabled
if (version_compare(PHP_VERSION, '5.0.0') < 0)
	die('This script requires PHP version 5.0.0 or higher.  You\'re using ' . PHP_VERSION . '.  Speak to your host about upgrading to PHP 5.');
elseif (!function_exists('simplexml_load_string'))
	die('This script requires SimpleXML to be enabled.  Speak to your host about enabling it.');

// new arguments function
function whp_get_args($in)
{
	$args = array();
	if (strlen($in) == 0) { return array(); }

	if (preg_match('/loc="(.+?)"/', $in, $match))
	{
		$args['loc'] = $match[1];
		$in = str_replace($match[0], '', $in);
	}
	
	// handle npc maps
	if (preg_match('/map="(.+?)"/', $in, $match))
	{
		$parts = explode(':', $match[1]);
		$coord = explode(',', $parts[1]);
		$args['map']['name'] = $parts[0];
		$args['map']['x'] = $coord[0];
		$args['map']['y'] = $coord[1];
		$in = str_replace($match[0], '', $in);	
	}
	
	$in = str_replace('"', '', $in);
	
	$in_array = explode(' ', $in);

	foreach ($in_array as $value)
	{
		if ($value == 'nomats')
		{
			$args['nomats'] = true;
		}
		elseif ($value == 'noicons')
		{
			$args['noicons'] = true;
		}
		elseif ($value == 'noclass')
		{
			$args['noclass'] = true;
		}
		elseif ($value == 'norace')
		{
			$args['norace'] = true;
		}
		elseif ($value == 'icon')
		{
			$args['icon'] = true;
		}
		elseif ($value == 'gearlist')
		{
			$args['gearlist'] = true;	
		}
		else
		{
			$pre = substr($value, 0, strpos($value, '='));
			$post = substr($value, strpos($value, '=') + 1);
			$args[$pre] = html_entity_decode($post, ENT_QUOTES);
		}

	}
	return $args;
}

// builds the tags for the preg_match
// used for disabling modules
function whp_get_modules($whp_modules)
{
	if (!is_array($whp_modules))
		return false;
	
	$enabled = array();
	foreach ($whp_modules as $module => $enable)
	{
		if ($enable == true)
			$enabled[] = $module;
	}
	
	// combine all the enabled modules with a pipe (|)
	return implode('|', $enabled);
}

function whp_parse($whp_message)
{
	global $whp_modules;
	
	$parses = 0;
	
	// get the enabled modules
	$modules = whp_get_modules($whp_modules);
	
	if (!$modules)
		return $whp_message;
	
	while ((WHP_MAX_PARSES == 0 || $parses < WHP_MAX_PARSES) &&
		preg_match('#\[(' . $modules . ') (.+?)\](.+?)\[/(' . $modules . ')\]#s', $whp_message, $match) ||
		preg_match('#\[(' . $modules . ')\](.+?)\[/(' . $modules . ')\]#s', $whp_message, $match))
	{
		if (strpos($match[2], 'lang=') !== false || strpos($match[2], 'nomats') !== false || strpos($match[2], 'enchant=') !== false ||
			strpos($match[2], 'size=') !== false || strpos($match[2], 'rank=') !== false || strpos($match[2], 'gems=') !== false ||
			strpos($match[2], 'loc=') !== false || strpos($match[2], 'noicons') !== false || strpos($match[2], 'noclass') !== false ||
			strpos($match[2], 'norace') !== false || strpos($match[2], 'icon') !== false || strpos($match[2], 'gearlist') !== false ||
			strpos($match[2], 'pins=') !== false || strpos($match[2], 'map') !== false || strpos($match[2], 'wowhead') !== false)
		{
			// get the parameters
			$args = whp_get_args(html_entity_decode($match[2], ENT_QUOTES));
		}
		else
		{
			$args = array();
		}

		// create the class
		switch ($match[1])
		{
			case 'item':
				$object = new wowhead_item();
				break;
			case 'itemico':
				$object = new wowhead_itemico();
				break;
			case 'spell':
				$object = new wowhead_spell();
				break;
			case 'quest':
				$object = new wowhead_quest();
				break;
			case 'achievement':
				$object = new wowhead_achievement();
				break;
			case 'itemset':
				$object = new wowhead_itemset();
				break;
			case 'craft':
				$object = new wowhead_craft();
				break;
			case 'npc':
				$object = new wowhead_npc();
				break;
			case 'object':
				$object = new wowhead_object();
				break;
			case 'profile':
				$object = new wowhead_profile();
				break;
			case 'armory':
				$object = new wowhead_armory();
				break;
			case 'guild':
				$object = new wowhead_guild();
				break;
			case 'recruit':
				$object = new wowhead_recruit();
				break;
			case 'zone':
				$object = new wowhead_zones();
				break;
			case 'faction':
				$object = new wowhead_faction();
				break;
			case 'enchant':
				$object = new wowhead_enchant();
				break;
			default:
				break;
		}

		$name = (sizeof($args) > 0) ? html_entity_decode($match[3], ENT_QUOTES) : html_entity_decode($match[2], ENT_QUOTES);

		// prevent any unwanted script execution or html formatting
		$name = strip_tags($name);

		if (trim($name) == '')
		{
		    $whp_message = str_replace($match[0], "<span class=\"notfound\">Illegal HTML/JavaScript found. Tags removed.</span>", $whp_message);
		}
		else
		{
		    $whp_message = str_replace($match[0], $object->parse($name, $args), $whp_message);
		}
		$parses++;
		
		// clean things up
		$object->close(); unset($object);
	}
	return $whp_message;
}
?>