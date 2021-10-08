CREATE TABLE IF NOT EXISTS `banner` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `format_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `code` text,
  `adviews` int(10) unsigned NOT NULL DEFAULT '0',
  `adclicks` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
/* SPLIT */
CREATE TABLE IF NOT EXISTS `formats` (
  `format_id` int(10) NOT NULL AUTO_INCREMENT,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alt_name` varchar(50) NULL DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
/* SPLIT */
INSERT INTO `formats` (`format_id`, `width`, `height`, `name`, `desc`) VALUES
(1, 468, 60, 'Standardbanner', 'Standardbanner'),
(2, 234, 60, 'Halbbanner', 'Halbbanner'),
(3, 120, 600, 'Skyscraper', 'Skyscraper'),
(4, 88, 31, 'Button', 'Button');
/* SPLIT */
CREATE TABLE IF NOT EXISTS `login` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/* SPLIT */
CREATE TABLE IF NOT EXISTS `reload` (
  `time` int(10) unsigned NOT NULL,
  `ipadress` varchar(32) NOT NULL,
  `type` varchar(10) NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  KEY `banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/* SPLIT */
CREATE TABLE IF NOT EXISTS `settings` (
  `config_name` varchar(50) NOT NULL,
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`,`config_value`),
  UNIQUE KEY `config_name` (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/* SPLIT */
INSERT INTO `settings` (`config_name`, `config_value`) VALUES ('Arlight.dbVersion', '1500');
/* SPLIT */
ALTER TABLE `reload` ADD CONSTRAINT `fk_banner_id` FOREIGN KEY (`banner_id`) REFERENCES `banner` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE;
/* SPLIT */
CREATE VIEW `vwRandomBanner` AS
SELECT b.format_id format_id,b.banner_id banner_id,RAND() as ran FROM banner b LEFT JOIN formats f ON (b.format_id=f.format_id) WHERE b.status = 1 GROUP BY f.format_id HAVING MAX(ran) ORDER BY f.format_id;
/* SPLIT */
CREATE VIEW `vwUsers` AS 
SELECT user_id,name,status FROM login ORDER BY LOWER(name);