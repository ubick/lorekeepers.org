<?php

/**
* Wowhead (wowhead.com) Tooltips v3 - Quest Extension
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

class wowhead_quest extends wowhead
{
	public $lang;
	public $patterns;
	public $language;

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
	* Parses quests
	* @access public
	**/
	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		$cache = new wowhead_cache();

		if (!$result = $cache->getObject($name, 'quest', $this->lang))
		{
			// not in cache
			if (is_numeric($name))
			{
				// by id
				$result = $this->_getQuestByID($name);
			}
			else
			{
				// by name
				$result = $this->_getQuestByName($name);
			}

			if (!$result)
			{
				// not found
				$cache->close();
				return $this->_notfound($this->language->words['quest'], $name);
			}
			else
			{
				$cache->saveObject($result);
				$cache->close();
				return $this->generateHTML($result, 'quest');
			}
		}
		else
		{
			// found in cache
			$cache->close();
			return $this->generateHTML($result, 'quest');
		}
	}

	/**
	* Queries Wowhead for Quest info by ID
	* @access private
	**/
	private function _getQuestByID($id)
	{
		if (!is_numeric($id))
			return false;

		$data = $this->_read_url($id, 'quest', false);

		// wowhead doesn't have the info
		if ($data == '$WowheadPower.registerQuest(' . $id . ', {});')
		{
			return false;
		}
		else
		{
			// gets the quest's name
			if (preg_match('#<b class="q">(.+?)</b>#s', $data, $match))
			{
				return array(
					'name'			=>	stripslashes($match[1]),
					'itemid'		=>	$id,
					'search_name'	=>	$id,
					'type'			=>	'quest',
					'lang'			=> $this->lang
				);
			}
			else
			{
				return false;
			}
		}
	}

	/**
	* Queries Wowhead for Quest by Name
	* @access private
	**/
	private function _getQuestByName($name)
	{
		if (trim($name) == '')
			return false;

		$query = $this->_findBySearch($name, 'quest');

		if ($query != false)
		{
			return array(
				'name'			=>	stripslashes($query[2]),
				'search_name'	=>	$name,
				'itemid'		=>	$query[1],
				'type'			=>	'quest',
				'lang'			=> $this->lang
			);
		}
		else
		{
			return false;
		}
	}
}
?>