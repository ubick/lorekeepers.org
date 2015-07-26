<?php

/**
* Wowhead (wowhead.com) Tooltips v3 - Achievement Extension
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

class wowhead_achievement extends wowhead
{
	public $lang = WHP_LANG;
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

	public function parse($name, $args = array())
	{
		if (trim($name) == '')
			return false;

		$cache = new wowhead_cache();
		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);
		if (!$result = $cache->getObject($name, 'achievement', $this->lang))
		{
			// not in cache
			if (is_numeric($name))
			{
				$result = $this->_getAchievementByID($name);
			}
			else
			{
				$result = $this->_getAchievementByName($name);
			}

			if (!$result)
			{
				// not found
				$cache->close();
				return $this->_notfound($this->language->words['achievement'], $name);
			}
			else
			{
				$cache->saveObject($result);
				$cache->close();
				return $this->generateHTML($result, 'achievement');
			}
		}
		else
		{
			$cache->close();
			return $this->generateHTML($result, 'achievement');
		}
	}

	/**
	* Queries Wowhead for Achievement info by ID
	* @acess private
	**/
	private function _getAchievementByID($id)
	{
		if (!is_numeric($id))
			return false;

		$data = $this->_read_url($id, 'achievement', false);

		if ($data == '$WowheadPower.registerAchievement(1337, 25, {});')
		{
			return false;
		}
		else
		{
			if (preg_match('#<b class="q">(.+?)</b>#s', $data, $match))
			{
				return array(
						'name'			=>	stripslashes($match[1]),
						'itemid'		=>	$id,
						'search_name'	=>	$id,
						'type'			=>	'achievement',
						'lang'			=>	$this->lang

				);
			}
			else
			{
				return false;
			}
		}
	}

	/**
	* Queries Wowhead for Achievement by Name
	* @access private
	**/
	private function _getAchievementByName($name)
	{
		if (trim($name) == '')
			return false;

		$data = $this->_read_url($name, 'achievement', false);

		if (preg_match('#Location: /\?achievement=(.+?)\n#s', $data, $match))
		{
			// result returns a redirection header (aka only one result)
			// so we can get the information we need from there
			return array(
					'name'			=>	stripslashes(ucwords(strtolower($name))),
					'search_name'	=>	$name,
					'itemid'		=>	$match[1],
					'type'			=>	'achievement',
					'lang'			=>	$this->lang
			);
		}
		else
		{
			// result returns a search page, now we have to get the possible results

			$the_line = $this->_achievementLine($data);

			if (!$the_line)
				return false;
			if (WOWHEAD_DEBUG) { print $the_line . "<br/>"; }
			while (preg_match('#id:([0-9]{1,10}),name:\'(.+?)\',#s', $the_line, $match))
			{
				if (WOWHEAD_DEBUG) { print_r($match); print '<br/>'; }
				if (strtolower($match[2]) == addslashes(strtolower($name)))
				{
					return array(
						'name'			=>	$match[2],
						'search_name'	=>	$name,
						'itemid'		=>	$match[1],
						'type'			=>	'achievement',
						'lang'			=>	$this->lang
					);
				}
				else
				{
					$the_line = str_replace($match[0], '', $the_line);
				}
			}
		}
	}
}
?>