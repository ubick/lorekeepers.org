<?php

/**
* Wowhead (wowhead.com) Tooltips v3 - Spell Extension
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

class wowhead_spell extends wowhead
{
	public $lang;
	public $language;
	public $patterns;

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
	* Parses information
	* @access public
	**/
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		$rank = (!array_key_exists('rank', $args)) ? '' : $args['rank'];
		$cache = new wowhead_cache();

		if (!$result = $cache->getObject($name, 'spell', $this->lang, $rank))
		{
			$result = (is_numeric($name)) ? $this->_getSpellByID($name) : $this->_getSpellByName($name, $rank);

			if (!$result)
			{
				$cache->close();
				return $this->_notfound($this->language->words['spell'], $name);
			}
			else
			{
				$cache->saveObject($result);
				$cache->close();
				return $this->generateHTML($result, 'spell', '', $rank);
			}
		}
		else
		{
			$cache->close();
			return $this->generateHTML($result, 'spell', '', $rank);
		}
	}

	/**
	* Queries Wowhead for Spell by Name
	* @access private
	**/
	public function _getSpellByName($name, $rank = '')
	{
		if (trim($name) == '')
			return false;

		$query = $this->_findBySearch($name, 'spell', $rank);

		if ($query != false)
		{
			return array(
				'name'			=>	stripslashes($query[2]),
				'search_name'	=>	$name,
				'itemid'		=>	$query[1],
				'rank'			=>	(array_key_exists(3, $query)) ? $query[3] : '',
				'type'			=>	'spell',
				'lang'			=>	$this->lang
			);
		}
		else
		{
			return false;
		}
	}

	/**
	* Queries Wowhead for Spell info by ID
	* @access private
	**/
	public function _getSpellByID($id)
	{
		if (!is_numeric($id))
			return false;

		$data = $this->_read_url($id, 'spell', false);

		if ($data == '$WowheadPower.registerSpell')
		{
			return false;
		}
		else
		{
			switch ($this->lang)
			{
				case 'de':
					$str = 'dede';
					break;
				case 'fr':
					$str = 'frfr';
					break;
				case 'es':
					$str = 'eses';
					break;
				case 'ru':
					$str = 'ruru';
					break;
				case 'en':
				default:
					$str = 'enus';
					break;
			}
			if (preg_match('#name_' . $str . ': \'(.+?)\',#s', $data, $match))
			{
				return array(
					'name'			=>	stripslashes($match[1]),
					'itemid'		=>	$id,
					'search_name'	=>	$id,
					'type'			=>	'spell',
					'rank'			=>	'',
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
