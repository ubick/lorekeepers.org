<?php
if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  'wowprogress'		=> 'Guild rating',
  'pm_wowprgs_world'	=> 'World: ',
  'pm_wowprgs_realm'	=> 'Realm: ',
  'pm_wowprgs_on'	=> 'on ',
  'pm_wowprgs_tier'	=> 'Tier:',
  'pm_wowprgs_tier8'	=> '8',
  'pm_wowprgs_tier910'	=> '9 (10)',
  'pm_wowprgs_tier925'	=> '9 (25)',
));

?>
