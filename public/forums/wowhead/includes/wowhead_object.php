<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Object Extension
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
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_object extends wowhead
{
	public $lang;
	public $patterns;
	public $language;
	
	public function __construct()
	{
		$this->patterns = new wowhead_patterns();
		$this->language = new wowhead_language();	
	}
	
	public function close()
	{
		unset($this->lang, $this->patterns, $this->language);	
	}
	
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$this->lang = (array_key_exists('lang', $args)) ? $args['lang'] : WHP_LANG;
		$this->language->loadLanguage($this->lang);
		$cache = new wowhead_cache();
		
		if (!$result = $cache->getObject($name, 'object', $this->lang))
		{
			$result = (is_numeric($name)) ? $this->getObjectByID($name) : $this->getObjectByName($name);
			if (!$result)
			{
				$cache->close();
				return $this->_notFound($this->language->words['object'], $name);	
			}
			else
			{
				$cache->saveObject($result);
				$cache->close();
				return $this->generateHTML($result, 'object');
			}
		}
		else
		{
			$cache->close();
			return $this->generateHTML($result, 'object');	
		}
	}
	
	private function getObjectByName($name)
	{
		$data = $this->_read_url($name, 'object', false);
		if (!preg_match('#id:([0-9]{1,10}),name:\'(.+?)\',#s', $this->getObjectLine($data), $match))
		{
			// something went wrong
			return false;	
		}
		else
		{
			return array(
				'name'			=>	stripslashes($match[2]),
				'itemid'		=>	$match[1],
				'search_name'	=>	$name,
				'type'			=>	'object',
				'lang'			=>	$this->lang
			);
		}
	}
	
	private function getObjectLine($data)
	{
		$lines = explode(chr(10), $data);
		
		foreach ($lines as $line)
		{
			if (strpos($line, "new Listview({template: 'object', id: 'objects',") !== false)
			{
				return $line;
				break;
			}
		}
		
		// in case there's any problems
		return false;
	}
	
	private function getObjectByID($id)
	{
		$data = $this->_read_url($id, 'object', false);
		
		if ($data == '$WowheadPower.registerObject(1337, 0, {});')
		{
			// aka not found
			return false;
		}
		else
		{
			// gets the object's name
			if (preg_match('#<b class="q">(.+?)</b>#s', $data, $match))
			{
				return array(
					'name'			=>	stripslashes($match[1]),
					'itemid'		=>	$id,
					'search_name'	=>	$id,
					'type'			=>	'object',
					'lang'			=>	$this->lang
				);
			}
			else
			{
				return false;
			}
		}
	}
}

?>