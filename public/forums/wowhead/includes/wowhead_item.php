<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Item Extension
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

class wowhead_item extends wowhead
{
	public $patterns;
	public $lang;
	public $language;
    private $show_icon = false;
	public $type = 'item';

	/**
	* Constructor
	* @access public
	**/
	public function __construct()
	{
		$this->patterns = new wowhead_patterns();
		$this->language = new wowhead_language();
	}
	
	public function close()
	{
		unset($this->lang, $this->language, $this->patterns);	
	}

	/**
	* Parses Items
	* @access public
	**/
	public function parse($name, $args = array())
	{
		global $item_show_icon;

		if (trim($name) == '')
		{
			return false;
		}

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		
		// load the language pack
		$this->language->loadLanguage($this->lang);
		
		$cache = new wowhead_cache();

        if ($item_show_icon == true || array_key_exists('icon', $args))
		{
		    $this->show_icon = true;
		    $this->type = 'item_icon';
		}

		// check if its already in the cache
		if (!$result = $cache->getObject($name, $this->type, $this->lang))
		{
			// not in the cache

			if (!$result = $this->_getItemInfo($name))
			{
				// item not found
				$cache->close();
				return $this->_notfound($this->language->words['item'], $name);
			}
			else
			{
				$cache->saveObject($result);	// save it to cache
				$cache->close();
				if (array_key_exists('gems', $args) || array_key_exists('enchant', $args))
				{
					$enhance = $this->_buildEnhancement($args);
					return $this->generateHTML($result, $this->type, '', '', $enhance);
				}
				else
				{
					return $this->generateHTML($result, $this->type);
				}
			}
		}
		else
		{
			$cache->close();

			if (array_key_exists('gems', $args) || array_key_exists('enchant', $args))
			{
				$enhance = $this->_buildEnhancement($args);
				return $this->generateHTML($result, $this->type, '', '', $enhance);
			}
			else
			{
				return $this->generateHTML($result, $this->type);
			}
		}
	}

	/**
	* Queries Wowhead for Item Info
	* @access private
	**/
	private function _getItemInfo($name)
	{
		if (trim($name) == '')
			return false;

		// gets the XML data from wowhead and remove CDATA tags
		$data = $this->_read_url($name);

		if (trim($data) == '' || empty($data)) { return false; }

		// accounts for SimpleXML not being able to handle 3 parameters if you're using PHP 5.1 or below.
		if (!$this->_allowSimpleXMLOptions())
		{
			$data = $this->_removeCData($data);
			$xml = simplexml_load_string($data, 'SimpleXMLElement');
		}
		else
		{
			$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
		}

		if ($xml->error == '')
		{
			$item = array(
				'name'			=>	(string)$xml->item->name,
				'search_name'	=>	$name,
				'itemid'		=>	(string)$xml->item['id'],
				'quality'		=>	(string)$xml->item->quality['id'],
				'type'			=>	$this->type,
				'lang'			=>	$this->lang
			);

			if ($this->show_icon == true)
			{
				$item['icon'] = 'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg';
			}

			return $item;
		}
		else
		{
			return false;
		}

		unset($xml);
	}
}
?>