<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Recruit Extension
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
include_once(dirname(__FILE__) . '/wowhead_armory.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_recruit extends wowhead
{	
	public $lang;
	public $patterns;
	public $language;
	private $realm;
	private $region;
	
	public function __construct()
	{
		global $recruit_realm, $recruit_region, $recruit_lang;
		$this->realm = $recruit_realm;
		$this->region = $recruit_region;
		$this->lang = $recruit_lang;
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
		
		if (!defined('WHP_RECRUIT_USED'))
		{
			$armory = new wowhead_armory();
			$args['recruit'] = true;
			define('WHP_RECRUIT_USED', true);
			return $armory->parse($name, $args);
		}
		else
		{
			$this->language->loadLanguage($this->lang);
			return $this->generateError($this->language->words['already_used']);	
		}
	}
}
?>