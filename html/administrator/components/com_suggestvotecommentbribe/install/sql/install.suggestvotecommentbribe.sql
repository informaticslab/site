CREATE TABLE `#__suggestvotecommentbribe_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `#__suggestvotecommentbribe_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `UID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE `#__suggestvotecommentbribe_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `UID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE `#__suggestvotecommentbribe_bribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE `#__suggestvotecommentbribe_sugg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `UID` int(11) NOT NULL,
  `state` int(1) NOT NULL,
  `amountDonated` decimal(10,2) NOT NULL,
  `noofVotes` int(11) NOT NULL,
  `noofComs` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE `#__suggestvotecommentbribe_security` (
  `UID` int(11) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;