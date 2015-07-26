<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Profile Extension
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

class wowhead_profile extends wowhead
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

	public function parse($name, $args = array())
	{
		global $profile_region, $profile_realm;

		$this->lang = (array_key_exists('lang', $args)) ? $args['lang'] : WHP_LANG;
		$this->language->loadLanguage($this->lang);

		if (trim($name) == '' || !$this->_is_utf8($name))
			return $this->_notFound($this->language->words['profile'], $name);

		// see if they specified a region/realm/
		if (array_key_exists('loc', $args))
		{
			$aLoc = explode(',', $args['loc']);
		}
		$region = (array_key_exists('loc', $args)) ? $aLoc[0] : $profile_region;
		$realm = (array_key_exists('loc', $args)) ? str_replace(" ", "-", $aLoc[1]) : str_replace(" ", "-", $profile_realm);

		return $this->generateHTML(
			array(
				'link'	=>	$this->genProfileLink(strtolower($name), $region, $realm),
				'name'	=>	ucwords($name)
			), 'profile');
	}

	private function genProfileLink($name, $region = '', $realm = '')
	{
		if (trim($name) == '')
			return false;

		if (trim($region) != '' && trim($realm) != '')
		{
			return "http://profiler.wowhead.com/?profile={$region}.{$realm}.{$name}";
		}
		else
		{
			return "http://profiler.wowhead.com/?profile={$name}";
		}
	}
}

?>