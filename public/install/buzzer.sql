/**
 * Author:  Reaper
 * Created: 14-Mar-2019
 */

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `config_key` varchar(60) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

INSERT INTO `config` (`config_key`, `value`) VALUES ('groupe', '5');
INSERT INTO `config` (`config_key`, `value`) VALUES ('timer', '60');
INSERT INTO `config` (`config_key`, `value`) VALUES ('timer2', '15');
INSERT INTO `config` (`config_key`, `value`) VALUES ('round', '1');

-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

DROP TABLE IF EXISTS `click`;
CREATE TABLE IF NOT EXISTS `click` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `groupe` tinyint(2) NOT NULL,
  `time` int(15) NOT NULL,
  `round` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 
--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



COMMIT;