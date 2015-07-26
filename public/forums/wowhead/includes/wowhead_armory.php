<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Armory Extension
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

include_once(dirname(__FILE__) . '/wowhead.php');
include_once(dirname(__FILE__) . '/../config.php');
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_armory extends wowhead
{
	private $region;
	private $realm;
	public $patterns;
	public $lang = 'en';	// dummy to prevent errors
	public $language;
	private $icons;
	private $class_icon;
	private $race_icon;
	private $icon_url;
	private $char_cache;
	private $url;
	private $char_url;
	private $char_data = array();		// holds character data after being parsed
	private $stats = array();
	private $images_base_url;
	private $avatars_base_url;
	private $main_spec;
	private $now;
	private $item_level;
	private $type = 'armory';
	private $date_format;
	private $time_format;
	protected $stats_conf = array (
		/* --base stats-- */
		'stamina' => false,
		'strength' => false,
		'intellect' => false,
		'agility' => false,
		'spirit' => false,
		'armor' => false,
		/*   -- spell damage--   */
		'shadow_power' => false,
		'shadow_crit' => false,
		'fire_power' => false,
		'fire_crit' => false,
		'frost_power' => false,
		'frost_crit' => false,
		'arcane_power' => false,
		'arcane_crit' => false,
		'nature_power' => false,
		'nature_crit' => false,
		'holy_power' => false,
		'holy_crit' => false,
		'healing' => false,
		'mana_regen' => false,
		'mana_regen_cast' => false,
		'spell_hit' => false,
		'penetration' => false,
		/*   -- melee damage--   */
		'melee_main_dmg' => false,
		'melee_main_speed' => false,
		'melee_main_dps' => false,
		'melee_off_dmg' => false,
		'melee_off_speed' => false,
		'melee_off_dps' => false,
		'melee_power' => false,
		'melee_hit' => false,
		'melee_crit' => false,
		'melee_expertise' => false,
		/*   -- ranged damage--   */
		'ranged_power' => false,
		'ranged_dmg' => false,
		'ranged_speed' => false,
		'ranged_dps' => false,
		'ranged_crit' => false,
		'ranged_hit' => false,
                /*  --Haste--  */
                'haste_rating' => false,
		/*  --defenses--  */
		'defense' => false,
		'dodge' => false,
		'parry' => false,
		'block' => false,
		'resilience' => false,
		/*  --resistances--  */
		'arcane_resist' => false,
		'fire_resist' => false,
		'frost_resist' => false,
		'shadow_resist' => false,
		'nature_resist' => false,
		'holy_resist' => false,
	);
	
	private $id_to_name = array (
		'unknown',
		'warrior',
		'paladin',
		'hunter',
		'rogue',
		'priest',
		'deathknight',
		'shaman',
		'mage',
		'warlock',
		'(10)',
		'druid',
	);

	private $race_ids = array(
	    'unknown',
	    'human',
	    'orc',
	    'dwarf',
	    'nightelf',
	    'undead',
	    'tauren',
	    'gnome',
	    'troll',
	    '(9)',
	    'bloodelf',
	    'draenei'
	);

	private $gender_ids = array(
	    'male',
	    'female'
	);	
	
	private $ctab;
	private $char;
	private $cinfo;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		// we'll need these later
		global $armory_realm, $armory_region, $armory_icons, $armory_class_icon, $armory_race_icon, $armory_image_url, $armory_char_cache, $armory_item_level, $armory_date_format, $armory_time_format;
		$this->region = $armory_region;
		$this->realm = $armory_realm;
		$this->patterns = new wowhead_patterns;
		$this->icons = $armory_icons;
		$this->class_icon = $armory_class_icon;
		$this->race_icon = $armory_race_icon;
		$this->icon_url = $armory_image_url;
		$this->char_cache = (int)$armory_char_cache;
		$this->item_level = $armory_item_level;
		$this->url = $this->armoryURL();
		$this->images_base_url = $this->url . '_images/icons/';
		$this->avatars_base_url = $this->url . '_images/portraits/';
		$this->date_format = $armory_date_format;
		$this->time_format = $armory_time_format;
		$this->lang = WHP_LANG;
		$this->language = new wowhead_language();
	}
	
	public function close()
	{
		unset($this->lang, $this->language, $this->patterns);	
	}
	
	/**
	* Parse Text
	* @access public
	**/
	public function parse($name, $args = array())
	{

		if (trim($name) == '')
			return false;
		
		$cache = new wowhead_cache();

		// they specified a realm/region
		if (array_key_exists('loc', $args))
		{
			$aLoc = explode(',', $args['loc']);
			$this->region = $aLoc[0];
			$this->realm = $aLoc[1];
		}
		
		// they specified a language
		if (array_key_exists('lang', $args))
		{
			$this->lang = $args['lang'];	
		}
		
		// see if they want icons
		if (array_key_exists('noicons', $args))
		{
			$this->icons = false;
		}

		if (array_key_exists('noclass', $args))
		{
			$this->class_icon = false;
		}
		if (array_key_exists('norace', $args))
		{
			$this->race_icon = false;
		}
			
		if (array_key_exists('gearlist', $args))
		{
			$this->type = 'armory_gearlist';
		}
			
		if (array_key_exists('recruit', $args))
		{
			$this->type = 'armory_recruit';
		}
		
		// load the language pack
		$this->language->loadLanguage($this->lang);	
		$this->char_url = $this->characterURL($name);
		
		if (WOWHEAD_DEBUG == true)
			print $this->char_url;
		
		$this->now = mktime();
		$uniquekey = $cache->generateKey($name, $this->realm, $this->region);
		$result = $cache->getArmory($uniquekey, $this->char_cache);
		if (!$result)
		{
			$xml_data = $this->getXML($this->characterURL($name));
			if (!$xml = @simplexml_load_string($xml_data, 'SimpleXMLElement'))
			{
				// failed to get the xml, most likely blocked by the armory or character not found
				$cache->close();
				return $this->generateError($this->language->words['armory_blocked']);
			}
			
			// make sure the character does exist
			if (array_key_exists('errcode', $xml->characterInfo))
			{
				$cache->close();
				return $this->generateError($this->language->words['char_not_found']);	
			}
			elseif (!$xml->characterInfo->characterTab)
			{
				$cache->close();
				return $this->generateError($this->language->words['char_no_data']);
			};
			
			$this->ctab = $xml->characterInfo->characterTab;
			$this->char = $xml->characterInfo->character;
			$this->cinfo = $xml->characterInfo;
			
			// get character stats
			$this->stats = $this->generateStats();
			
			// get character talents
			$this->char_data['talents'] = $this->generateTalents();
			
			// get professions
			$this->char_data['prof'] = $this->generateProfessions();
			
			// get avatar
			$this->char_data['avatar'] = $this->generateAvatar();
			
			// generate achievements
			$this->char_data['achieve'] = $this->generateAchievements();
			
			// generate average item level
			if ($this->item_level == true)
				$this->char_data['itemlevel'] = $this->generateItemLevel();
			
			// finalize the character and add other randomness
			$this->finalizeChar();
			
			// save to cache
			$cache->saveArmory(array(
				'uniquekey'	=>	$uniquekey,
				'name'		=>	$this->char_data['name'],
				'class'		=>	$this->char_data['class'],
				'genderid'	=>	$this->char_data['genderid'],
				'raceid'	=>	$this->char_data['raceid'],
				'classid'	=>	$this->char_data['classid'],
				'realm'		=>	$this->realm,
				'region'	=>	$this->region,
				'tooltip'	=>	$this->generateTooltip()
			));
			
			unset($xml); $cache->close();
			
			// generate html
			return $this->generateHTML(array(
				'realm'		=>	$this->realm,
				'region'	=>	$this->region,
				'name'		=>	$this->char_data['name'],
				'icons'		=>	$this->getIcons($this->char_data['raceid'], $this->char_data['genderid'], $this->char_data['classid']),
				'link'		=>	$this->characterURL($this->char_data['name']),
				'class'		=>	'armory_tt_class_' . strtolower(str_replace(' ', '', $this->char_data['class'])),
				'image'		=>	$this->icon_url . 'images/wait.gif'
			), $this->type);
		}
		else
		{
			$cache->close();
			return $this->generateHTML(array(
				'realm'		=>	$this->realm,
				'region'	=>	$this->region,
				'name'		=>	$result['name'],
				'icons'		=>	$this->getIcons($result['raceid'], $result['genderid'], $result['classid']),
				'link'		=>	$this->characterURL($result['name']),
				'class'		=>	'armory_tt_class_' . strtolower(str_replace(' ', '', $result['class'])),
				'image'		=>	$this->icon_url . 'images/wait.gif'
			), $this->type);
		}
	}
	
	private function generateTooltip()
	{
		// now we'll actually build the tooltip
		
		// get the template from the patterns class
		$html = $this->patterns->pattern('armory_tooltip');
		
		// now time to replace everything, lol
		$html = str_replace('{avatar}', $this->char_data['avatar'], $html);
		$html = str_replace('{name}', $this->char_data['prefix'] . $this->char_data['name'] . $this->char_data['suffix'], $html);
		$html = str_replace('{guild}', $this->char_data['guild'], $html);
		$html = str_replace('{level}', $this->char_data['level'], $html);
		$html = str_replace('{race}', $this->char_data['race'], $html);
		$html = str_replace('{class}', $this->char_data['class'], $html);
		$html = str_replace('{health}', $this->char_data['health']['value'], $html);
		$html = str_replace('{secondbar_class}', $this->char_data['secondbar']['class'], $html);
		$html = str_replace('{secondbar}', $this->char_data['secondbar']['value'], $html);
		$html = str_replace('{date}', date($this->date_format, $this->now), $html);
		$html = str_replace('{time}', date($this->time_format, $this->now), $html);
		
		// wildcards we had to write functions for
		$html = str_replace('{talents}', $this->generateTalentsHTML(), $html);
		$html = str_replace('{prof}', $this->generateProfessionsHTML(), $html);
		$html = str_replace('{misc}', $this->generateMiscHTML(), $html);
		$html = str_replace('{stats}', $this->generateStatsHTML(), $html);
		return $html;
	}
	
	private function generateMiscHTML()
	{
		$html = '';
		
		// achievements
		$html .= '
		<tr>
			<td class="armory_tt_misc_name">' . $this->language->words['achievements'] . ':</td>
			<td class="armory_tt_misc_value">&nbsp; ' . $this->char_data['achieve']['earned'] . '/' . $this->char_data['achieve']['total'] . '</td>
		</tr>
		<tr>
			<td class="armory_tt_misc_name">' . $this->language->words['achievement_pts'] . ':</td>
			<td class="armory_tt_misc_value">&nbsp; ' . $this->char_data['achieve']['points'] . '/' . $this->char_data['achieve']['totalpoints'] . '</td>
		</tr>
		<tr>
			<td class="armory_tt_misc_name">' . $this->language->words['lifetime_hk'] . ':</td>
			<td class="armory_tt_misc_value">&nbsp; ' . (string)$this->ctab->pvp->lifetimehonorablekills['value'] . '</td>
		</tr>
';
		if ($this->item_level == true)
		{
			$html .= '
		<tr>	
			<td class="armory_tt_misc_name">' . $this->language->words['avg_ilevel'] . ':</td>
			<td class="armory_tt_misc_value">&nbsp; ' . $this->char_data['itemlevel'] . '</td>
		</tr>
	';	
		}
		return $html;
	}
	
	private function generateProfessionsHTML()
	{
		$html = '';
		
		foreach ($this->char_data['prof'] as $p)
		{
			$html .= '
		<tr>
			<td class="armory_tt_profession_name">
				<img src="' . $p['icon_url'] . '">
				' . $p['name'] . '
			</td>
		   	<td class="armory_tt_profession_skill">
				&nbsp; ' . $p['value'] . '/' . $p['max'] . '
		   	</td>
		</tr>		
';
		}
		
		return $html;
	}
	
	private function generateStatsHTML()
	{
		$html = '';
		
		foreach ($this->char_data['stats'] as $stat => $v)
		{
			$html .= '
                 <tr>
                   <td class="armory_tt_stat_' . $v['class'] . '">' . $v['field'] . ':</td>
                   <td class="armory_tt_stat_value">&nbsp; ' . $v['value'] . '</td>
                 </tr>';	
		}
		
		return $html;
	}
	
	private function generateTalentsHTML()
	{
		$html = '';
		
		foreach ($this->char_data['talents'] as $talent)
		{
			$strong = ($talent['active'] == true) ? '<strong>' : '';
			$slash_strong = ($talent['active'] == true) ? '</strong>' : '';
			$html .= '
<nobr>
<img src="' . $talent['icon_url'] . '">
<span class="armory_tt_talent_trees">' . $strong . $talent['tree'][1] . '/' . $talent['tree'][2] . '/' . $talent['tree'][3] . $slash_strong . '</span>
</nobr>';	
		}
		
		return $html;
	}
	
	private function generateItemLevel()
	{
		$level = 0; $items = 0;
		foreach($this->ctab->items->item as $item)
		{
			// we'll use wowhead to get the item level
			$xml_data = $this->getXML('http://www.wowhead.com/?item=' . (string)$item['id'] . '&xml');
			$xml = simplexml_load_string($xml_data, 'SimpleXMLElement');
			if ((string)$xml->item->level != '')
			{
				// add to total item level to get the average (mean) later
				$level += (int)$xml->item->level;
				$items++;
			}
			unset($xml);
		}
		
		if ($items != 0)
			return bcdiv($level, $items, 0);
		else
			return '0';
	}
	
	private function generateAchievements()
	{
		return array(
			'earned'		=>	(string)$this->cinfo->summary->c['earned'],
			'total'			=>	(string)$this->cinfo->summary->c['total'],
			'points'		=>	(string)$this->cinfo->summary->c['points'],
			'totalpoints'	=>	(string)$this->cinfo->summary->c['totalPoints']
		);	
	}
	
	private function finalizeChar()
	{
		// get the required stats for the character's class
		require(dirname(__FILE__) . '/class_conf/' . str_replace(' ', '', strtolower((string)$this->char['class'])) . '.php');
		
		foreach ($this->stats_conf as $stat => $value)
		{
			if ($value)
				$this->char_data['stats'][$stat] = $this->stats[$stat];	
		}
		$this->char_data['health'] = $this->stats['health'];
		$this->char_data['secondbar'] = $this->stats['secondbar'];
		// class specific rage/energy for warriors and rogues
		if ((string)$this->char['class'] == 'warrior')
			$this->char_data['secondbar']['class'] = 'power_rage';
		elseif ((string)$this->char['class'] == 'rogue')
			$this->char_data['secondbar']['class'] = 'power_energy';
			
		// add the guild name
		$this->char_data['guild'] = ((string)$this->char['guildName'] == '') ? '&nbsp;' : '&lt;' . (string)$this->char['guildName'] . '&gt;';
		
		// add prefix and suffix
		$this->char_data['prefix'] = (string)$this->char['prefix'];
		$this->char_data['suffix'] = (string)$this->char['suffix'];
		
		// level
		$this->char_data['level'] = (string)$this->char['level'];
		
		// class
		$this->char_data['class'] = (string)$this->char['class'];
		
		// race
		$this->char_data['race'] = (string)$this->char['race'];
		
		// can't forget the characters name, lol
		$this->char_data['name'] = (string)$this->char['name'];
		
		// gender, race, and class id
		$this->char_data['genderid'] = (string)$this->char['genderId'];
		$this->char_data['raceid'] = (string)$this->char['raceId'];
		$this->char_data['classid'] = (string)$this->char['classId'];
	}
	
	private function enable_stats(array $stats)
	{
		foreach ($stats as $stat) {
			$this->stats_conf[$stat] = true;
		}
	}
	
	private function generateAvatar()
	{
		// determines the avatar based on the character's level
		
		$char = $this->char;
		$avatar = $this->avatars_base_url;	// base url
		
		// add the specific directory based on level
		if ((int)$char['level'] == 80)
		{
			$avatar .= 'wow-80/';	
		} 
		elseif ((int)$char['level'] == 70)
		{
			$avatar .= 'wow-70/';	
		}
		elseif ((int)$char['level'] < 70 && (int)$char['level'] > 59)
		{
			$avatar .= 'wow/';	
		}
		else
		{
			$avatar .= 'wow-default/';
		}
		
		// add the image name
		$avatar .= (string)$char['genderId'] . '-' . (string)$char['raceId'] . '-' . (string)$char['classId'] . '.gif';
		
		return $avatar;
	}
	
	private function generateProfessions()
	{
		$ctab = $this->ctab;
		$prof = array(); $i = 0;
		
		foreach ($ctab->professions->skill as $skill)
		{
			$prof[$i] = array(
				'icon_url'	=>	$this->images_base_url . 'professions/' . (string)$skill['key'] . '-sm.gif',
				'value'		=>	(string)$skill['value'],
				'max'		=>	(string)$skill['max'],
				'name'		=>	(string)$skill['name']
			);
			$i++;
		}
		
		return $prof;
	}
	
	private function generateTalents()
	{
		$ctab = $this->ctab;
		$talents = array(); $i = 0;
		foreach ($ctab->talentSpecs->talentSpec as $spec)
		{
			// determine the main tree
			switch (max((int)$spec['treeOne'], (int)$spec['treeTwo'], (int)$spec['treeThree']))
			{
				case (int)$spec['treeOne']:
					$main_tree = 1;
					break;
				case (int)$spec['treeTwo']:
					$main_tree = 2;
					break;
				case (int)$spec['treeThree']:
					$main_tree = 3;
					break;
				default: break;	
			}
			
			if ((string)$spec['active'] == '1')
			{
				// set this spec to active
				$this->main_spec = $main_tree;	
			}
		
			
			$talents[$i] = array(
				//'main_spec'	=>	$this->talent_trees[strtolower($this->char['class'])][$main_tree - 1],
				'icon_url'	=>	$this->images_base_url . 'class/' . $this->char['classId'] . '/talents/' . $main_tree . '.gif',
				'prim'		=>	(string)$spec['prim'],
				'active'	=>	(int)$spec['active'],
				'tree'		=>	array(
					'main'	=>	$main_tree,
					'1'		=>	(string)$spec['treeOne'],
					'2'		=>	(string)$spec['treeTwo'],
					'3'		=>	(string)$spec['treeThree']
				)
			);
			$i++;
		}
		
		return $talents;
	}
	
	private function generateStats()
	{
		$ctab = $this->ctab;
		$stats = array();
		
		// base stats first
		$stamina = (int)$ctab->baseStats->stamina['effective'] . " (" . (int)$ctab->baseStats->stamina['base'] . " + " . ((int)$ctab->baseStats->stamina['effective'] - (int)$ctab->baseStats->stamina['base']) . ")";
		$intellect = (int)$ctab->baseStats->intellect['effective'] . " (" . (int)$ctab->baseStats->intellect['base'] . " + " . ((int)$ctab->baseStats->intellect['effective'] - (int)$ctab->baseStats->intellect['base']) . ")";
		$strength = (int)$ctab->baseStats->strength['effective'] . " (" . (int)$ctab->baseStats->strength['base'] . " + " . ((int)$ctab->baseStats->strength['effective'] - (int)$ctab->baseStats->strength['base']) . ")";
		$agility = (int)$ctab->baseStats->agility['effective'] . " (" . (int)$ctab->baseStats->agility['base'] . " + " . ((int)$ctab->baseStats->agility['effective'] - (int)$ctab->baseStats->agility['base']) . ")";
		$spirit = (int)$ctab->baseStats->spirit['effective'] . " (" . (int)$ctab->baseStats->spirit['base'] . " + " . ((int)$ctab->baseStats->spirit['effective'] - (int)$ctab->baseStats->spirit['base']) . ")";
		$armor = (int)$ctab->baseStats->armor['effective'] . " (" . (int)$ctab->baseStats->armor['base'] . " + " . ((int)$ctab->baseStats->armor['effective'] - (int)$ctab->baseStats->armor['base']) . ")";
		$this->addtostats($stats, 'stamina', $this->language->words['stamina'], $stamina, 'primary');
		$this->addtostats($stats, 'intellect', $this->language->words['intellect'], $intellect, 'primary');
		$this->addtostats($stats, 'strength', $this->language->words['strength'], $strength, 'primary');
		$this->addtostats($stats, 'agility', $this->language->words['agility'], $agility, 'primary');
		$this->addtostats($stats, 'spirit', $this->language->words['spirit'], $spirit, 'primary');
		$this->addtostats($stats, 'armor', $this->language->words['armor'], $armor, 'primary');
		
		// health and mana, power, or rage
		$this->addtostats($stats, 'health', 'Health', (string)$ctab->characterBars->health['effective'], 'health');
		$this->addtostats($stats, 'secondbar', 'Power', (string)$ctab->characterBars->secondBar['effective'], 'power_mana');
		
		// spell power and crit
		$this->addtostats($stats, 'arcane_power', $this->language->words['arcane_dmg'], (string)$ctab->spell->bonusDamage->arcane['value'], 'arcane_spell');
		$this->addtostats($stats, 'arcane_crit', $this->language->words['arcane_crit'], (string)$ctab->spell->critChance->arcane['percent'], 'arcane_spell');
		$this->addtostats($stats, 'fire_power', $this->language->words['fire_dmg'], (string)$ctab->spell->bonusDamage->fire['value'], 'fire_spell');
		$this->addtostats($stats, 'fire_crit', $this->language->words['fire_crit'], (string)$ctab->spell->critChance->fire['percent'], 'fire_spell');
		$this->addtostats($stats, 'frost_power', $this->language->words['frost_dmg'], (string)$ctab->spell->bonusDamage->frost['value'], 'frost_spell');
		$this->addtostats($stats, 'frost_crit', $this->language->words['frost_crit'], (string)$ctab->spell->critChance->frost['percent'], 'frost_spell');
		$this->addtostats($stats, 'holy_power', $this->language->words['holy_dmg'], (string)$ctab->spell->bonusDamage->holy['value'], 'holy_spell');
		$this->addtostats($stats, 'holy_crit', $this->language->words['holy_crit'], (string)$ctab->spell->critChance->holy['percent'], 'holy_spell');
		$this->addtostats($stats, 'nature_power', $this->language->words['nature_dmg'], (string)$ctab->spell->bonusDamage->nature['value'], 'nature_spell');
		$this->addtostats($stats, 'nature_crit', $this->language->words['nature_crit'], (string)$ctab->spell->critChance->nature['percent'], 'nature_spell');
		$this->addtostats($stats, 'shadow_power', $this->language->words['shadow_dmg'], (string)$ctab->spell->bonusDamage->shadow['value'], 'shadow_spell');
		$this->addtostats($stats, 'shadow_crit', $this->language->words['shadow_crit'], (string)$ctab->spell->critChance->shadow['percent'], 'shadow_spell');
	
		// spell hit, hase, and pen
		$this->addtostats($stats, 'spell_hit', $this->language->words['spell_hit'], (string)$ctab->spell->hitRating['increasedHitPercent'] . '%', 'generic');
		$this->addtostats($stats, 'haste_rating', $this->language->words['haste'], (string)$ctab->spell->hasteRating['hasteRating'] . ' / ' . (string)$ctab->spell->hasteRating['hastePercent'] . '%', 'generic');
		$this->addtostats($stats, 'penetration', $this->language->words['spell_pen'], (string)$ctab->spell->hitRating['penetration'], 'generic');
		
		// main hand
		$this->addtostats($stats, 'melee_main_dmg', $this->language->words['melee_main_dmg'], (string)$ctab->melee->mainHandDamage['max'], 'melee_main_hand');
		$this->addtostats($stats, 'melee_main_speed', $this->language->words['melee_main_speed'], (string)$ctab->melee->mainHandDamage['speed'], 'melee_main_hand');
		$this->addtostats($stats, 'melee_main_dps', $this->language->words['melee_main_dps'], (string)$ctab->melee->mainHandDamage['dps'], 'melee_main_hand');
		
		// off hand
		$this->addtostats($stats, 'melee_off_dmg', $this->language->words['melee_off_dmg'], (string)$ctab->melee->offHandDamage['max'], 'melee_off_hand');
		$this->addtostats($stats, 'melee_off_speed', $this->language->words['melee_off_speed'], (string)$ctab->melee->offHandDamage['speed'], 'melee_off_hand');
		$this->addtostats($stats, 'melee_off_dps', $this->language->words['melee_off_dps'], (string)$ctab->melee->offHandDamage['dps'], 'melee_off_hand');
		
		// melee stats
		$this->addtostats($stats, 'melee_power', $this->language->words['melee_power'], (string)$ctab->melee->power['effective'], 'generic');
		$this->addtostats($stats, 'melee_hit', $this->language->words['melee_hit'], (string)$ctab->melee->hitRating['increasedHitPercent'] . '%', 'generic');
		$this->addtostats($stats, 'melee_crit', $this->language->words['melee_crit'], (string)$ctab->melee->critChance['percent'] . '%', 'generic');
		$this->addtostats($stats, 'melee_expertise', $this->language->words['melee_expertise'], (string)$ctab->melee->expertise['value'], 'generic');
		
		// defensive stats
		$this->addtostats($stats, 'defense', $this->language->words['defense'], (float)$ctab->defenses->defense['value'] + (float)$ctab->defenses->defense['plusDefense'], 'defensive');
		$this->addtostats($stats, 'dodge', $this->language->words['dodge_chance'], (string)$ctab->defenses->dodge['percent'] . '%', 'defensive');
		$this->addtostats($stats, 'block', $this->language->words['block_chance'], (string)$ctab->defenses->block['percent'] . '%', 'defensive');
		$this->addtostats($stats, 'parry', $this->language->words['parry_chance'], (string)$ctab->defenses->parry['percent'] . '%', 'defensive');
		$this->addtostats($stats, 'resilience', $this->language->words['resilience'], (string)$ctab->defenses->resilience['value'], 'defensive');
		
		// healing and associated stats
		$this->addtostats($stats, 'healing', $this->language->words['healing'], (string)$ctab->spell->bonusHealing['value'], 'healing');
		$this->addtostats($stats, 'mana_regen', $this->language->words['mana_regen'], (string)$ctab->spell->manaRegen['notCasting'], 'mana_regen');
		$this->addtostats($stats, 'mana_regen_cast', $this->language->words['mana_regen_cast'], (string)$ctab->spell->manaRegen['casting'], 'mana_regen');
		
		// ranged stats
		$this->addtostats($stats, 'ranged_dmg', $this->language->words['ranged_dmg'], (string)$ctab->ranged->damage['min'] . '-' . (string)$ctab->ranged->damage['max'], 'ranged');
		$this->addtostats($stats, 'ranged_dps', $this->language->words['ranged_dps'], (string)$ctab->ranged->damage['dps'], 'ranged');
		$this->addtostats($stats, 'ranged_crit', $this->language->words['ranged_crit'], (string)$ctab->ranged->critChance['percent'] . '%', 'ranged');
		$this->addtostats($stats, 'ranged_hit', $this->language->words['ranged_hit'], (string)$ctab->ranged->hitRating['increasedHitPercent'] . '%', 'ranged'); 
		$this->addtostats($stats, 'ranged_speed', $this->language->words['ranged_speed'], (string)$ctab->ranged->speed['value'], 'ranged');
		$this->addtostats($stats, 'ranged_power', $this->language->words['ranged_power'], (string)$ctab->ranged->power['effective'], 'ranged'); 
		
		return $stats;
	}
	
	private function addtostats(&$stats, $index, $field, $value, $class)
	{
		$stats[$index] = array(
			'field'	=>	$field,
			'value'	=>	$value,
			'class'	=>	$class
		);
	}
	
	private function getIcons($raceid, $genderid, $classid)
	{
		$icons = '';
		// build the icon html
		if ($this->icons == true)
		{
			if ($this->race_icon)
				$icons .= '<img src="' . $this->icon_url . 'images/race/' . $raceid . '-' . $genderid . '.gif" alt="' . ucwords($this->gender_ids[$genderid]) . ' ' . ucwords($this->race_ids[$raceid]) . '" title="' . ucwords($this->gender_ids[$genderid]) . ' ' . ucwords($this->race_ids[$raceid]) . '" />&nbsp;';

			if ($this->class_icon)
				$icons .= '<img src="' . $this->icon_url . 'images/class/' . $classid . '.gif" title="' . ucwords($this->id_to_name[$classid]) . '" alt="' . ucwords($this->id_to_name[$classid]) . '" />&nbsp;';
		}
		return $icons;
	}
	
	// From phpArmory.class.php
	private function getXML($url, $language = NULL) {
		$useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2";
		if (array_search ('curl', get_loaded_extensions ()) !== false) {
			$ch = curl_init();

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt ($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Accept-language: '.$language));
			curl_setopt ($ch, CURLOPT_HEADER, 0);

			$f = curl_exec($ch);
			curl_close($ch);

			return $f;
		} elseif (ini_get ('allow_url_fopen')) {
			if ($language) {
				$user_agent = $useragent . "\r\nAccept-Language: " . $language;
			} else {
				$user_agent = $useragent;
			}

			$opts = array (
				'http' => array (
					'method' => "GET",
					'header'=> "User-Agent: " . $user_agent
				)
			);

			$context = stream_context_create ($opts);

			$f = '';
			$handle = fopen ($url, 'r', false, $context);
			while (!feof ($handle)) {
				$f .= fgets ($handle);
			}
			fclose ($handle);
			return $f;
		}

		trigger_error ($this->language->words['curl_fail'], E_USER_ERROR);
		return false;
	}
	
	private function characterURL($name)
	{
		return $this->armoryURL() . 'character-sheet.xml?r=' . str_replace(' ', '+', $this->realm) . '&cn=' . $name;
	}

	private function armoryURL()
	{
		$prefix = ($this->region == 'us') ? 'www' : $this->region;
		return "http://{$prefix}.wowarmory.com/";
	}
}
?>
