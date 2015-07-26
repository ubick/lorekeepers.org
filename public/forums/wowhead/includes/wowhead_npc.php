<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - NPC Extension
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

include_once(dirname(__FILE__) . '/../config.php');
include_once(dirname(__FILE__) . '/wowhead.php');
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_npc extends wowhead
{
	public $lang;
	public $patterns;
	public $language;
	public $image_path;
	public $wowhead_zone_maps = 'http://static.wowhead.com/images/maps/enus/normal/';

	public function __construct()
	{
		$this->patterns = new wowhead_patterns();
		$this->language = new wowhead_language();
		$this->images_path = dirname(__FILE__) . '/../images/zones/';
	}
	
	public function close()
	{
		unset($this->lang, $this->language, $this->patterns);	
	}

	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		$cache = new wowhead_cache();

		if (!$result = $cache->getNPC($name, $this->lang))
		{
			// not found in cache

			$result = $this->getNPCInfo($name);
			if (!$result)
			{
				// not found
				$cache->close();
				return $this->_notFound($this->language->words['npc'], $name);
			}
			else
			{
				// see if they want to display a map as well
				if (array_key_exists('map', $args))
				{
					if (!$sql_map = $cache->getZone($args['map']['name'], $this->lang))
					{
						$mapinfo = $this->getZoneMap($args['map']['name']);
						if (!$mapinfo)
						{
							$cache->close();
							return $this->_notFound($this->language->words['zone'], $name);
						}
						else
						{
							if (!file_exists($this->images_path . $mapinfo['map']) && WHP_TRANSFER_MAP == true)
							{
								// file doesn't exist, so transfer it locally
								$this->transferImage($mapinfo['map']);	
							}
							$cache->saveZone($mapinfo);
							$mapinfo['x'] = $args['map']['x'];
							$mapinfo['y'] = $args['map']['y'];
							$cache->saveNPC($result);
							$cache->close();
							return $this->mapHTML($result, $mapinfo);
						}
					}
					else
					{
						if (!file_exists($this->images_path . $sql_map['map']) && WHP_TRANSFER_MAP == true)
						{
							// file doesn't exist, so transfer it locally
							$this->transferImage($sql_map['map']);	
						}
						$sql_map['x'] = $args['map']['x'];
						$sql_map['y'] = $args['map']['y'];
						$cache->saveNPC($result);
						$cache->close();
						return $this->mapHTML($result, $sql_map);	
					}
				}
				else
				{
					// found, save it and display
					$cache->saveNPC($result);
					$cache->close();
					return $this->generateHTML($result, 'npc');
				}
			}
		}
		else
		{
			if (array_key_exists('map', $args))
			{
				$mapinfo = $cache->getZone($args['map']['name'], $this->lang);
				if (!file_exists($this->images_path . $mapinfo['map']) && WHP_TRANSFER_MAP == true)
				{
					// file doesn't exist, so transfer it locally
					$this->transferImage($mapinfo['map']);	
				}
				$mapinfo['x'] = $args['map']['x'];
				$mapinfo['y'] = $args['map']['y'];
				$cache->close();
				return $this->mapHTML($result, $mapinfo);
			}
			else
			{
				$cache->close();
				return $this->generateHTML($result, 'npc');
			}
		}
	}
	
	private function transferImage($image)
	{
		if (!is_writable($this->images_path))
			trigger_error('The directory for storing the zone images (' . $this->images_path . ') is not writable.  Please CHMOD to 0755 or 0777 and then try again,', E_USER_ERROR);	
		
		// make sure the image isn't already there
		if (!file_exists($this->images_path . $image))
		{
			if (!@file_put_contents($this->images_path . $image, @file_get_contents($this->wowhead_zone_maps . $image)))
				trigger_error('Failed to transfer the zone map to the local webserver.', E_USER_ERROR);
			else
				@chmod($this->images_path . $image, 0777);
		}
	}
	
	private function getZoneMap($name)
	{
		$data = $this->_read_url($name, 'zone', false);
		if (!$data)
		{
			// something went wrong
			return false;
		}
		else
		{
			// how we get the data depends on whether its a name or id
			if (is_numeric($name))
			{
				// its numeric, so most likely an id
				// stolen from wowhead_zones.php's function
				if (!preg_match('#name: \'(.+?)\'};#s', $this->nameLine($data), $match))
				{
					return false;	
				}
				else
				{
					return array(
						'id'			=>	$name,
						'name'			=>	stripslashes($match[1]),
						'search_name'	=>	$name,
						'map'			=>	$name . '.jpg',
						'lang'			=>	$this->lang
					);
				}	
			}
			else
			{
				// otherwise, its a name
				// also stolen from wowhead_zones.php
				if (!preg_match('#id:([0-9]{1,8}),name:\'(.+?)\',#s', $this->zoneLine($data), $match))
				{
					return false;
				}
				else
				{
					return array(
						'id'			=>	(int)$match[1],
						'name'			=>	stripslashes($match[2]),
						'search_name'	=>	$name,
						'map'			=>	(int)$match[1] . '.jpg',
						'lang'			=>	$this->lang
					);	
				}
			}
		}
	}
	
	private function mapHTML($npc, $map)
	{
		$html = $this->patterns->pattern('npc_map');
		$html = str_replace('{link}', $this->_generateLink($npc['npcid'], 'npc'), $html);
		$html = str_replace('{maplink}', $this->_generateLink($map['id'], 'zone'), $html);
		$html = str_replace('{name}', $npc['name'], $html);
		$html = str_replace('{id}', $map['id'], $html);
		$html = str_replace('{lang}', $this->lang, $html);
		$html = str_replace('{pins}', $map['x'] . ',' . $map['y'], $html);
		return $html;
	}


	private function getNPCInfo($name)
	{

		if (trim($name) == '')
			return false;

		if (!is_numeric($name))
		{
			$data = $this->_read_url($name, 'npc', false);
			// get the id of the npc
			if (preg_match('#Location: /\?npc=([0-9]{1,10})#s', $data, $match))
			{
				$id = $match[1];
			}
			else
			{
				$id = $this->getIDFromSearch($name, $data);

				if (!$id) { return false; }
			}
			$npc_name = ucwords($name);
		}
		else
		{
			$data = $this->_read_url($name, 'npc', false);
			$npc_name = $this->getNPCNameFromID($data);
			$id = $name;
		}

		return array(
			'npcid'			=>	$id,
			'name'			=>	$npc_name,
			'search_name'	=>	$name,
			'lang'			=>	$this->lang
		);
	}

	private function getIDFromSearch($name, $data)
	{
		if (trim($data) == '')
			return false;

		// the line we need to pull the info from
		$line = $this->npcSearchLine($data);
		if (WOWHEAD_DEBUG == true) { print $line . '<br/>'; }
		while (preg_match('#id:([0-9]{1,10}),name:\'(.+?)\',#s', $line, $match))
		{
			if (urldecode(addslashes(strtolower($match[2]))) == urldecode(addslashes(strtolower($name))))
			{
				// we have a match
				return $match[1];
			}
			else
			{
				// no match so replace the line to prevent a never-ending loop
				$line = str_replace($match[0], '', $line);
			}
		}

		// otherwise, return false
		return false;
	}

	private function npcSearchLine($data)
	{
		$parts = explode(chr(10), $data);

		foreach ($parts as $line)
		{
			if (strpos($line, "new Listview({template: 'npc', id: 'npcs'") !== false)
			{
				return $line;
			}
		}
		return false;
	}

	private function getNPCNameFromID($data)
	{
		while (preg_match('#<h1>(.+?)</h1>#s', $data, $match))
		{
			if (strpos($match[1], "World of Warcraft") === false) {
				return $match[1];
			}
			else
			{
				$data = str_replace($match[0], '', $data);
			}
		}
	}
	
	private function nameLine($data)
	{
		$parts = explode(chr(10), $data);
		foreach ($parts as $line)
		{	
			if (strpos($line, 'var g_pageInfo = {type:') !== false)
			{
				return $line;
				break;
			}
		}
		
		// returns false if line isn't found
		return false;
	}
	
	private function zoneLine($data)
	{
		$parts = explode(chr(10), $data);
		foreach ($parts as $line)
		{
			if (strpos($line, "new Listview({template: 'zone', id: 'zones', name:") !== false)
			{
				return $line;
				break;	
			}
		}
		
		// if line isn't found then fail
		return false;
	}
}

?>