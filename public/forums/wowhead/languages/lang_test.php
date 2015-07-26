<?php
    $lang_packs = array(
		'en'	=>	'en.php',
		'de'	=>	'de.php',
		'ru'	=>	'ru.php',
		'fr'	=>	'fr.php',
		'es'	=>	'es.php'
	);
	
	foreach ($lang_packs as $lang => $file)
	{
		require(dirname(__FILE__) . '/' . $file);
		print "{$lang}: " . sizeof($lang_array) . "<br />";	
	}
?>