<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Base Class
* By: Adam "craCkpot" Koch (tooltips@crackpot.us)
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



/**
* Wowhead Base Class
* @package wowhead
**/
class wowhead
{
	/**
	* Attempts to read URL and return content
	* @access private
	**/
	public function _read_url($url, $type = 'item', $headers = true)
	{
		// build the url
		switch ($type)
		{
			case 'profile':
				$built_url = 'http://profiler.wowhead.com/?profile=' . $url;
				break;
			case 'npc':
				$built_url = (is_numeric($url)) ? $this->_getDomain() . '/?npc=' . $url : $this->_getDomain() . '/?search=' . $this->_convert_string($url);
				break;
			case 'itemset':
				$built_url = (is_numeric($url)) ? $this->_getDomain() . '/?itemset=' . $url : $this->_getDomain() . '/?search=' . $this->_convert_string($url);
				break;
			case 'enchant':
			case 'quest':
			case 'spell':
			case 'achievement':
			case 'object':
				$type = ($type == 'enchant') ? 'spell' : $type;
				$built_url = (is_numeric($url)) ? $this->_getDomain() . '/?' . $type . '=' . $url . '&power' : $this->_getDomain() . '/?search=' . $this->_convert_string($url);
				break;
			case 'faction':
				$built_url = (is_numeric($url)) ? $this->_getDomain() . '/?faction=' . $url : $this->_getDomain() . '/?search=' . $this->_convert_string($url);
				break;
			case 'zone':
				$built_url = (is_numeric($url)) ? $this->_getDomain() . '/?zone=' . $url : $this->_getDomain() . '/?search=' . $this->_convert_string($url);
				break;
			case 'item':
			case 'itemico':
			case 'craftable':
			default:
				$built_url = $this->_getDomain() . '/?item=' . $this->_convert_string($url) . '&xml';
				break;
		}

		if (WOWHEAD_DEBUG)
		{
			echo $built_url . '<br/>';
		}

	 	// Try cURL first. If that isn't available, check if we're allowed to
		// use fopen on URLs.  If that doesn't work, just die.
		if (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HEADER, 1);
			curl_setopt($curl, CURLOPT_URL, $built_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$html_data = curl_exec($curl);
			if (!$html_data)
			{ 
				return false; 
			}
			curl_close($curl);
		}
		elseif (ini_get('allow_url_fopen') == 1)
		{
			$html_data = @file_get_contents($built_url);
		}
		else
		{
	        // Thanks to Aki Uusitalo
			$url_array = parse_url($built_url);

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
	    if ($headers == true && strpos($html_data, 'Location:') === false)
	    	$html_data = $this->_strip_headers($html_data);

		return $html_data;
	}

	public function _strip_headers($data)
	{
		// split the string
		$chunks = explode(chr(10), $data);

		// return the last index in the array, aka our xml
		return $chunks[sizeof($chunks) - 1];
	}

	/**
	* Cleans HTML for passing to Wowhead
	* @access private
	**/
	public function _cleanHTML($string)
	{
	    if (function_exists("mb_convert_encoding"))
	        $string = mb_convert_encoding($string, "UTF-8", "HTML-ENTITIES");
	    else
	    {
	       $conv_table = get_html_translation_table(HTML_ENTITIES);
	       $conv_table = array_flip($conv_table);
	       $string = strtr ($string, $conv_table);
	       $string = preg_replace('/&#(\d+);/me', "chr('\\1')", $string);
	    }
	    return ($string);
	}
	
	public function wowhead_map($in)
	{
		$split = str_split($in, 3);	// split the string into 3's
		$i = 1; $str = '';
		// now loop through the array and format them into the pins format the script recognizes
		foreach ($split as $coord)
		{
			switch ($i)
			{
				case 1:
					$str .= ((float)$coord / 10) . ',';
					$i = 2;
					break;
				case 2:
					$str .= ((float)$coord / 10) . '|';
					$i = 1;
					break;
				default: break;	
			}
		}
		return substr($str, 0, strlen($str) - 2);
	}
	
	// contributed by ltdelta from the support forums
	public function _convert_string($str)
	{
		// convert to utf8, if necessary
		if ($this->lang != 'de')
		{
			if (!$this->_is_utf8($str))
			{
				$str = utf8_encode($str);
			}
		}
		else
		{
			if ($this->_is_utf8($str))
			{
				$str = utf8_decode($str);
			}
		}
		// clean up the html
		$str = $this->_cleanHTML($str);
		// return the url encoded string
		return urlencode($str);
	}

	/**
	* Encodes the string in UTF-8 if it already isn't
	* @access private
	
	public function _convert_string($str)
	{
		// convert to utf8, if necessary
		if (!$this->_is_utf8($str))
		{
			$str = utf8_encode($str);
		}

		// clean up the html
		$str = $this->_cleanHTML($str);

		// return the url encoded string
		return urlencode($str);
	}
	*/

	/**
	* Returns true if the $string is UTF-8, false otherwise.
	* @access private
	**/
	public function _is_utf8($string) {
		// From http://w3.org/International/questions/qa-forms-utf-8.html
		return (preg_match('%^(?:
			[\x09\x0A\x0D\x20-\x7E]            # ASCII
			| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
			|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
			|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
			|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		)*$%xs', $string)) ? true : false;
	}

	/**
	* Gets the proper domain for the language selected
	* @access private
	**/
	public function _getDomain()
	{
		if ($this->lang == 'en')
			return 'http://www.wowhead.com';
		else
			return 'http://' . strtolower($this->lang) . '.wowhead.com';

		return 'http://www.wowhead.com';
	}

	/**
	* Returns the link to the spell/quest
	* @access private
	**/
	public function _generateLink($id, $type)
	{
		if ($type == 'itemico' || $type == 'item' || $type == 'item_icon')
		{
			return $this->_getDomain() . '/?item=' . $id;
		}
		else
		{
			return $this->_getDomain() . '/?' . $type . '=' . $id;
		}
	}

	/**
	* Checks if SimpleXML can accept 3 parameters
	* @access private
	**/
	public function _allowSimpleXMLOptions()
	{
		$parts = explode('.', phpversion());
		return ($parts[0] == 5 && $parts[1] >= 1) ? true : false;
	}

	/**
	* Uses Wowhead's search to find our info
	* @access private
	**/
	public function _findBySearch($name, $type = 'quest', $rank = '')
	{
		if ($type != 'quest' && $type != 'spell')
			return false;

		if ($type == 'spell')
			$matches = array();

		$data = $this->_read_url($name, $type, false);

		if (preg_match('#Location: /\?' . $type . '=(.+?)\n#s', $data, $match))
		{
			// for searches with only one result
			return array(1 => $match[1], 2 => ucwords(strtolower($name)));
		}
		else
		{

			// i'm sure there's a more efficient way to do this, but i can't think of one at the moment
			// so back off!!!! =D
			if ($type == 'spell')
			{
				$aLine = $this->_abilityLine($data, $name);
				if (!$aLine) { return false; }
				$the_line = $aLine['line'];
				if (WOWHEAD_DEBUG) { print $the_line . "<br/>"; }
				if ($aLine['type'] == 'ability' || $aLine['type'] == 'talent')
					$pattern = '#id:([0-9]{1,10}),name:\'\@(.+?)\',#s';
				elseif ($aLine['type'] == 'recipe')
					$pattern = '#id:([0-9]{1,10}),name:\'[3-6@]{1}(.+?)\',#s';
				else return false;
			}
			elseif ($type == 'quest')
			{
				$the_line = $data;
				$pattern = '#<a href="/\?quest=([0-9]{1,10})">(.+?)</a>#s';
			}

			// then we'll use preg_match to find any matches
			while (preg_match($pattern, $the_line, $match))
			{

				// do we have a match?
				if (stripslashes(strtolower($match[2])) == strtolower($name))
				{
					if ($type == 'quest')
					{
						return $match;
						break;
					}
					elseif ($type == 'spell')
					{
						// try to get the max rank of the spell
						array_push($matches, $match);
						$the_line = str_replace($match[0], '', $the_line);
					}
				}
				else
				{
					// remove the found entry to prevent a never ending loop
					$the_line = str_replace($match[0], '', $the_line);
				}
			}

			// now return the rank they asked for
			if ($type == 'spell' && $rank != '')
			{
				if ((int)$rank <= sizeof($matches))
				{
					array_push($matches[(int)$rank - 1], $rank);
					return $matches[((int)$rank - 1)];
				}
				elseif (((int)$rank > sizeof($matches)) || !is_numeric($rank))
				{
					return false;
				}
			}
			elseif ($type == 'spell' && $rank == '')
			{
				// otherwise give them max rank (if it has a rank)
				return $matches[sizeof($matches) - 1];
			}
		}
		return false;
	}

	public function generateError($error)
	{
		return '<span class="notfound">' . $error . '</span>';	
	}
	
	public function _notfound($type, $name)
	{
		$error = $this->language->words['notfound'];
		$error = str_replace('{type}', $type, $error);
		$error = str_replace('{name}', $name, $error);
		return '<span class="notfound">' . $error . '</span>';
	}

	/**
	* Returns the specific line we need
	* @access private
	**/
	public function _abilityLine($data, $name)
	{
		$parts = explode(chr(10), $data);

		foreach ($parts as $line)
		{
			if (strpos($line, "new Listview({template: 'spell', id: 'abilities'") !== false && strpos(strtolower($line), strtolower(addslashes($name))) !== false)
				return array(
					'type'	=>	'ability',
					'line'	=>	$line
				);
			elseif (strpos($line, "new Listview({template: 'spell', id: 'talents'") !== false && strpos(strtolower($line), strtolower(addslashes($name))) !== false)
				return array(
					'type'	=>	'talent',
					'line'	=> 	$line
				);
			elseif (strpos($line, "new Listview({template: 'spell', id: 'recipes'") !== false && strpos(strtolower($line), strtolower(addslashes($name))) !== false)
				return array(
					'type'	=>	'recipe',
					'line'	=>	$line
				);
			elseif (strpos($line, "new Listview({template: 'spell', id: 'uncategorized-spells'") !== false && strpos(strtolower($line), strtolower(addslashes($name))) !== false)
				return array(
					'type'	=>	'ability',
					'line'	=>	$line
				);
            elseif (strpos($line, "new Listview({template: 'spell', id: 'professions'") !== false && strpos(strtolower($line), strtolower(addslashes($name))) !== false)
                    return array(
                            'type'  =>      'recipe',
                            'line'  =>      $line
                    );
		}

		return false;
	}

	/**
	* Returns the specific line we need for achievements
	* @access private
	**/
	public function _achievementLine($data)
	{
		$parts = explode(chr(10), $data);	// split by line breaks

		foreach ($parts as $line)
		{
			if (strpos($line, "new Listview({template: 'achievement', id: 'achievements'") !== false)
				return $line;
		}
		return false;
	}

	/**
	* Replaces wildcards from patterns
	* @access private
	**/
	public function _replaceWildcards($in, $info)
	{
		$wildcards = array();

		// build our wildcard array
		if (array_key_exists('link', $info))
			$wildcards['{link}'] = $info['link'];

		if (array_key_exists('realm', $info))
			$wildcards['{realm}'] = $info['realm'];

		if (array_key_exists('region', $info))
			$wildcards['{region}'] = $info['region'];

		if (array_key_exists('icons', $info))
			$wildcards['{icons}'] = $info['icons'];

		if (array_key_exists('name', $info))
			$wildcards['{name}'] = stripslashes($info['name']);

		if (array_key_exists('quality', $info))
			$wildcards['{qid}'] = $info['quality'];

		if (array_key_exists('rank', $info))
			$wildcards['{rank}'] = $info['rank'];

		if (array_key_exists('icon', $info))
			$wildcards['{icon}'] = $info['icon'];

		if (array_key_exists('class', $info))
			$wildcards['{class}'] = $info['class'];

		if (array_key_exists('gems', $info))
			$wildcards['{gems}'] = $info['gems'];

		if (array_key_exists('tooltip', $info))
			$wildcards['{tooltip}'] = $info['tooltip'];

		if (array_key_exists('npcid', $info))
			$wildcards['{npcid}'] = $info['npcid'];
			
		if (array_key_exists('image', $info))
			$wildcards['{image}'] = $info['image'];
		
		if (array_key_exists('id', $info))
			$wildcards['{id}'] = $info['id'];
		
		if (array_key_exists('lang', $info))
			$wildcards['{lang}'] = $info['lang'];

		foreach ($wildcards as $key => $value)
		{
			$in = str_replace($key, $value, $in);
		}

		return $in;
	}

	/**
	* Builds Item Enhancement String
	* @access private
	**/
	public function _buildEnhancement($args)
	{
		if (!is_array($args) || sizeof($args) == 0)
			return false;

		if (array_key_exists('gems', $args))
		{
			$gem_args = '&amp;gems=' . str_replace(',', ':', $args['gems']);
		}

		if (array_key_exists('enchant', $args))
		{
			$enchant_args = '&amp;ench=' . $args['enchant'];
		}

		if (!empty($gem_args) && !empty($enchant_args))
		{
			return $enchant_args . $gem_args;
		}
		elseif (!empty($enchant_args))
		{
			return $enchant_args;
		}
		elseif (!empty($gem_args))
		{
			return $gem_args;
		}

		return false;
	}

	/**
	* Generates HTML for link
	* @access public
	**/
	public function generateHTML($info, $type, $size = '', $rank = '', $gems = '')
	{
		global $external_css, $qualities;
		
		if ($type == 'faction')
			$info['link'] = $this->_generateLink($info['id'], 'faction');
		elseif ($type != 'profile' && $type != 'armory' && $type != 'guild' && $type != 'armory_gearlist' && $type != 'armory_recruit')
			$info['link'] = ($type == 'npc') ? $this->_generateLink($info['npcid'], 'npc') : $this->_generateLink($info['itemid'], $type);

		if ($type == 'item')
		{
			if ($external_css == true || (array_key_exists('quality', $info) && sizeof($qualities) > 0 && in_array($info['quality'], $qualities)))
			{
				if (trim($gems) != '')
				{
					$info['gems'] = $gems;
					return $this->_replaceWildcards($this->patterns->pattern('item_css_gems'), $info);
				}
				else
				{
					return $this->_replaceWildcards($this->patterns->pattern('item_css'), $info);
				}
			}
			elseif (trim($gems) != '')
			{
				$info['gems'] = $gems;
				return $this->_replaceWildcards($this->patterns->pattern('item_gems'), $info);
			}
			else
			{
				return $this->_replaceWildcards($this->patterns->pattern('item'), $info);
			}
		}
		elseif ($type == 'item_icon')
		{
			if ($external_css == true || (array_key_exists('quality', $info) && sizeof($qualities) > 0 && in_array($info['quality'], $qualities)))
			{
				return $this->_replaceWildcards($this->patterns->pattern('item_icon_css'), $info);	
			}
			else
			{
				return $this->_replaceWildcards($this->patterns->pattern('item_icon'), $info);	
			}
		}
		elseif ($type == 'itemico')
		{
			return $this->_replaceWildcards($this->patterns->pattern('icon_' . $size), $info);
		}
		elseif ($type == 'spell')
		{
			if (trim($rank) != '')
			{
				return $this->_replaceWildcards($this->patterns->pattern('spell_rank'), $info);
			}
			else
			{
				return $this->_replaceWildcards($this->patterns->pattern('spell'), $info);
			}
		}
		else
		{
			return $this->_replaceWildcards($this->patterns->pattern($type), $info);
		}

	}

	/**
	* Strips out any apostrophes to prevent any display problems
	* @access private
	**/
	public function _strip_apos($in)
	{
		return str_replace("'", "", $in);
	}
}
?>