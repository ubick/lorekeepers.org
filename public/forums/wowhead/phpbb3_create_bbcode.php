<?php
/**
* Wowhead (wowhead.com) - Create BBCode Entries for phpBB3
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

/*
* Escape string used in sql query
*/
function sql_escape($msg, $conn)
{
	return @mysql_real_escape_string($msg, $conn);
}

/*
* FROM phpBB3's dbal.php, modified for my needs.
* Build sql statement from array for insert/update/select statements
*
* Idea for this from Ikonboard
* Possible query values: INSERT, INSERT_SELECT, UPDATE, SELECT
*
*/
function sql_build_array($query, $assoc_ary, $conn)
{
	if (!is_array($assoc_ary))
	{
		return false;
	}

	$fields = $values = array();

	if ($query == 'INSERT' || $query == 'INSERT_SELECT')
	{
		foreach ($assoc_ary as $key => $var)
		{
			$fields[] = $key;

			if (is_array($var) && is_string($var[0]))
			{
				// This is used for INSERT_SELECT(s)
				$values[] = $var[0];
			}
			else
			{
				$values[] = sql_validate_value($var, $conn);
			}
		}

		$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
	}

	return $query;
}

/*
* From phpBB3's dbal.php, modified for my needs.
* Function for validating values
* @access private
*/
function sql_validate_value($var, $conn)
{
	if (is_null($var))
	{
		return 'NULL';
	}
	else if (is_string($var))
	{
		return "'" . sql_escape($var, $conn) . "'";
	}
	else
	{
		return (is_bool($var)) ? intval($var) : $var;
	}
}

/*
* From phpBB3's acp_bbcodes.php, modified for my needs.
* Build regular expression for custom bbcode
*/
function build_regexp(&$bbcode_match, &$bbcode_tpl)
{
	$bbcode_match = trim($bbcode_match);
	$bbcode_tpl = trim($bbcode_tpl);

	$fp_match = preg_quote($bbcode_match, '!');
	$fp_replace = preg_replace('#^\[(.*?)\]#', '[$1:$uid]', $bbcode_match);
	$fp_replace = preg_replace('#\[/(.*?)\]$#', '[/$1:$uid]', $fp_replace);

	$sp_match = preg_quote($bbcode_match, '!');
	$sp_match = preg_replace('#^\\\\\[(.*?)\\\\\]#', '\[$1:$uid\]', $sp_match);
	$sp_match = preg_replace('#\\\\\[/(.*?)\\\\\]$#', '\[/$1:$uid\]', $sp_match);
	$sp_replace = $bbcode_tpl;

	// @todo Make sure to change this too if something changed in message parsing
	$tokens = array(
		'TEXT' => array(
			'!(.*?)!es'	 =>	"str_replace(array(\"\\r\\n\", '\\\"', '\\'', '(', ')'), array(\"\\n\", '\"', '&#39;', '&#40;', '&#41;'), trim('\$1'))"
		)
	);

	$sp_tokens = array(
		'TEXT' => '(.*?)',
	);

	$pad = 0;
	$modifiers = 'i';

	if (preg_match_all('/\{(' . implode('|', array_keys($tokens)) . ')[0-9]*\}/i', $bbcode_match, $m))
	{
		foreach ($m[0] as $n => $token)
		{
			$token_type = $m[1][$n];

			reset($tokens[strtoupper($token_type)]);
			list($match, $replace) = each($tokens[strtoupper($token_type)]);

			// Pad backreference numbers from tokens
			if (preg_match_all('/(?<!\\\\)\$([0-9]+)/', $replace, $repad))
			{
				$repad = $pad + sizeof(array_unique($repad[0]));
				$replace = preg_replace('/(?<!\\\\)\$([0-9]+)/e', "'\${' . (\$1 + \$pad) . '}'", $replace);
				$pad = $repad;
			}

			// Obtain pattern modifiers to use and alter the regex accordingly
			$regex = preg_replace('/!(.*)!([a-z]*)/', '$1', $match);
			$regex_modifiers = preg_replace('/!(.*)!([a-z]*)/', '$2', $match);

			for ($i = 0, $size = strlen($regex_modifiers); $i < $size; ++$i)
			{
				if (strpos($modifiers, $regex_modifiers[$i]) === false)
				{
					$modifiers .= $regex_modifiers[$i];

					if ($regex_modifiers[$i] == 'e')
					{
						$fp_replace = "'" . str_replace("'", "\\'", $fp_replace) . "'";
					}
				}

				if ($regex_modifiers[$i] == 'e')
				{
					$replace = "'.$replace.'";
				}
			}

			$fp_match = str_replace(preg_quote($token, '!'), $regex, $fp_match);
			$fp_replace = str_replace($token, $replace, $fp_replace);

			$sp_match = str_replace(preg_quote($token, '!'), $sp_tokens[$token_type], $sp_match);
			$sp_replace = str_replace($token, '${' . ($n + 1) . '}', $sp_replace);
		}

		$fp_match = '!' . $fp_match . '!' . $modifiers;
		$sp_match = '!' . $sp_match . '!s';

		if (strpos($fp_match, 'e') !== false)
		{
			$fp_replace = str_replace("'.'", '', $fp_replace);
			$fp_replace = str_replace(".''.", '.', $fp_replace);
		}
	}
	else
	{
		// No replacement is present, no need for a second-pass pattern replacement
		// A simple str_replace will suffice
		$fp_match = '!' . $fp_match . '!' . $modifiers;
		$sp_match = $fp_replace;
		$sp_replace = '';
	}

	// Lowercase tags
	$bbcode_tag = preg_replace('/.*?\[([a-z0-9_-]+=?).*/i', '$1', $bbcode_match);
	$bbcode_search = preg_replace('/.*?\[([a-z0-9_-]+)=?.*/i', '$1', $bbcode_match);

	$fp_match = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $fp_match);
	$fp_replace = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $fp_replace);
	$sp_match = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $sp_match);
	$sp_replace = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $sp_replace);

	return array(
		'bbcode_tag'				=> $bbcode_tag,
		'first_pass_match'			=> $fp_match,
		'first_pass_replace'		=> $fp_replace,
		'second_pass_match'			=> $sp_match,
		'second_pass_replace'		=> $sp_replace
	);
}

$errors = array(); $success = array();
	
if (file_exists(dirname(__FILE__) . '/../config.php'))
	require(dirname(__FILE__) . '/../config.php');
else
	$errors[] = 'Could not find phpBB3\'s config file (config.php).';
	
if (isset($_POST['bbcode']) && sizeof($_POST['bbcode']) > 0)
{
	$conn = mysql_connect($dbhost, $dbuser, $dbpasswd) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
	
	// get our $_POST vars
	$checked = $_POST['bbcode'];
	$prefix = $_POST['table_prefix'];
	
	// gotta find the correct bbcode id for the database, it will also add 1 to it to begin our queries
	$query = mysql_query("SELECT max(bbcode_id) + 1 FROM {$prefix}bbcodes", $conn) or die(mysql_error());
	list($bbcode_id) = mysql_fetch_array($query);
	mysql_free_result($query);
	
	// loop through our array
	foreach ($checked as $line)
	{
		// split the $line by : to get tag, and help line
		list($tag, $helpline)	= explode(':', $line);
		
		// make sure tag isn't already added
		$query_text = "SELECT 1 as test FROM {$prefix}bbcodes WHERE LOWER(bbcode_tag) = '" . strtolower(mysql_real_escape_string($tag)) . "'";
		$query = mysql_query($query_text);
		list($test) = mysql_fetch_array($query);
		@mysql_free_result($query);
		
		if ($test == 1)
		{
			// duplicate entry
			$errors[] = 'BBCode ' . $tag . ' already exists.';
		}
		else
		{
			$helpline = 'Wowhead ' . $helpline;
			
			// build each field for the sql query
			$bbcode_match 	=	"[$tag]{TEXT}[/$tag]";
			$bbcode_tpl 	=	$bbcode_match;// same as match
			
			// get the other variables
			$data = build_regexp($bbcode_match, $bbcode_tpl);	
			$sql_ary = array(
				'bbcode_tag'				=> $tag,
				'bbcode_match'				=> $bbcode_match,
				'bbcode_tpl'				=> $bbcode_tpl,
				'display_on_posting'		=> 1,
				'bbcode_helpline'			=> $helpline,
				'first_pass_match'			=> $data['first_pass_match'],
				'first_pass_replace'		=> $data['first_pass_replace'],
				'second_pass_match'			=> $data['second_pass_match'],
				'second_pass_replace'		=> $data['second_pass_replace']
			);
			$sql_ary['bbcode_id'] = (int) $bbcode_id;
			
			//send the query to mysql
			$query_text = "INSERT INTO {$prefix}bbcodes" . sql_build_array('INSERT', $sql_ary, $conn);
			$query = mysql_query($query_text);
			
			if (!$query)
			{ 
				$errors[] = 'MySQL Error: ' . mysql_error();	
			}
			else
			{
				$success[] = 'Added Tag: ' . $tag;	
			}
			$bbcode_id++;
			@mysql_free_result($query);
		}
	}
	
	mysql_close($conn);
}
elseif (isset($_POST['bbcode']) && sizeof($_POST['bbcode']) == 0)
{
	$errors[] = 'You must select at least one BBCode.';	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Create Custom BBCode for Wowhead Tooltips</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<style type="text/css">
			body {
				background-color: #FFF;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #000;
			}
			
			table {
				border: 1px solid #000;
			}
			
			th {
				background: #E9E9E9 none repeat;
				color: #000;
				border-bottom: 1px solid #000;
			}
			
			td {
				padding-left: 3px; 	
				padding-bottom: 3px;
			}
			
			a, a:link, a:active, a:visited {
				text-decoration: none;
				color: #000;
			}
			
			a:hover {
				text-decoration: underline;
				color: #000;
			}
			
			li.error {
				color: #FF0000;
				font-weight: bold;
			}
			
			li.success {
				color: #00FF00;
				font-weight: bold;
			}
			
			input {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #000;
				text-decoration: none;
				background: transparent;
				border: 1px solid #000;
			}
			
			#selectall{
				
			}
			
			acronym {
				cursor: help;
			}
		</style>

		<script type="text/javascript">
			function toggle(yes)
			{
				for (i = 0; i < document.myform.elements['bbcode[]'].length; i++)
				{
					//alert(document.myform.elements['bbcode[]']);
					document.myform.elements['bbcode[]'][i].checked = yes;
				}
			}
		</script>
	</head>
	<body>
		<div align="center">
			<?php
				// print errors
				if (sizeof($errors) > 0)
				{
					print "<ul>";
					print '<li class="error">' . implode($errors, '</li><li class="error">');
					print "</li></ul>";
				}
				
				// print successes
				if (sizeof($success) > 0)
				{
					print '<ul>';
					print '<li class="success">' . implode($success, '</li><li class="success">');
					print '</li></ul>';	
				}
			?>
			<form name="myform" action="<?php print basename(__FILE__); ?>" method="post">
				<table cellspacing="0" cellpadding="0" width="25%">
					<tr><th>Add Custom BBCode to phpBB</th></tr>
					<tr>
						<td>
							<table style="border: 0px !important;" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" valign="top"><strong>Tags to add:</strong></td>
									<td width="80%">
										<input type="checkbox" name="bbcode[]" value="achievement:Achievement" /> Achievement<br />
										<input type="checkbox" name="bbcode[]" value="armory:Armory Character" /> Armory Character<br />
										<input type="checkbox" name="bbcode[]" value="craft:Craftable" /> Craftable<br />
										<input type="checkbox" name="bbcode[]" value="enchant:Enchant" /> Enchant<br />
										<input type="checkbox" name="bbcode[]" value="faction:Faction" /> Faction<br />
										<input type="checkbox" name="bbcode[]" value="guild:Armory Guild" /> Guild (Armory)<br />
										<input type="checkbox" name="bbcode[]" value="item:Item" /> Item<br />
										<input type="checkbox" name="bbcode[]" value="itemico:Item Icon" /> Item Icon<br />
										<input type="checkbox" name="bbcode[]" value="itemset:Item Set" /> Item Set<br />
										<input type="checkbox" name="bbcode[]" value="npc:NPC" /> NPC<br />
										<input type="checkbox" name="bbcode[]" value="object:Object" /> Object<br />
										<input type="checkbox" name="bbcode[]" value="profile:Profiler" /> Profiler<br />
										<input type="checkbox" name="bbcode[]" value="quest:Quest" /> Quest<br />
										<input type="checkbox" name="bbcode[]" value="recruit:Recruit" /> Recruit<br />
										<input type="checkbox" name="bbcode[]" value="spell:Spell" /> Spell<br />				
										<input type="checkbox" name="bbcode[]" value="zone:Zone" /> Zone<br />
										<input type="checkbox" name="selectall" onclick="toggle(this.checked);" /><strong>Select All</strong>
									</td>
								</tr>
								<tr>
									<td width="20%"><acronym title="Required so we can find the BBCode SQL table."><strong>Table Prefix:</strong></acronym></td>
									<td width="80%"><input type="text" name="table_prefix" value="<?= $table_prefix ?>" readonly="readonly" /></td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td colspan="2" width="100%" align="center">
										<input type="submit" name="do_add" value="Add BBCode" />&nbsp;
										<input type="reset" name="Reset" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
