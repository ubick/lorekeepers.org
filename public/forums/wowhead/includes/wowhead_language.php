<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Language Extension
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

class wowhead_language extends wowhead
{
	public $words = array();
	public $logs;
	private $langs = array();
	
	public function __construct()
	{
		$lang_dir = dirname(__FILE__) . '/../languages/';
		
		if (!$open = opendir($lang_dir))
			trigger_error('Failed to open ' . $lang_dir . ' for reading.', E_USER_ERROR);
			
		while (false !== ($file = readdir($open)))
		{
			if ($file != 'index.php' && $file != 'lang_test.php' && substr($file, strpos($file, '.') + 1) == 'php')
			{
				$filename = substr($file, 0, strpos($file, '.'));
				require($lang_dir . $file);
				$this->langs[$filename] = $lang_array;
				
			}
		}
		
		closedir($open);
		
		$this->preparePacks();
	}
	
	// encodes the language packs in UTF-8, if they aren't already
	private function preparePacks()
	{
		// loop through each language pack
		foreach ($this->langs as $lang => $pack)
		{
			// loop through each phrase
			foreach ($pack as $key => $phrase)
			{
				if (!$this->_is_utf8($phrase))
				{
					$this->langs[$lang][$key] = utf8_encode($phrase);	
				}
			}
		}
	}
	
	public function loadLanguage($lang = '')
	{
		if (trim($lang) == '')
			$lang = WHP_LANG;

		if (array_key_exists($lang, $this->langs))
			$this->words = $this->langs[$lang];
		else
			$this->words = $this->langs['en'];		// language pack not found, so default to english (en)
	}
}
?>