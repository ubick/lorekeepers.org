<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Faction Parser
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
include_once(dirname(__FILE__) . '/../includes/wowhead_cache.php');
include_once(dirname(__FILE__) . '/../includes/wowhead_language.php');

function readURL($url, $headers = false) {
	if (array_search ('curl', get_loaded_extensions ()) !== false) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_HEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$html_data = curl_exec($curl);

		curl_close($curl);
	}
	elseif (ini_get('allow_url_fopen') == 1)
	{
		$html_data = @file_get_contents($url);
	}
	else
	{
        // Thanks to Aki Uusitalo
		$url_array = parse_url($url);

		$fp = fsockopen($url_array['host'], 80, $errno, $errstr, 5);

		if (!$fp)
        {
			return false;
		}
        else
        {
			$out = "GET " . $url_array['path'] . "?" . $url_array['query'] ." HTTP/1.0\r\n";
			$out .= "Host: " . $url_array['host'] . " \r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($fp, $out);

			$html_data = '';
			// Read the raw data from the socket in 1kb chunks
			// Hopefully, it's just HTML.

			while (!feof($fp))
            {
				$html_data .= fgets($fp, 1024);
			}
			fclose($fp);
			
		}
    }
	
	//if ($headers == true)
	//    $html_data = stripHeaders($html_data);

	return $html_data;
}

function stripHeaders($data)
{
	// split the string
	$chunks = explode(chr(10), $data);

	// return the last index in the array, aka our xml
	return $chunks[sizeof($chunks) - 1];
}

function getDomain($lang)
{
	return ($lang == 'en') ? 'http://www.wowhead.com/' : 'http://' . $lang . '.wowhead.com/';
}

function getRewardLine($data)
{
	$lines = explode(chr(10), $data);
	
	foreach ($lines as $line)
	{
		if (strpos($line, "new Listview({template: 'item', id: 'items',") !== false)
		{
			return $line;
			break;
		}
	}
	
	return false;
}

function rewardsFound($items)
{
	$found = false;
	foreach ($items as $standing)
	{
		if (sizeof($standing) > 0)
			$found = true;	
	}
	return $found;
}

// we'll need this later
$standings = array(		
	'hated',
	'hostile',
	'unfriendly',
	'neutral',
	'friendly',
	'honored',
	'revered',
	'exalted'
);

// first, we need to get the necessary data from $_GET
$id 	=	(array_key_exists('id', $_GET)) 	? 	(int)$_GET['id']	:	null;
$lang 	=	(array_key_exists('lang', $_GET))	?	$_GET['lang']		:	WHP_LANG;
$mode	=	(array_key_exists('mode', $_GET))	?	$_GET['mode']		:	'tooltip';

// connect to sql
$cache = new wowhead_cache();

if ($id == null)
{
	echo 'Faction ID not given.';
	exit;
}

if ($mode == 'tooltip')
{
	if (!$result = $cache->getFaction($id, $lang, true))
	{
		$cache->close();
		echo 'Faction "' . $id . '" not found in cache.';
		exit;
	}
	else
	{
		echo stripslashes($result['tooltip']);
	}
}
elseif ($mode == 'rewards')
{
	if (!$result = $cache->getFactionRewards($id, $lang))
	{
		// gotta build the html
		$data = readURL(getDomain($lang) . '?faction=' . $id, false);
		$rLine = getRewardLine($data);
		
		if (!$rLine)
			return false;
		else
		{
			$items = array(	// this array will hold all of the items sorted by standing required to get them
				'hated'			=>	array(),
				'hostile'		=>	array(),
				'unfriendly'	=>	array(),
				'neutral'		=>	array(),
				'friendly'		=>	array(),
				'honored'		=>	array(),
				'revered'		=>	array(),
				'exalted'		=>	array()
			);
			
			// loop through the results and extract each item
			while (preg_match("#\{id:([0-9]{1,10}),name:'[0-9@]{1}(.+?)',(.+?),sourcemore:\[\{t:([0-9]{1,2}),ti:([0-9]{1,10}),n:'(.+?)',z:([0-9]{1,10})\}\],classs:([0-9]{1,2}),subclass:(.+?),standing:(.+?)}#", $rLine, $match))
			{
				// gotta query wowhead for every item (this could take a while)

				$iData = readURL(getDomain($lang) . '?item=' . (string)$match[1] . '&xml');

				if (!$iData)
					return false;
				$xml = simplexml_load_string($iData, 'SimpleXMLElement', LIBXML_NOCDATA);
				
				if ($xml->error == '')
				{
					$items[$standings[(int)$match[10]]][] = array(
						'name'			=>	(string)$xml->item->name,
						'id'			=>	(string)$xml->item['id'],
						'quality'		=>	(string)$xml->item->quality['id'],
						'lang'			=>	$lang,
						'icon'			=>	'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg',
						'url'			=>	getDomain($lang) . '?item=' . (string)$xml->item['id']
					);	
				}
				$rLine = str_replace($match[0], '', $rLine); 
				unset($iData, $xml);
			}
			
			// make sure we found something before we continue
			if (!rewardsFound($items))
			{
				echo 'No rewards were found.';
				$cache->close();
				exit;
			}
			
			// now we need to build the actual html
			$language = new wowhead_language();
			$language->loadLanguage($lang);
			
			$html = '';
			foreach ($items as $key => $standing)
			{
				if (sizeof($standing) > 0)
				{
					$html .= '<table class="faction-table" cellspacing="0" cellpadding="2">';
					$html .= '<tr><th>' . $language->words[$key] . '</th></tr>';
					$html .= '<tr><td>';
					foreach ($standing as $item)
					{
						$html .= "<div style=\"padding-left: 5px; display: block;\"><div class=\"iconsmall\" style=\"background: url(" . $item['icon'] . ") no-repeat scroll 4px 4px; top: 5px;\"><div class=\"tile\"><a href=\"" . $item['url'] . "\" target=\"_blank\" /></a></div></div><span style=\"height: 20px; display: inline; padding-top: 3px;\"><a class=\"q" . $item['quality'] . "\" href=\"" . $item['url'] . "\" target=\"_blank\">[" . $item['name'] . "]</a></span></div>\n";	
					}
					$html .= '</tr></td></table><br />';
				}
			}
			$cache->saveFactionRewards($html, $id, $lang);
			print $html;
		}
	}
	else
	{
		print stripslashes($result['rewards']);	
	}
}

$cache->close();
?>