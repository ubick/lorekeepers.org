<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Faction Extension
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
include_once(dirname(__FILE__) . '/wowhead_language.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');

class wowhead_faction extends wowhead
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
			
		// set the language for this parse, and then load the language pack
		$this->lang = (array_key_exists('lang', $args)) ? $args['lang'] : WHP_LANG;
		$this->language->loadLanguage($this->lang);
		
		$cache = new wowhead_cache();
		
		if (!$result = $cache->getFaction($name, $this->lang))
		{
			$result = (is_numeric($name)) ? $this->getFactionByID($name) : $this->getFactionByName($name);
			if (!$result)
			{
				$cache->close();
				return $this->_notFound($this->language->words['faction'], $name);
			}
			else
			{
				$cache->saveFaction($result);
				$cache->close();
				return $this->generateHTML($result, 'faction');
			}
		}
		else
		{
			$cache->close();
			return $this->generateHTML($result, 'faction');	
		}
	}
	
	private function getFactionByName($name)
	{
		if (trim($name) == '')
			return false;
			
		$data = $this->_read_url($name, 'faction', false);
		
		if (!preg_match('#{id:([0-9]{1,10}),name:\'(.+?)\',#s', $this->nameLine($data), $match))
		{
			return false;
		}
		else
		{
			// NOTE:  	I know I could just make a call to the get by ID function, but if I do then
			//			it won't be saved in SQL properly and would always query Wowhead, regardless
			//			of what was in SQL.  Believe me, I already tried it...
			
			$result = array(
				'id'			=>	(int)$match[1],
				'name'			=>	stripslashes($match[2]),
				'search_name'	=>	stripslashes($name),
				'lang'			=>	$this->lang
			);
			
			// now we need to query wowhead again to get the tooltip information
			$data = $this->_read_url($result['id'], 'faction', false);
			
			if (strpos($data, "<div id=\"inputbox-error\">This faction doesn't exist.</div>") !== false)
				return false;	// not found
	
			$lines = $this->getIDLines($data);
			
			if (!$lines)
			{
				// faction is incompatible with this script
				$tooltip = str_replace('{name}', $result['name'], $this->language->words['faction_fail']);
				$result['tooltip'] = str_replace(array('{tooltip}', '{name}'), array($tooltip, stripslashes($result['name'])), $this->patterns->pattern('faction_tooltip'));
			}
			else
			{
				// now finish building the result array
				$result['tooltip'] = str_replace(array('{tooltip}', '{name}'), array(stripslashes($lines['tooltip']), stripslashes($result['name'])), $this->patterns->pattern('faction_tooltip'));
			}
			return $result;
		}
	}
	
	private function nameLine($data)
	{
		$lines = explode(chr(10), $data);
		
		foreach ($lines as $line)
		{
			if (strpos($line, "new Listview({template: 'faction', id: 'factions',")	!== false)
			{
				return $line;
				break;	
			}
		}
	}
	
	private function getFactionByID($id)
	{
		if (trim($id) == '' || !is_numeric($id))
			return false;
			
		$data = $this->_read_url($id, 'faction', false);
		
		if (strpos($data, "<div id=\"inputbox-error\">This faction doesn't exist.</div>") !== false)
			return false;	// not found

		$lines = $this->getIDLines($data);
		
		if (!$lines)
			return false;
		
		// first we'll get the name
		if (!preg_match('#name: \'(.+?)\'};#s', $lines['name'], $match))
		{
			return false;
		}
		else
		{
			$result = array(
				'id'			=>	$id,
				'name'			=>	stripslashes($match[1]),
				'search_name'	=>	$id
			);	
		}
		
		// now finish building the result array
		$result['tooltip'] = str_replace(array('{tooltip}', '{name}'), array(stripslashes($lines['tooltip']), stripslashes($result['name'])), $this->patterns->pattern('faction_tooltip'));
		$result['lang'] = $this->lang;
		return $result;
	}
	
	private function getIDLines($data)
	{
		$lines = explode(chr(10), $data);
		
		$larray = array();
		$first = false; $markup = array();
		foreach ($lines as $line)
		{
			if (strpos($line, 'var g_pageInfo = {type') !== false)
				$larray['name'] = $line;
			elseif (preg_match('#Markup.printHtml\("(.+?)",#s', $line, $match))
				$markup[] = $match[1];
		}
		
		if (sizeof($markup) == 0)
			return false;
		
		$larray['tooltip'] = (sizeof($markup) == 2) ? $this->convertBBCode($markup[1]) : $this->convertBBCode($markup[0]);	// we need to remove the anchor tags, but keep HTML formatting
		return (sizeof($larray) == 2) ? $larray : false;
	}
	
	private function convertBBCode($html)
	{
		// first remove the [url][/url] tags
		while (preg_match('#\[url(.+?)\](.+?)\[/url\]#s', $html, $match))
			$html = str_replace($match[0], $match[2], $html);
		
		// convert \n to <br />
		$html = str_replace(array("\n", "\r"), array('<br />', "\n"), $html);
		$html = str_replace('\n', '', $html);
		
		// replace [Pad] with a padding <div>
		$html = str_replace('[Pad]', '<div style="padding-bottom: 10px;" />', $html);
		
		// replace [h3][/h3] with <h3></h3>
		$html = str_replace(array('[h3]', '[/h3]'), array('<h3>', '</h3>'), $html);
		
		// finally replace [b][/b] to <strong></strong>
		$html = str_replace(array('[b]', '[/b]'), array('<strong>', '</strong>'), $html);
		
		return $html;
	}
}
?>