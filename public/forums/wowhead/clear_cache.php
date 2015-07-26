<?php
/**
* Wowhead (wowhead.com) Tooltips - Clear Cache Script
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

require('config.php');

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Clear Wowhead Cache"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'You must be authenticated in order to clear the cache.';
    exit;
} else {
	
	if ($_SERVER['PHP_AUTH_USER'] == 'wowhead' && $_SERVER['PHP_AUTH_PW'] == $clear_cache_pass)
	{
		$tables = array(
			'armory',
			'cache',
			'craftable',
			'craftable_reagent',
			'craftable_spell',
			'enchant',
			'enchant_reagent',
			'faction',
			'gearlist',
			'guild',
			'itemset',
			'itemset_reagent',
			'npc',
			'recruit',
			'talent_names',
			'zones'
		);
		
		$db = mysql_connect(WHP_DB_HOST, WHP_DB_USER, WHP_DB_PASS);
		mysql_select_db(WHP_DB_NAME);
		
		foreach ($tables as $value)
		{
			$query = mysql_query("TRUNCATE TABLE " . WHP_DB_PREFIX . $value);
		
			if (!$query)
			{
				die("Failed to clear $value");
			}
		}
		mysql_close($db);
		
		print "All MySQL tables have been successfully cleared.";
	}
	else
	{
		echo 'Invalid username/password.';	
	}
}
?>