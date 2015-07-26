<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Cache Class
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
include_once(dirname(__FILE__) . '/sqlhelper.php');

class wowhead_cache
{
 
	private $sql;
	private $connected = false;

	/**
	* constructor
	* @access public
	**/
	public function __construct($newConnection = false)
	{
		$this->sql = new SqlHelperClass(WHP_DB_HOST, WHP_DB_NAME, WHP_DB_USER, WHP_DB_PASS, $newConnection);
		$this->connected = $this->sql->connected;

		if (!$this->connected)
			return false;
			
		if (!$this->tablesExist())
		{
			// sql tables don't exist, so we must create them
			$this->createTables();	
		}
	}
	
	private function createTables()
	{
		if (!defined('WHP_DB_PREFIX'))
			trigger_error('The SQL table prefix global has not been been defined.', E_USER_ERROR);
	
		$scheme = dirname(__FILE__) . '/../table_scheme.sql';
		
		if (!file_exists($scheme))
			trigger_error('The SQL table scheme (table_scheme.sql) does not exist.', E_USER_ERROR);
		
		$contents = @file_get_contents($scheme);
		$chunks = explode(';', $contents);
		
		foreach ($chunks as $query)
		{
			if (trim($query) != '')
			{
				$query = str_replace('{PREFIX}', WHP_DB_PREFIX, $query);
				$q = $this->sql->query($query);
				
				if (!$q)
				{
					$error = $this->sql->error();
					$error = $error['message'];
					trigger_error($error, E_USER_ERROR);
				}
			}
		}
	}

	/**
	* Checks if SQL tables exist.
	* @access private
	**/
	private function tablesExist()
	{
		if (!defined('WHP_DB_PREFIX'))
			trigger_error('The SQL table prefix global is not defined.', E_USER_ERROR);
	
		$query = $this->sql->query("SHOW TABLES LIKE '" . WHP_DB_PREFIX . "cache'");
		return ($this->sql->num_rows($query) > 0) ? true : false;
	}

	/**
	* Destructor
	* @access public
	**/
	public function close()
	{
		$this->connected = false;
		$this->sql->close();
		unset($this->sql);
	}

	public function saveCraftable($craft, $craft_spell, $craft_reagents = array())
	{
		if (!$this->connected || !is_array($craft) || !is_array($craft_spell))
			return false;

		// save the main craftable entry
		$query_text = "INSERT INTO " . WHP_DB_PREFIX . "craftable VALUES ('" . $craft['itemid'] . "', '" . addslashes($craft['name']) . "', '" . addslashes($craft['search_name']) . "', " . $craft['quality'] . ", '" . $craft['lang'] . "', '" . $craft['icon'] . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			echo 'Failed to add ' . $craft['name'] . ' to the cache. ' . $error['message'] . '<br/><br/>' . $query_text;
			return false;
		}


		// now save the spell used to create it
		$query_text = "INSERT INTO " . WHP_DB_PREFIX . "craftable_spell VALUES (" . $craft_spell['reagentof'] . ", " . $craft_spell['spellid'] . ", '" . addslashes($craft_spell['name']) . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			echo 'Failed to add ' . $craft['name'] . ' to the cache. ' . $error['message'] . '<br/><br/>' . $query_text;
			return false;
		}

		if (sizeof($craft_reagents) > 0)
		{
			// now save the reagents
			foreach ($craft_reagents as $reagent)
			{
				$itemid = $reagent['itemid'];
				$reagentof = $reagent['reagentof'];
				$name = addslashes($reagent['name']);
				$quantity = $reagent['quantity'];
				$quality = $reagent['quality'];
				$icon = $reagent['icon'];

				$query_text = "INSERT INTO " . WHP_DB_PREFIX . "craftable_reagent VALUES ($itemid, $reagentof, '$name', $quantity, $quality, '$icon')";
				$result = $this->sql->query($query_text);
				if (!$result)
				{
					$error = $this->sql->error();
					echo 'Failed to add ' . $craft['name'] . ' to the cache. ' . $error['message'] . '<br/><br/>' . $query_text;
					return false;
					break;
				}
			}
		}
	}
	
	public function saveEnchant($info, $reagents)
	{
		if (sizeof($info) == 0 || sizeof($reagents) == 0 || !$this->connected)
			return false;
			
		$query_text = "INSERT INTO `" . WHP_DB_PREFIX . "enchant` VALUES (" . $info['id'] . ", '" . addslashes($info['name']) . "', '" . addslashes($info['search_name']) . "', '" . $info['lang'] . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache.  ' . $error . '<br /><br />' . $query_text;
			return false;
		}
		else
		{
			// now save the reagents
			foreach ($reagents as $reagent)
			{
				$query_text = "INSERT INTO `" . WHP_DB_PREFIX . "enchant_reagent` VALUES (" . $reagent['id'] . ", " . $info['id'] . ", '" . addslashes($reagent['name']) . "', " . $reagent['quantity'] . ", " . $reagent['quality'] . ", '" . addslashes($reagent['icon']) . "', '" . $reagent['lang'] . "')";
				$result = $this->sql->query($query_text);
				if (!$result)
				{
					$error = $this->sql->error();
					$error = $error['message'];
					echo 'Failed to add ' . $reagent['name'] . ' to the reagent cache.  ' . $error . '<br /><br />' . $query_text;
					return false;
					break;	
				}
			}
		}
	}

	public function saveGuild($info)
	{
		if (sizeof($info) == 0 || !$this->connected)
			return false;

		$query_text = "INSERT INTO `". WHP_DB_PREFIX . "guild` (
							`uniquekey`,
							`name`,
							`realm`,
							`region`,
							`tooltip`,
							`cache`
						)
						VALUES (
							'" . $info['uniquekey'] . "',
							'" . $info['name'] . "',
							'" . addslashes($info['realm']) . "',
							'" . $info['region'] . "',
							'" . addslashes($info['tooltip']) . "',
							UNIX_TIMESTAMP(NOW())
						)
						ON DUPLICATE KEY UPDATE
							tooltip='" . addslashes($info['tooltip']) . "',
							cache=UNIX_TIMESTAMP(NOW())";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
			return false;
		}
	}

	public function saveArmory($info)
	{
		if (sizeof($info) == 0 || !$this->connected)
			return false;

		// unix timestamp for our cache

		$query_text = "INSERT INTO `" . WHP_DB_PREFIX . "armory` (
							`uniquekey`,
							`name`,
							`class`,
							`raceid`,
							`classid`,
							`genderid`,
							`realm`,
							`region`,
							`tooltip`,
							`cache`
						)
						VALUES (
							'" . $info['uniquekey'] . "',
							'" . $info['name'] . "',
							'" . $info['class'] . "',
							" . $info['raceid'] . ",
							" . $info['classid'] . ",
							" . $info['genderid'] . ",
							'" . addslashes($info['realm']) . "',
							'" . $info['region'] . "',
							'" . addslashes($info['tooltip']) . "',
							UNIX_TIMESTAMP(NOW())
						)
						ON DUPLICATE KEY UPDATE
							tooltip='" . addslashes($info['tooltip']) . "',
							cache=UNIX_TIMESTAMP(NOW())";
		$result = $this->sql->query($query_text);

		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
			return false;
		}
	}

	public function saveNPC($info)
	{
		if (sizeof($info) == 0 || !$this->connected)
			return false;

		$query_text = "INSERT INTO " . WHP_DB_PREFIX . "npc VALUES (" . (int)$info['npcid'] . ", '" . addslashes($info['name']) . "', '" . addslashes($info['search_name']) . "', '" . $info['lang'] . "')";

		$result = $this->sql->query($query_text);

		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
			return false;
		}
	}
	
	public function saveZone($info)
	{
		if (sizeof($info) == 0 || !$this->connected)
			return false;
			
		$query_text = "INSERT INTO `" . WHP_DB_PREFIX . "zones` VALUES (" . (int)$info['id'] . ", '" . addslashes($info['name']) . "', '" . addslashes($info['search_name']) . "', '" . addslashes($info['map']) . "', '" . $info['lang'] . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache.  ' . $error . '<br /><br />' . $query_text;
			return false;	
		}
	}
	
	public function saveFaction($info)
	{
		if (sizeof($info) == 0 || !$this->connected)
			return false;
			
		$query_text = "INSERT INTO `" . WHP_DB_PREFIX . "faction` (`id`, `name`, `search_name`, `tooltip`, `lang`) VALUES (" . (int)$info['id'] . ", '" . addslashes($info['name']) . "', '" . addslashes($info['search_name']) . "', '" . addslashes($info['tooltip']) . "', '" . $info['lang'] . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache.  ' . $error . '<br /><br />' . $query_text;
			return false;	
		}
	}
	
	public function saveFactionRewards($rewards, $factionid, $lang)
	{
		if (trim($rewards) == '' || !$this->connected)
			return false;
		
		$query_text = "UPDATE `" . WHP_DB_PREFIX . "faction` SET rewards='" . addslashes($rewards) . "' WHERE (id=" . (int)$factionid . " AND lang='" . $lang . "')";
		$result = $this->sql->query($query_text);
		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add faction rewards to the cache.  ' . $error;
			return false;	
		}
	}

	/**
	* Saves itemset
	* @access public
	**/
	public function saveItemset($itemset, $items)
	{
		if (!$this->connected || !is_array($itemset) || !is_array($items))
			return false;

		$setid = $itemset['setid'];
		$name = $itemset['name'];
		$search_name = $itemset['search_name'];
		$lang = $itemset['lang'];

		// save the itemset first, then we'll handle each item
		$query_text = "INSERT INTO " . WHP_DB_PREFIX . "itemset VALUES ($setid, '" . addslashes($name) . "', '" . addslashes($search_name) . "', '$lang')";

		$result = $this->sql->query($query_text);

		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $itemset['name'] . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
			return false;
		}
		else
		{
			// success, now save the items

			// check to make sure the reagents aren't already in the database
			$check = $this->sql->query("SELECT itemid FROM " . WHP_DB_PREFIX . "itemset_reagent WHERE setid='$setid' AND name='" . addslashes($name) . "' LIMIT 1");

			if ($this->sql->num_rows($this->sql->query_id) == 0)
			{
				// not yet in the cache
				foreach ($items as $item)
				{
					$name = $item['name'];
					$itemid = $item['itemid'];
					$quality = $item['quality'];
					$icon = $item['icon'];
					$query_text = "INSERT INTO " . WHP_DB_PREFIX . "itemset_reagent VALUES ($setid, $itemid, '" . addslashes($name) . "', $quality, '" . addslashes($icon) . "')";
					$result = $this->sql->query($query_text);

					if (!$result)
					{
						$error = $this->sql->error();
						$error = $error['message'];
						echo 'Failed to add ' . $name . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
						return false;
						break;
					}
				}
			}
		}
	}

	// generates unique key based on name, realm, and region
	public function generateKey($name, $realm, $region)
	{
		$name = strtolower(str_replace(' ', '', $name));
		$realm = strtolower(str_replace(' ', '', $realm));
		$region = strtolower($region);
		return md5($name . $realm . $region);
	}

	public function getArmory($uniquekey, $max_age)
	{
		if ($this->connected == false)
			return false;

		$query_text = 'SELECT
							name,
							class,
							raceid,
							classid,
							genderid,
							tooltip,
							cache
						FROM
							' . WHP_DB_PREFIX . 'armory
						WHERE
							uniquekey=\'' . $uniquekey . '\'
							AND cache > UNIX_TIMESTAMP(NOW()) - ' . $max_age . '
						LIMIT 1';

		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	public function getGuild($uniquekey, $max_age)
	{
		if ($this->connected == false)
			return false;

		$query_text = 'SELECT
							tooltip
						FROM
							' . WHP_DB_PREFIX . 'guild
						WHERE
							uniquekey=\'' . $uniquekey . '\'
							AND cache > UNIX_TIMESTAMP(NOW()) - ' . $max_age . '
						LIMIT 1';

		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}
	
	public function getFactionRewards($id, $lang)
	{
		if (trim($id) == '' || trim($lang) == '' || !$this->connected)
			return false;
			
		// build the sql query
		$query_text = 'SELECT	`rewards`
						FROM	`' . WHP_DB_PREFIX . 'faction`
						WHERE (id=' . (int)$id . ' AND lang=\'' . $lang . '\')
						LIMIT 1';
		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;	
		}
		else
		{
			$result = $this->sql->fetch_record($this->sql->query_id);
			if (trim($result['rewards']) == '')
			{
				return false;
			}
			else
			{
				return $result;
			}
		}
	}
	
	public function getFaction($name, $lang, $external = false)
	{
		if (trim($name) == '' || !$this->connected)
			return false;
			
		// the query depends on what script is requesting the data
		if (!$external)
		{
			$query_text = 'SELECT
								`id`,
								`name`,
								`tooltip`,
								`lang`
							FROM
								`' . WHP_DB_PREFIX . 'faction`
							WHERE
								(
									name LIKE \'' . addslashes($name) . '\'
										OR
									search_name LIKE \'' . addslashes($name) . '\'
								)
								AND lang=\'' . $lang . '\'
							LIMIT 1';
		}
		else
		{
			$query_text = 'SELECT
								`tooltip`
							FROM
								`' . WHP_DB_PREFIX . 'faction`
							WHERE
								id=' . $name . '
							AND	
								lang=\'' . $lang . '\'
							LIMIT 1';
		}
		$this->sql->query($query_text);
		
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}
	
	public function getZone($name, $lang, $external = false)
	{
		if ($this->connected == false)
			return false;
		if (!$external)
		{
			$query_text = 'SELECT
								`id`,
								`name`,
								`map`,
								`lang`
							FROM
								`' . WHP_DB_PREFIX . 'zones`
							WHERE
								(
									search_name LIKE \'' . addslashes($name) . '\'
										OR
									name LIKE \'' . addslashes($name) . '\'
								)
								AND lang=\'' . $lang . '\'
							LIMIT 1';
		}
		else
		{
			$query_text = 'SELECT
								`id`,
								`name`,
								`map`,
								`lang`
							FROM
								`' . WHP_DB_PREFIX . 'zones`
							WHERE
								id=' . $name . '
									AND
								lang=\'' . $lang . '\'
							LIMIT 1';	
		}
		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	public function getNPC($name, $lang)
	{
		if ($this->connected == false)
			return false;

		if (trim($lang) == '')
			$lang = WHP_LANG;

		$query_text = 'SELECT
							npcid,
							name
						FROM
							' . WHP_DB_PREFIX . 'npc
						WHERE
							(
								search_name LIKE \'' . addslashes($name) . '\'
									OR
								name LIKE \'' . addslashes($name) . '\'
									OR
								npcid LIKE \'' . addslashes($name) . '\'
							)
							AND lang=\'' . $lang . '\'
		';
		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	/**
	* Gets itemset
	* @access public
	**/
	public function getItemset($name, $lang)
	{
		if ($this->connected == false)
			return false;

		if (trim($lang) == '')
			$lang = WHP_LANG;

		$query_text = 'SELECT
							setid,
							name
						FROM
							' . WHP_DB_PREFIX . 'itemset
						WHERE
							(
								search_name LIKE \'' . addslashes($name) . '\'
									OR
								setid LIKE \'' . addslashes($name) . '\'
									OR
								name LIKE \'' . addslashes($name) . '\'
							)
							AND lang=\'' . $lang . '\'';
		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			// not found
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	/**
	* Gets craftable
	* @access public
	**/
	public function getCraftable($name, $lang)
	{
		if ($this->connected == false)
			return false;

		if (trim($lang) == '')
			$lang = WHP_LANG;

		$query_text = 'SELECT
							itemid,
							name,
							quality,
							icon
						FROM
							' . WHP_DB_PREFIX . 'craftable
						WHERE
							(
								search_name LIKE \'' . addslashes($name) . '\'
									OR
								itemid LIKE \'' . $name . '\'
									OR
								name LIKE \'' . addslashes($name) . '\'
							)
							AND lang=\'' . $lang . '\'';
		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	/**
	* Gets craftable spell
	* @access public
	**/
	public function getCraftableSpell($id)
	{
		if (!$this->connected || trim($id) == '')
			return false;

		$this->sql->query("SELECT spellid, name FROM " . WHP_DB_PREFIX . "craftable_spell WHERE reagentof='$id'");
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}
	
	public function getEnchant($name, $lang)
	{
		if (trim($name) == '' || !$this->connected)
			return false;
		$name = addslashes($name);
		if (!is_numeric($name))
			$query_text = "SELECT id, name FROM `" . WHP_DB_PREFIX . "enchant` WHERE (name LIKE '{$name}' OR search_name LIKE '{$name}') AND lang='{$lang}' LIMIT 1";
		else
			$query_text = "SELECT id, name FROM `" . WHP_DB_PREFIX . "enchant` WHERE id={$name} AND lang='{$lang}' LIMIT 1";
		$this->sql->query($query_text);
		return ($this->sql->num_rows($this->sql->query_id) == 0) ? false : $this->sql->fetch_record($this->sql->query_id);
	}
	
	public function getEnchantReagents($id, $lang)
	{
		if (trim($id) == '' || !$this->connected)
			return false;
		$this->sql->query("SELECT id, name, quantity, quality, icon FROM `" . WHP_DB_PREFIX . "enchant_reagent` WHERE reagentof={$id} AND lang='{$lang}' ORDER BY name ASC");
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;	
		}
		else
		{
			$result = array();
			while ($temp = $this->sql->fetch_record($this->sql->query_id))
				$result[] = $temp;
			return $result;
		}
	}

	/**
	* Gets craftable reagents
	* @access public
	**/
	public function getCraftableReagents($id)
	{
		if (!$this->connected || trim($id) == '')
			return false;

		$result = array();

		$this->sql->query("SELECT itemid, name, quantity, quality, icon FROM " . WHP_DB_PREFIX . "craftable_reagent WHERE reagentof='$id' ORDER BY name ASC");
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			while ($temp = $this->sql->fetch_record($this->sql->query_id))
				array_push($result, $temp);

			$this->sql->free_result($this->sql->query_id);
			return $result;
		}
	}

	/**
	* Gets itemset components
	* @access public
	**/
	public function getItemsetReagents($id)
	{
		if (!$this->connected)
			return false;

		$result = array();

		$query_text = 'SELECT
							itemid,
							name,
							quality,
							icon
						FROM
							' . WHP_DB_PREFIX . 'itemset_reagent
						WHERE
							setid=\'' . $id . '\'
						ORDER BY name ASC';

		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			while ($temp = $this->sql->fetch_record($this->sql->query_id))
			{
				array_push($result, $temp);
			}

			$this->sql->free_result($this->sql->query_id);
			return $result;
		}
	}

	/**
	* Gets object from MySQL
	* @access public
	**/
	public function getObject($name, $type = 'item', $lang = '', $rank = '', $size = '')
	{
		if ($this->connected == false)
			return false;

		if (trim($lang) == '')
			$lang = WHP_LANG;

		// build our query to mysql
		$query_text = 'SELECT
							itemid,
							name,
							search_name,
							quality,
							rank,
							type,
							lang,
							icon,
							icon_size
						FROM
							' . WHP_DB_PREFIX . 'cache
						WHERE
							(
								search_name LIKE \'' . addslashes($name) . '\'
									OR
								itemid LIKE \'' . addslashes($name) . '\'
									OR
								name LIKE \'' . addslashes($name) . '\'
							)
							AND type=\'' . $type . '\'
							AND lang=\'' . $lang . '\'
						';

		if (trim($rank) != '') { $query_text .= ' AND rank=\'' . $rank . '\''; }
		if (trim($size) != '') { $query_text .= ' AND icon_size=\'' . $size . '\''; }

		$this->sql->query($query_text);
		if ($this->sql->num_rows($this->sql->query_id) == 0)
		{
			// not found in cache, return false
			$this->sql->free_result($this->sql->query_id);
			return false;
		}
		else
		{
			return $this->sql->fetch_record($this->sql->query_id);
		}
	}

	/**
	* Saves an object to MySQL
	* @access public
	**/
	public function saveObject($info)
	{
		if (!is_array($info) || sizeof($info) == 0 || $this->connected == false)
			return false;

		$quality = (array_key_exists('quality', $info)) ? $info['quality'] : 'NULL';
		$rank = (array_key_exists('rank', $info) && $info['rank'] != '') ? $info['rank'] : 'NULL';
		$icon = (array_key_exists('icon', $info)) ? $info['icon'] : 'NULL';
		$icon_size = (array_key_exists('icon_size', $info)) ? $info['icon_size'] : 'NULL';

		$query_text = "INSERT into `" . WHP_DB_PREFIX . "cache` (
							`id`,
							`itemid`,
							`name`,
							`search_name`,
							`quality`,
							`rank`,
							`type`,
							`lang`,
							`icon`,
							`icon_size`
						)
						VALUES (
							NULL,
							" . $info['itemid'] . ",
							'" . addslashes($info['name']) . "',
							'" . addslashes($info['search_name']) . "',
							$quality,
							$rank,
							'" . $info['type'] . "',
							'" . $info['lang'] . "',
							'$icon',
							'$icon_size'
						)";
		if (WOWHEAD_DEBUG)
		{
			print_r($info);
		}
		$result = $this->sql->query($query_text);

		if (!$result)
		{
			$error = $this->sql->error();
			$error = $error['message'];
			echo 'Failed to add ' . $info['name'] . ' to the cache. ' . $error . '<br/><br/>' . $query_text;
			return false;
		}
	}
}
?>
