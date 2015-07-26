<?php
/**
* Wowhead (wowhead.com) Tooltips v3 - Craftable Extension
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
include_once(dirname(__FILE__) . '/wowhead_cache.php');
include_once(dirname(__FILE__) . '/wowhead_patterns.php');
include_once(dirname(__FILE__) . '/../config.php');
include_once(dirname(__FILE__) . '/wowhead_language.php');

class wowhead_craft extends wowhead
{
	public $patterns;
	public $lang;
	public $language;
	private $createdby = array();
	private $craft = array();
	private $craft_spell = array();
	private $craft_reagents = array();
	private $nomats = false;

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
		if (trim($name) == '')
			return false;

		$this->lang = (!array_key_exists('lang', $args)) ? WHP_LANG : $args['lang'];
		$this->language->loadLanguage($this->lang);		// load the language pack
		$this->nomats = (!array_key_exists('nomats', $args)) ? false : $args['nomats'];
		$cache = new wowhead_cache();

		if (!$result = $cache->getCraftable($name, $this->lang))
		{
			$data = $this->_read_url($name, 'craftable');

            // accounts for SimpleXML not being able to handle 3 parameters if you're using PHP 5.1 or below.
            if (!$this->_allowSimpleXMLOptions())
            {
                    $data = $this->_removeCData($data);
                    $xml = simplexml_load_string($data, 'SimpleXMLElement');
            }
            else
            {
                    $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            }

            if ($xml->error == '')
            {
                    // build our craft array
                    $this->craft = array(
                            'itemid'		=>	$xml->item['id'],
                            'name'			=>	$xml->item->name,
                            'search_name'	=>	$name,
                            'quality'		=>	$xml->item->quality['id'],
                            'lang'			=>	$this->lang,
                            'icon'			=>	'http://static.wowhead.com/images/icons/small/' . strtolower($xml->item->icon) . '.jpg'
                    );

                    // build spell craft array
                    $this->craft_spell = array(
                            'reagentof'		=>	$xml->item['id'],
                            'spellid'		=>	$xml->item->createdBy->spell['id'],
                            'name'			=>	$xml->item->createdBy->spell['name']
                    );
                    if ($this->nomats == false)
                    {
                            // build reagent array
                            foreach ($xml->item->createdBy->spell->reagent as $reagent)
                            {
                                    array_push($this->craft_reagents, array(
                                            'itemid'	=>	$reagent['id'],
                                            'reagentof'	=>	$xml->item['id'],
                                            'name'		=>	$reagent['name'],
                                            'quantity'	=>	$reagent['count'],
                                            'quality'	=>	$reagent['quality'],
                                            'icon'		=>	'http://static.wowhead.com/images/icons/small/' . strtolower($reagent['icon']) . '.jpg'
                                    ));
                            }
                    }
            }
            else
            {
                    $cache->close();
                    return $this->_notfound($this->language->words['craft'], $name);
            }

			if ($this->nomats == false)
			{
				$cache->saveCraftable($this->craft, $this->craft_spell, $this->craft_reagents);
			}
			else
			{
				$cache->saveCraftable($this->craft, $this->craft_spell);
			}
			unset($xml); $cache->close();
			return $this->_toHTML();
		}
		else
		{
			$this->craft = $result;
			$this->craft_spell = $cache->getCraftableSpell($this->craft['itemid']);
			if ($this->nomats == false)
				$this->craft_reagents = $cache->getCraftableReagents($this->craft['itemid']);
			$cache->close();
			return $this->_toHTML();
		}
	}

	/**
	* Generates HTML for display
	* @access private
	**/
	private function _toHTML()
	{
		if ($this->nomats == false)
		{
			// generate spell html first
			$spell_html = $this->patterns->pattern('craftable_spell');
			$spell_html = str_replace('{link}', $this->_generateLink($this->craft_spell['spellid'], 'spell'), $spell_html);
			$spell_html = str_replace('{name}', $this->craft_spell['name'], $spell_html);

			// generate reagent html now
			$reagent_html = '';
			foreach ($this->craft_reagents as $reagent)
			{
				$patt = $this->patterns->pattern('craftable_reagents');
				$search = array(
					'{link}'	=>	$this->_generateLink($reagent['itemid'], 'item'),
					'{name}'	=>	stripslashes($reagent['name']),
					'{count}'	=>	$reagent['quantity'],
					'{qid}'		=>	$reagent['quality'],
					'{icon}'	=>	$reagent['icon']
				);

				foreach ($search as $key => $value)
					$patt = str_replace($key, $value, $patt);

				$reagent_html .= $patt;
			}

			// finally put it all together
			$craft_html = $this->patterns->pattern('craftable');
			$craft_html = str_replace('{spell}' , $spell_html, $craft_html);
			$craft_html = str_replace('{reagents}', $reagent_html, $craft_html);
			$craft_html = str_replace('{link}', $this->_generateLink($this->craft['itemid'], 'item'), $craft_html);
			$craft_html = str_replace('{qid}', $this->craft['quality'], $craft_html);
			$craft_html = str_replace('{name}', stripslashes($this->craft['name']), $craft_html);
		}
		else
		{
			$craft_html = $this->patterns->pattern('craftable_nomats');
			$craft_html = str_replace('{link}', $this->_generateLink($this->craft['itemid'], 'item'), $craft_html);
			$craft_html = str_replace('{qid}', $this->craft['quality'], $craft_html);
			$craft_html = str_replace('{name}', stripslashes($this->craft['name']), $craft_html);
			$craft_html = str_replace('{splink}', $this->_generateLink($this->craft_spell['spellid'], 'spell'), $craft_html);
			$craft_html = str_replace('{spname}', stripslashes($this->craft_spell['name']), $craft_html);
		}
		return $craft_html;
	}

}
?>