<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Item Icon Extension
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

class wowhead_itemico extends wowhead
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
		unset($this->lang, $this->language, $this->patterns);	
	}

	/**
	* Parse Item Icons
	* @access public
	**/
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$size = (!array_key_exists('size', $args)) ? 'medium' : $args['size'];

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		$cache = new wowhead_cache();

		if (!$result = $cache->getObject($name, 'itemico', $this->lang, '', $size))
		{
			if (!$result = $this->_getItemIcon($name, $size))
			{
				$cache->close();
				return $this->_notfound($this->language->words['item'], $name);
			}
			else
			{
				$cache->saveObject($result);
				$cache->close();
				return $this->generateHTML($result, 'itemico', $size);
			}
		}
		else
		{
			$cache->close();
			return $this->generateHTML($result, 'itemico', $size);
		}
	}

	/**
	* Queries Wowhead for an Item's Icon
	* @access private
	**/
	private function _getItemIcon($name, $size)
	{
		if (trim($name) == '')
			return false;

		// get XML data
		$data = $this->_read_url($name);

        // PHP 5.x
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
                // woohoo, item found

                return array(
                        'name'			=>	(string)$xml->item->name,
                        'search_name'	=>	$name,
                        'itemid'		=>	(string)$xml->item['id'],
                        'icon'			=>	'http://static.wowhead.com/images/icons/' . $size . '/' . strtolower($xml->item->icon) . '.jpg',
                        'icon_size'		=>	$size,
                        'lang'			=>	$this->lang,
                        'type'			=>	'itemico'
                );
        }
        else
        {
                return false;
        }

        unset($xml);
	}
}
?>