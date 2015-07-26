<?php

/**
* Wowhead (wowhead.com) Tooltips v3 - Itemset Extension
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

class wowhead_itemset extends wowhead
{
	// variables
	public $lang;
	public $patterns;
	public $language;
	private $itemset = array();
	private $itemset_items = array();
	private $setid;

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
	* Parses itemset bbcode
	* @access public
	**/
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		$cache = new wowhead_cache();
		if (!$result = $cache->getItemset($name, $this->lang))
		{
			if (!is_numeric($name))
			{
				$data = $this->_read_url($name, 'itemset', false);
				if (!preg_match('#Location: /\?itemset=([\-0-9]{1,10})#s', $data, $match))
				{
					// didn't find the redirect header, so we'll have to look in the search page
					$summary = $this->summaryLine($data);
					if (!preg_match('#id:([\-0-9]{1,10}),name:#s', $summary, $match))
					{
						$cache->close();
						return $this->_notFound($this->language->words['itemset'], $name);
					}
				}
			}

			// we now have the set id, and can query wowhead for the info we need
			$this->setid = (is_numeric($name)) ? $name : $match[1];
			$data = $this->_read_url($this->setid, 'itemset', false);

			// if they used ID rather than name, then we must get the name
			if (is_numeric($name))
			{
				if (!preg_match('#name: \'(.+?)\'};#s', $this->nameLine($data), $match))
				{
					$cache->close();
					return $this->_notFound($this->language->words['itemset'], $name);	
				}
				else
				{
					$found_name = stripslashes($match[1]);	
				}
			}

			$this->itemset = array(
				'setid'			=>	$this->setid,
				'name'			=>	(is_numeric($name)) ? $found_name : $name,
				'search_name'	=>	$name,
				'lang'			=>	$this->lang
			);

			$summary = $this->summaryLine($data);
			
			while (preg_match('#\[\[([0-9]{1,10})\]\]#s', $summary, $match))
			{
				$data = $this->_read_url($match[1]);

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
					// add the results to our item array
					array_push($this->itemset_items, array(
						'setid'		=>	$this->setid,
						'itemid'	=>	(int)$xml->item['id'],
						'name'		=>	(string)$xml->item->name,
						'quality'	=>	(int)$xml->item->quality['id'],
						'icon'		=>	'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg'
					));
                }
                else
                {
                       return false;
                }

                unset($xml);

				// strip what it found so we don't get an endless loop
				$summary = str_replace($match[0], '', $summary);
			}
			$cache->saveItemset($this->itemset, $this->itemset_items);
			$cache->close();
			return $this->toHTML();
		}
		else
		{
			$this->itemset = $result;
			$this->itemset_items = $cache->getItemsetReagents($this->itemset['setid']);
			$cache->close();
			return $this->toHTML();
		}
	}

	/**
	* Generates HTML
	* @access private
	**/
	private function toHTML()
	{

		// generate item HTML first
		$item_html = ''; $set_html = $this->patterns->pattern('itemset');

		foreach ($this->itemset_items as $item)
		{
			$patt = $this->patterns->pattern('itemset_item');
			$search = array(
				'{link}'	=>	$this->_generateLink($item['itemid'], 'item'),
				'{name}'	=>	stripslashes($item['name']),
				'{qid}'		=>	$item['quality'],
				'{icon}'	=>	$item['icon']
			);
			foreach ($search as $key => $value)
				$patt = str_replace($key, $value, $patt);
			$item_html .= $patt;
		}

		// now generate everything
		$set_html = str_replace('{link}', $this->_generateLink($this->itemset['setid'], 'itemset'), $set_html);
		$set_html = str_replace('{name}', $this->itemset['name'], $set_html);
		$set_html = str_replace('{items}', $item_html, $set_html);

		return $set_html;
	}

	/**
	* Returns the summary line we need for getting itemset items
	* @access private
	**/
	private function summaryLine($data)
	{
		$parts = explode(chr(10), $data);
		foreach ($parts as $line)
		{
			if (strpos($line, "new Summary({id: 'itemset', template: 'itemset',") !== false)
			{
				return $line;
				break;
			}
			elseif (strpos($line, "new Listview({template: 'itemset', id: 'item-sets',") !== false)
			{
				return $line;
				break;
			}
		}
	}
	
	/**
	 * Gets the line which we use to get the name
	 * @access private 
	 **/
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
	}
}
?>