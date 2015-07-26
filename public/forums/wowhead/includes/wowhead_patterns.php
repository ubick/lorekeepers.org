<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Pattern Class
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

class wowhead_patterns
{
	// variable for each pattern
	private $patterns = array();


	public function __construct()
	{
		if (!$opendir = @opendir(dirname(__FILE__) . '/../patterns/'))
		{
			die('Failed to open templates directory.  Please make sure the permissions were set properly.');
		}
		else
		{
			while (false !== ($file = readdir($opendir)))
			{
				if (substr($file, strpos($file, '.') + 1) == 'html')
				{
					$filename = (strpos($file, 'php') !== false) ? str_replace('.php', '', $file) : str_replace('.html', '', $file);
					$this->patterns[$filename] = @file_get_contents(dirname(__FILE__) . '/../patterns/' . $file);
				}
			}
		}

	}

	public function pattern($name)
	{
		return $this->patterns[$name];
	}

	public function close()
	{
		unset($this->patterns);
	}
}
?>