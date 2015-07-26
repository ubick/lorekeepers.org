<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Gearlist Standalone
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
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../includes/wowhead_language.php');

function generateKey($name, $realm, $region)
{
	$name = strtolower(str_replace(' ', '', $name));
	$realm = strtolower(str_replace(' ', '', $realm));
	$region = strtolower($region);
	return md5($name . $realm . $region);
}

function getXML($url, $language = NULL) {
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

	trigger_error ('Could not fetch URL, neither with cURL, nor fopen', E_USER_ERROR);
	return false;
}

function characterURL($name, $region, $realm)
{
	return armoryURL($region) . 'character-sheet.xml?r=' . str_replace(' ', '+', $realm) . '&cn=' . $name;
}

function armoryURL($region)
{
	$prefix = ($region == 'us') ? 'www' : $region;
	return "http://{$prefix}.wowarmory.com/";
}

$slot_ids = array(
	'ammo',
	'head',
	'neck',
	'shoulder',
	'shirt',
	'chest',
	'belt',
	'legs',
	'feet',
	'wrist',
	'gloves',
	'ring1',
	'ring2',
	'trinket1',
	'trinket2',
	'back',
	'main_hand',
	'off_hand',
	'ranged',
	'tabard'
);

// connect to mysql and select the database
$conn = mysql_connect(WHP_DB_HOST, WHP_DB_USER, WHP_DB_PASS) or die(mysql_error());
mysql_select_db(WHP_DB_NAME) or die(mysql_error());

// get what we need from $_GET global
$name = stripslashes(html_entity_decode($_GET['name'], ENT_QUOTES));
$realm = stripslashes(html_entity_decode($_GET['realm'], ENT_QUOTES));
$region = stripslashes(html_entity_decode($_GET['region'], ENT_QUOTES));
if ($name == '')
{
	print 'No name provided.';
	mysql_close($conn);
	exit;
}

$key = generateKey($name, $realm, $region);
if (trim($key) == '')
{
	print 'Unique key not provided.';
	mysql_close($conn);
	exit;	
}

$query = mysql_query("SELECT list FROM " . WHP_DB_PREFIX. "gearlist WHERE uniquekey='$key' AND cache > UNIX_TIMESTAMP(NOW()) - $armory_char_cache LIMIT 1");

if (mysql_num_rows($query) == 0)
{
	// nothing in the cache, so we need to query
	$xml_data = getXML(characterURL($name, $region, $realm));
	
	if (!$xml = @simplexml_load_string($xml_data, 'SimpleXMLElement'))
	{
		print 'Failed to get XML.  You may be blocked by the armory.';	
	}
	else
	{
		//print_r($xml); exit;
		if (!$xml->characterInfo->characterTab)
		{
			print 'Character not found or some other problem.';
			mysql_close($conn);
			exit;	
		}
		
		$language = new wowhead_language();
		$language->loadLanguage(WHP_LANG);
		
		// got the xml so now let's loop through the items and add them to the cache and build the display
		$out = $pcs = '';
		$wowhead_url = (WHP_LANG == 'en') ? 'http://www.wowhead.com/' : 'http://' . strtolower(WHP_LANG) . '.wowhead.com/';
		
		// build set bonuses
		foreach ($xml->characterInfo->characterTab->items->item as $id)
		{
			$pcs .= (string)$id['id'] . ':';	
		}
		
		foreach ($xml->characterInfo->characterTab->items->item as $item)
		{
			$id = (int)$item['id'];
			$gem1 = (int)$item['gem0Id'];
			$gem2 = (int)$item['gem1Id'];
			$gem3 = (int)$item['gem2Id'];
			$enchant = (int)$item['permanentenchant'];
			$slot = $language->words[$slot_ids[(int)$item['slot'] + 1]];
			$icon = 'http://static.wowhead.com/images/icons/small/' . (string)$item['icon'] . '.jpg';
			
			// trim off the ending colon
			$pcs = (substr($pcs, strlen($pcs) - 1, 1) == ':') ? substr($pcs, 0, strlen($pcs) - 2) : $pcs; 
			
			// query wowhead to get the rest of the info we need
			$item_xml_data = getXML($wowhead_url . '?item=' . $id . '&xml');

			if (!$item_xml = @simplexml_load_string($item_xml_data, 'SimpleXMLElement', LIBXML_NOCDATA))
			{
				echo 'There was a problem.';
				mysql_close($conn);
				exit;	
			}
			$item_name = (string)$item_xml->item->name;
			$quality = (int)$item_xml->item->quality['id'];
			
			$out .= "<div style=\"padding-left: 5px; display: block;\"><div class=\"iconsmall\" style=\"background: url({$icon}) no-repeat scroll 4px 4px; top: 5px;\"><div class=\"tile\"><a href=\"$wowhead_url?item=$id\" rel=\"gems=$gem1:$gem2:$gem3&amp;ench=$enchant&amp;pcs=$pcs\" target=\"_blank\" /></a></div></div><span style=\"height: 20px; display: inline; padding-top: 3px;\"><a class=\"q{$quality}\" href=\"$wowhead_url?item=$id\" rel=\"gems=$gem1:$gem2:$gem3&amp;ench=$enchant&amp;pcs=$pcs\" target=\"_blank\">[$item_name]</a></span> ($slot)</div>\n";
		}

			
		// insert/update mysql
		$dummy_text = "INSERT INTO `" . WHP_DB_PREFIX . "gearlist` (
							`uniquekey`, 
							`cache`,
							`list`
						) VALUES (
							'$key',
							UNIX_TIMESTAMP(NOW()),
							'" . addslashes($out) . "'
						)
						ON DUPLICATE KEY UPDATE
							list='" . addslashes($out) . "',
							cache=UNIX_TIMESTAMP(NOW())";
		$dummy = mysql_query($dummy_text);
		print $out;
	}
}
else
{
	// get results from mysql
	list($list) = mysql_fetch_array($query);
	print stripslashes($list);
}

mysql_close($conn);
?>