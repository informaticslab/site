CREATE TABLE IF NOT EXISTS `#__es_bcs_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `params` text NOT NULL,
  `use_variables` tinyint(3) unsigned NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__es_bcs_pattern_items` (
  `pattern_id` int(10) unsigned NOT NULL,
  `item_id` varchar(25) NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL default '1',
  `id` int(10) unsigned NOT NULL auto_increment,
  `provider_id` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__es_bcs_patterns` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `use_dsp` tinyint(3) unsigned NOT NULL,
  `use_dep` tinyint(3) unsigned NOT NULL,
  `strict` tinyint(3) unsigned NOT NULL,
  `use_replacements` tinyint(3) unsigned NOT NULL default '2',
  `global` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__es_bcs_section_patterns` (
  `pattern_id` int(10) unsigned NOT NULL,
  `context_html_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__es_bcs_static_entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL,
  `position` tinyint(3) NOT NULL,
  `entry_type` tinyint(3) unsigned NOT NULL,
  `reference_id` varchar(50) NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `global` tinyint(3) unsigned NOT NULL,
  `always_active` tinyint(3) unsigned NOT NULL,
  `url_condition` mediumtext NOT NULL,
  `use_url_condition` tinyint(3) unsigned NOT NULL,
  `use_context_condition` tinyint(3) unsigned NOT NULL,
  `context_condition` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__es_bcs_static_entry_patterns` (
  `static_entry_id` int(10) unsigned NOT NULL,
  `pattern_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
