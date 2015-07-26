<?php
/**
* Wowhead Tooltips - Enchant Module
* By: Adam "crackpot" Koch (support@wowhead-tooltips.com)
**/

/**
    Copyright (C) 2010  Adam Koch (email : support@wowhead-tooltips.com)

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
include_once(dirname(__FILE__) . '/wowhead.php');
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_enchant extends wowhead
{
	public $lang;
	public $patterns;
	public $language;
	private $reagents = array();
	
	public function __construct()
	{
		$this->patterns = new wowhead_patterns();
		$this->language = new wowhead_language();
	}
	
	public function close()
	{
		unset($this->lang, $this->patterns, $this->language, $this->config);	
	}
	
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;
		
		// set up some preliminary stuff
		$this->lang = (array_key_exists('lang', $args)) ? $args['lang'] : WHP_LANG;
		$cache = new wowhead_cache();
		$this->language->loadLanguage($this->lang);
		
		if (!$result = $cache->getEnchant($name, $this->lang))
		{
			$result = (is_numeric($name)) ? $this->getEnchantByID($name) : $this->getEnchantByName($name);
			
			if (!$result || sizeof($this->reagents) == 0)
			{
				$cache->close();
				return $this->_notFound($this->language->words['enchant'], $name);	
			}
			else
			{
				$cache->saveEnchant($result, $this->reagents);
				$cache->close();
				return $this->toHTML($result);	
			}
		}
		else
		{
			$this->reagents = $cache->getEnchantReagents($result['id'], $this->lang);
			$cache->close();
			return $this->toHTML($result);	
		}
	}
	
	private function getEnchantByID($id)
	{
		if (!is_numeric($id))
			return false;
			
		$data = $this->_read_url($id, 'enchant', false);
		// failed to get data, or spell not found
		if (!$data || $data == '$WowheadPower.registerSpell')
			return false;
			
		// next we need to get the string so we can extract the name
		switch ($this->lang)
		{
			case 'de':	$str = 'dede'; break;	// german
			case 'fr':	$str = 'frfr'; break;	// french
			case 'en':	$str = 'enus'; break;	// english
			case 'ru':	$str = 'ruru'; break;	// russian
			case 'es':	$str = 'eses'; break;	// spanish
			default: break;	
		}
		
		if (!preg_match('#name_' . $str . ': \'(.+?)\',#s', $data, $match))
			return false;	// failed to pull the name
		else
		{
			$result = array(
				'id'			=>	(int)$id,
				'name'			=>	$match[1],
				'search_name'	=>	$id,
				'lang'			=>	$this->lang
			);

			// now pull the reagents
			while (preg_match('#<a href="/\?item=([0-9]{1,10})">(.+?)</a>(&nbsp;\([0-9]{1,2}\))?#s', $data, $match))
			{
				// extract each reagent
				$iData = $this->_read_url($match[1], 'item');
				
				if (!$iData)
					return false;
					
				if (!$xml = simplexml_load_string($iData, 'SimpleXMLElement', LIBXML_NOCDATA))
					return false;
					
				$match[3] = (isset($match[3])) ? str_replace('&nbsp;(', '', str_replace(')', '', $match[3])) : '';
					
				$this->reagents[] = array(
					'id'		=>	(int)$xml->item['id'],
                    'name'		=>	(string)$xml->item->name,
                    'icon'		=>	'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg',
                    'lang'		=>	$this->lang,
					'quality'	=>	(int)$xml->item->quality['id'],
					'quantity'	=>	(trim($match[3]) != '') ? (int)$match[3] : 1,
					'reagentof'	=>	(int)$result['id']
                );
				unset($xml);
				
				$data = str_replace($match[0], '', $data);
			}
			return $result;
		}
	}
	
	private function getEnchantByName($name)
	{
		$data = $this->_read_url($name, 'enchant', false);

		if (!$data)
			return false;

		if (!preg_match("#\{id:([0-9]{1,10}),name:'[0-9@]{1}(.+?)',level:(.+?),school:(.+?),reagents:\[(.+?)\],skill:(.+?),cat:(.+?),source:(.+?),learnedat:(.+?),colors:\[(.+?)\]\}#s", $this->enchantLine($data), $match))
		{
			return false;	
		}
		else
		{
			// build result array
			$result = array(
				'id'			=>	$match[1],
				'name'			=>	$match[2],
				'search_name'	=>	$name,
				'lang'			=>	$this->lang
			);
			
			// now extract the reagents
			while (preg_match('#\[([0-9]{1,10}),([0-9]{1,2})\]#s', $match[5], $rMatch))
			{
				// loop through and extract each reagent, then query wowhead for the info we need
				$iData = $this->_read_url($rMatch[1], 'item');
				
				if (!$iData)
					return false;	// fail
					
				if (!$xml = @simplexml_load_string($iData, 'SimpleXMLElement', LIBXML_NOCDATA))
					return false;
				
				$this->reagents[] = array(
					'id'		=>	(int)$xml->item['id'],
                    'name'		=>	(string)$xml->item->name,
                    'icon'		=>	'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg',
                    'lang'		=>	$this->lang,
					'quality'	=>	(int)$xml->item->quality['id'],
					'quantity'	=>	(int)$rMatch[2],
					'reagentof'	=>	(int)$result['id']
                );
				unset($xml);
				$match[5] = str_replace($rMatch[0], '', $match[5]);
			}
			return $result;
		}
	}
	
	private function enchantLine($data)
	{
		$parts = explode(chr(10), $data);
		foreach ($parts as $line)
		{
			if (strpos($line, "new Listview({template: 'spell', id: 'professions',") !== false)
			{
				return $line;
				break;	
			}
		}
	}
	
	private function toHTML($enchant)
	{
		$reagent_html = $html = '';
		// first build the reagents
		foreach ($this->reagents as $reagent)
		{
			$temp = $this->patterns->pattern('enchant_mats');
			$temp = str_replace('{link}', $this->_generateLink($reagent['id'], 'item'), $temp);
			$temp = str_replace('{icon}', stripslashes($reagent['icon']), $temp);
			$temp = str_replace('{quality}', $reagent['quality'], $temp);
			$temp = str_replace('{count}', $reagent['quantity'], $temp);
			$temp = str_replace('{name}', $reagent['name'], $temp);
			$reagent_html .= $temp;
		}
		
		// now build the main html
		$html = $this->patterns->pattern('enchant');
		$html = str_replace('{link}', $this->_generateLink($enchant['id'], 'spell'), $html);
		$html = str_replace('{name}', stripslashes($enchant['name']), $html);
		$html = str_replace('{mats}', $reagent_html, $html);
		
		return $html;
	}
}
?>
