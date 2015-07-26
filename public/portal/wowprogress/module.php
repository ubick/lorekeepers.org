<?php

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$portal_module['wowprogress'] = array(
   'name'         => 'Guild rating',
   'path'         => 'wowprogress',
   'version'      => '1.0.1',
   'author'      => 'Grib',
   'contact'      => 'http://dkp.ruwow.org/',
   'description'   => 'PvE guild rating from www.wowprogress.com',
   'positions'     => array('left1', 'left2', 'right'),
   'install'       => array(
            'autoenable'        => '0',
            'defaultposition'   => 'right',
            'defaultnumber'     => '4', ),
   );

if(!function_exists(wowprogress_module))
{
    function wowprogress_module()
    {
      global $tpl, $eqdkp, $eqdkp_root_path, $conf_plus, $eqdkp_config, $user, $plang, $pdc, $urlreader;
   
      $out = $pdc->get('dkp.portal.modul.wowprogress',false,true);
       if (!$out) 
        {  
         $pm_wowprgs_url = "http://www.wowprogress.com/";      
         $search = array('+',"'"," ");
         $server = urlencode(strtolower(str_replace($search, '-',$conf_plus['pk_servername'])));
         $guild = str_replace($search, '+', urlencode(strtolower($eqdkp->config['guildtag'])));   
         $pm_wowprgs_guild_url = $pm_wowprgs_url . "guild/" . $conf_plus[pk_server_region] . "/" . $server  . "/Lorekeepers";   
         $pm_wowprgs_guild_url_25 = $pm_wowprgs_url . "guild/" . $conf_plus[pk_server_region] . "/" . $server  . "/Lorekeepers/rating.tier13_25";   
		 $pm_wowprgs_guild_rank_url = $pm_wowprgs_guild_url . "/json_rank"; 				 
		 $pm_wowprgs_guild_rank_url_25 = $pm_wowprgs_guild_url_25 . "/json_rank"; 				 
         $pm_wowprgs_guild_rank = explode('"', $urlreader->GetURL("$pm_wowprgs_guild_rank_url"));
         $pm_wowprgs_guild_rank_25 = explode('"', $urlreader->GetURL("$pm_wowprgs_guild_rank_url_25"));

		$ranking_info = json_decode($urlreader->GetURL("$pm_wowprgs_guild_rank_url"));
		$world_rank = $ranking_info->world_rank;
		$eu_rank = $ranking_info->area_rank;
		$server_rank = $ranking_info->realm_rank;
		
		$ranking_info_25 = json_decode($urlreader->GetURL("$pm_wowprgs_guild_rank_url_25"));
		$world_rank_25 = $ranking_info_25->world_rank;
		$eu_rank_25 = $ranking_info_25->area_rank;
		$server_rank_25 = $ranking_info_25->realm_rank;		
				

				
         $out .= '<table width="100%" border="0" cellspacing="1" cellpadding="2" class="noborder">';
         $out .= '<tr class="row1" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row1\';"><td colspan="3">';
         $out .= '<a href="' . $pm_wowprgs_guild_url . '" target="_blank" title="&quot;' . $eqdkp->config['guildtag'] . '&quot; ' . $plang['pm_wowprgs_on']  . 'wowprogress.com">Lorekeepers</a>';
         $out .= '</td></tr>';
         $out .= '<tr class="row2" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row2\';"><td colspan="3">';
         $out .= $conf_plus['pk_servername'];
         $out .= '</td></tr>';
         $out .= '<tr class="row1" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row1\';"><td><b>' .$plang['pm_wowprgs_tier'];
         $out .= '</b></td>';
         $out .= '<td nowrap="nowrap" align="right"><b>25M';
         $out .= '</b></td>';		 
         $out .= '<td nowrap="nowrap" align="right"><b>Overall';
         $out .= '</b></td></tr>';
         $out .= '<tr class="row2" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row2\';"><td>' . $plang['pm_wowprgs_world'];
         $out .= '</b></td>';
         $out .= '<td align="right">' . $world_rank_25;
		 $out .= '</td>';
         $out .= '<td align="right">' . $world_rank;
         $out .= '</td></tr>';
         $out .= '<tr class="row1" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row1\';"><td>' . strtoupper($conf_plus[pk_server_region]) . ': ';
         $out .= '</b></td>';
         $out .= '<td align="right">' . $eu_rank_25;
		 $out .= '</td>';		 
         $out .= '<td align="right">' . $eu_rank;
         $out .= '</td></tr>';
         $out .= '<tr class="row2" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row2\';"><td>' . $plang['pm_wowprgs_realm'];
         $out .= '</b></td>';
         $out .= '<td align="right">' . $server_rank_25;
		 $out .= '</td>';		 
         $out .= '<td align="right">' . $server_rank;
         $out .= '</td></tr>';
         $out .= '<tr class="row1" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\'row1\';"><td colspan=\'4\' align=\'center\'><a href="http://www.wowprogress.com/" target="_blank"><small>www.wowprogress.com</small></a></td></tr>';
         $out .= '</table>';
         
         $pdc->put('dkp.portal.modul.wowprogress',$out,86400,false,true);
         
         return $out;
        }else 
        {
           return $out;
        }
    }
}
?>