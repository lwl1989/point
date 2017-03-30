-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 �?08 �?15 �?12:30
-- 服务器版本: 5.6.22
-- PHP 版本: 5.5.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ez_edu_sys`
--

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document`
--

DROP TABLE IF EXISTS `edu_db_document`;
CREATE TABLE IF NOT EXISTS `edu_db_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_classify` int(11) DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `page` smallint(6) NOT NULL DEFAULT '1',
  `intro` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `thumbnail` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tag` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `file_size` varchar(15) NOT NULL,
  `upload_time` datetime DEFAULT '0000-00-00 00:00:00',
  `file_type` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `swf_file_path` varchar(255) NOT NULL,
  `ext` varchar(10) CHARACTER SET utf8 NOT NULL,
  `views_count` int(11) DEFAULT '0',
  `print_count` int(11) DEFAULT '0',
  `score` float DEFAULT '0',
  `score_num` int(11) DEFAULT '0',
  `download_count` int(11) DEFAULT '0',
  `md5` varchar(128) CHARACTER SET utf8 NOT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
