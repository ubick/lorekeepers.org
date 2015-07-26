DROP TABLE IF EXISTS `{PREFIX}cache`;
CREATE TABLE IF NOT EXISTS `{PREFIX}cache` (
	`id` mediumint(8) unsigned NOT NULL auto_increment,
	`itemid` mediumint(8) unsigned NOT NULL default '0',
	`name` varchar(255) NOT NULL default '',
	`search_name` varchar(255) NOT NULL default '',
	`quality` smallint(2) unsigned default NULL,
	`rank` smallint(2) unsigned default NULL,
	`type` varchar(255) NOT NULL default '',
	`lang` varchar(255) default NULL,
	`icon` varchar(255) default NULL,
	`icon_size` varchar(255) default NULL,
	PRIMARY KEY  (`id`)
);
DROP TABLE IF EXISTS `{PREFIX}craftable`;
CREATE TABLE IF NOT EXISTS `{PREFIX}craftable` (
	`itemid` int(10) unsigned NOT NULL default '0',
	`name` varchar(255) NOT NULL default '',
	`search_name` varchar(255) NOT NULL default '',
	`quality` smallint(2) unsigned default NULL,
	`lang` varchar(255) default NULL,
	`icon` varchar(255) default NULL
);
DROP TABLE IF EXISTS `{PREFIX}craftable_reagent`;
CREATE TABLE IF NOT EXISTS `{PREFIX}craftable_reagent` (
	`itemid` int(8) unsigned NOT NULL default '0',
	`reagentof` int(11) unsigned NOT NULL,
	`name` varchar(255) NOT NULL default '',
	`quantity` smallint(2) unsigned NOT NULL,
	`quality` smallint(1) unsigned NOT NULL,
	`icon` varchar(255) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}craftable_spell`;
CREATE TABLE IF NOT EXISTS `{PREFIX}craftable_spell` (
	`reagentof` mediumint(8) unsigned NOT NULL,
	`spellid` mediumint(8) unsigned NOT NULL,
	`name` varchar(255) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}itemset`;
CREATE TABLE IF NOT EXISTS `{PREFIX}itemset` (
	`setid` mediumint(8) NOT NULL,
	`name` varchar(255) NOT NULL,
	`search_name` varchar(255) NOT NULL,
	`lang` varchar(2) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}itemset_reagent`;
CREATE TABLE IF NOT EXISTS `{PREFIX}itemset_reagent` (
	`setid` mediumint(8) NOT NULL,
	`itemid` mediumint(8) unsigned NOT NULL,
	`name` varchar(255) NOT NULL,
	`quality` smallint(1) NOT NULL,
	`icon` varchar(255) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}npc`;
CREATE TABLE IF NOT EXISTS `{PREFIX}npc` (
	`npcid` int(8) unsigned NOT NULL,
	`name` varchar(255) NOT NULL,
	`search_name` varchar(255) NOT NULL,
	`lang` varchar(2) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}armory`;
CREATE TABLE IF NOT EXISTS `{PREFIX}armory` (
	`uniquekey` varchar(100) NOT NULL,
	`name` varchar(32) NOT NULL,
	`class` varchar(25) NOT NULL,
	`raceid` smallint(2) NOT NULL,
	`classid` smallint(2) NOT NULL,
	`genderid` smallint(2) NOT NULL,
	`realm` varchar(255) NOT NULL,
	`region` varchar(2) NOT NULL,
	`tooltip` text NOT NULL,
	`cache` int(11) unsigned NOT NULL,
	PRIMARY KEY (`uniquekey`)
);
DROP TABLE IF EXISTS `{PREFIX}guild`;
CREATE TABLE IF NOT EXISTS `{PREFIX}guild` (
	`uniquekey` varchar(32) NOT NULL,
	`name` varchar(75) NOT NULL,
	`realm` varchar(20) NOT NULL,
	`region` varchar(2) NOT NULL,
	`tooltip` text NOT NULL,
	`cache` int(11) unsigned NOT NULL,
	PRIMARY KEY  (`uniquekey`)
);
DROP TABLE IF EXISTS `{PREFIX}gearlist`;
CREATE TABLE IF NOT EXISTS `{PREFIX}gearlist` (
	`uniquekey` varchar(32) NOT NULL,
	`cache` int(10) unsigned NOT NULL,
	`list` text NOT NULL,
	PRIMARY KEY (`uniquekey`)
);
DROP TABLE IF EXISTS `{PREFIX}recruit`;
CREATE TABLE IF NOT EXISTS `{PREFIX}recruit` (
	`uniquekey` varchar(32) NOT NULL,
	`cache` int(10) unsigned NOT NULL,
	`gearlist` text NOT NULL,
	`raid` text NOT NULL,
	`faction` text NOT NULL,
	`talents` text NOT NULL,
	PRIMARY KEY (`uniquekey`)
);
DROP TABLE IF EXISTS `{PREFIX}talent_names`;
CREATE TABLE IF NOT EXISTS `{PREFIX}talent_names` (
	`id` int(8) unsigned NOT NULL,
	`name` text NOT NULL,
	`lang` varchar(2) NOT NULL,
	`icon` text NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}zones`;
CREATE TABLE IF NOT EXISTS `{PREFIX}zones` (
	`id` mediumint(8) unsigned NOT NULL,
	`name` varchar(255) NOT NULL,
	`search_name` varchar(255) NOT NULL,
	`map` varchar(255) NOT NULL,
	`lang` varchar(2) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}faction`;
CREATE TABLE IF NOT EXISTS `{PREFIX}faction` (
	 `id` mediumint(8) unsigned NOT NULL,
	 `name` varchar(255) NOT NULL,
	 `search_name` varchar(255) NOT NULL,
	 `tooltip` text NOT NULL,
	 `lang` varchar(2) NOT NULL,
	 `rewards` text DEFAULT NULL
);
DROP TABLE IF EXISTS `{PREFIX}enchant`;
CREATE TABLE `{PREFIX}enchant` (
	 `id` mediumint(8) unsigned NOT NULL,
	 `name` varchar(255) NOT NULL,
	 `search_name` varchar(255) NOT NULL,
	 `lang` varchar(2) NOT NULL
);
DROP TABLE IF EXISTS `{PREFIX}enchant_reagent`;
CREATE TABLE `{PREFIX}enchant_reagent` (
	 `id` mediumint(8) unsigned NOT NULL,
	 `reagentof` mediumint(8) unsigned NOT NULL,
	 `name` varchar(255) NOT NULL,
	 `quantity` smallint(2) unsigned NOT NULL,
	 `quality` smallint(1) unsigned NOT NULL,
	 `icon` varchar(255) NOT NULL,
	 `lang` varchar(2) NOT NULL
);
