<?php
/**
* Wowhead (wowhead.com) Link Parser v3 - Zone Parser
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

$cache 	= 	new wowhead_cache();
$id		=	(isset($_GET['id'])) 	? (int)$_GET['id'] 	: 	null;
$lang	= 	(isset($_GET['lang'])) 	? $_GET['lang'] 	: 	WHP_LANG;
$pins	=	(isset($_GET['pins']) && $_GET['pins'] != '{pins}') ? $_GET['pins'] : null;

// images path and urls
$wowhead_zone_maps = 'http://static.wowhead.com/images/maps/enus/normal/';
$maps_url = $armory_image_url . 'images/zones/';
$maps_dir = dirname(__FILE__) . '/../images/zones/';

if ($id == null)
{
	echo 'ID not given.';
	$cache->close;
	exit;
}

if (!$result = $cache->getZone($id, $lang, true))
{
	echo 'Zone not found in the cache.';
	$cache->close();
	exit;	
}
else
{
	// parse the pins to make them easier to deal with
	$coords = array();
	if ($pins != null)
	{
		$each = explode('|', $pins);
		foreach ($each as $val)
		{
			$xy = explode(',', $val);
			$coords[] = array(
				'x'	=>	$xy[0],
				'y'	=>	$xy[1]
			);	
		}
	}
	
	// get the image based on whether or not the file exists locally
	$image = (file_exists($maps_dir . $result['map'])) ? $maps_url . $result['map'] : $wowhead_zone_maps . $result['map'];
	echo '<div style="float:left; background: url(' . $armory_image_url . 'images/shadowAlpha.png) no-repeat bottom right !important; background: url(' . $armory_image_url . 'images/shadow.gif) no-repeat bottom right; margin: 10px 0 0 10px !important; margin: 10px 0 0 5px;">' ;
	echo '<img src="' . stripslashes($image) . '" alt="' . stripslashes($result['name']) . '" style="display: block; position: relative; background-color: #fff; border: 1px solid #a9a9a9; margin: -6px 6px 6px -6px; padding: 4px;" />';
	echo '<div style="position: absolute; top: 10px; left: 10px; color: white; font-weight: bold; font-size: 16pt; text-shadow: 1px 1px 4px rgba(0, 0, 0, 1);">' . stripslashes($result['name']) . '</div>';
	
	// place the pins based on the coordinates provided
	if (sizeof($coords) > 0)
	{
		list($width, $height, $type, $attr) = getimagesize($image);	// for placing pins
		foreach ($coords as $pin)
		{
			// make sure the given coords aren't > 100%
			if ((float)$pin['x'] <= 100 && (float)$pin['y'] <= 100)
			{
				// first we need to get the exact pixel location so CSS knows where to place the pin.  it is based on percentages
				$x_per = round($width * ((float)$pin['x'] / 100), 1);
				$y_per = round($height * ((float)$pin['y'] / 100), 1);
				echo '<div style="-moz-background-clip:border; -moz-background-inline-policy:continuous; -moz-background-origin:padding; background:transparent url(' . $maps_url . 'pin.png) no-repeat scroll 0 0; display:block; height:11px; left:' . $x_per . 'px; position:absolute; top:' . $y_per . 'px; width:11px;"></div>';	
			}
		}
	}
	echo '</div>';
	$cache->close();
	exit;
}
?>