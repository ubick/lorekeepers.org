<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Zones Module
* By: Adam "craCkpot" Koch (tooltips@crackpot.us)
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
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_zones extends wowhead
{
	public $lang;
	public $patterns;
	public $language;
	public $image_url;
	public $image_path;
	public $wowhead_zone_maps = 'http://static.wowhead.com/images/maps/enus/normal/';
	
	public function __construct()
	{
		global $armory_image_url;
		
		$this->patterns = new wowhead_patterns();
		$this->language = new wowhead_language();
		$this->images_url = $armory_image_url . 'images/zones/';
		$this->images_path = dirname(__FILE__) . '/../images/zones/';
	}
	
	public function close()
	{
		unset($this->lang, $this->patterns, $this->language);	
	}
	
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;
		$cache = new wowhead_cache();
		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		
		// if the wowhead arg exists then format it into something the script can read
		if (array_key_exists('wowhead', $args))
		{
			$args['pins'] = $this->wowhead_map($args['wowhead']);
			unset($args['wowhead']);
		}
		
		if (!$result = $cache->getZone($name, $this->lang))
		{
			// method depends if the id or name is given
			$result = (is_numeric($name)) ? $this->getZoneByID($name) : $this->getZoneByName($name);
			
			if (!$result)
			{
				// not found
				$cache->close();
				return $this->_notFound($this->language->words['zone'], $name);	
			}
			else
			{
				// transfer the zone map
				if (WHP_TRANSFER_MAP == true)
					$this->transferImage($result['map']);
					
				$cache->saveZone($result);
				$cache->close();
				return $this->toHTML($result, $args);
			}
		}
		else
		{
			// found in cache
			$cache->close();
			return $this->toHTML($result, $args);	
		}
	}
	
	private function toHTML($result, $args = array())
	{
		$html = $this->patterns->pattern('zone');
		$html = str_replace('{link}', $this->_generateLink($result['id'], 'zone'), $html);
		$html = str_replace('{name}', $result['name'], $html);
		$html = str_replace('{id}', $result['id'], $html);
		$html = str_replace('{lang}', $result['lang'], $html);
		if (array_key_exists('pins', $args))
		{
			$html = str_replace('{pins}', $args['pins'], $html);
		}
		return $html;
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
	
	private function getZoneByID($id)
	{
		$data = $this->_read_url($id, 'zone', false);
		if (!$data)
		{
			return false;
		}
		else
		{
			if (!preg_match('#name: \'(.+?)\'};#s', $this->nameLine($data), $match))
			{
				return false;	
			}
			else
			{
				return array(
					'id'			=>	$id,
					'name'			=>	stripslashes($match[1]),
					'search_name'	=>	$id,
					'map'			=>	$id . '.jpg',
					'lang'			=>	$this->lang
				);
			}
		}
	}
	
	private function getZoneByName($name)
	{
		$data = $this->_read_url($name, 'zone', false);
		if (!$data)
		{
			return false;	
		}
		else
		{
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