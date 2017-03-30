-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 �?07 �?21 �?14:57
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
-- 表的结构 `edu_db_app_access`
--

DROP TABLE IF EXISTS `edu_db_app_access`;
CREATE TABLE IF NOT EXISTS `edu_db_app_access` (
  `int` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(32) NOT NULL,
  `appsecret` varchar(64) NOT NULL,
  `is_true` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`int`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_article`
--

DROP TABLE IF EXISTS `edu_db_article`;
CREATE TABLE IF NOT EXISTS `edu_db_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL,
  `intro` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `cover` varchar(200) NOT NULL,
  `create_time` date NOT NULL,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_cart`
--

DROP TABLE IF EXISTS `edu_db_cart`;
CREATE TABLE IF NOT EXISTS `edu_db_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_info` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_ci_sessions`
--

DROP TABLE IF EXISTS `edu_db_ci_sessions`;
CREATE TABLE IF NOT EXISTS `edu_db_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_client_info`
--

DROP TABLE IF EXISTS `edu_db_client_info`;
CREATE TABLE IF NOT EXISTS `edu_db_client_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `creat_time` datetime DEFAULT NULL,
  `operate_token` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_company_comments`
--

DROP TABLE IF EXISTS `edu_db_company_comments`;
CREATE TABLE IF NOT EXISTS `edu_db_company_comments` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `site_id` int(9) NOT NULL DEFAULT '1',
  `company_id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `content` varchar(200) NOT NULL,
  `agree_count` int(11) NOT NULL DEFAULT '0' COMMENT '赞同数量',
  `not_agree_count` int(11) NOT NULL DEFAULT '0' COMMENT '不赞同数量',
  `is_forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被禁止',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `is_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `site_id` (`company_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='企业点评表' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_company_payment`
--

DROP TABLE IF EXISTS `edu_db_company_payment`;
CREATE TABLE IF NOT EXISTS `edu_db_company_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_true` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` int(11) DEFAULT NULL,
  `actions` varchar(10) DEFAULT NULL COMMENT '操作方式:订单收入、店家支出、退款支出等',
  `source_id` varchar(32) DEFAULT NULL COMMENT '操作来源的流水号',
  `score` float NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_company_users`
--

DROP TABLE IF EXISTS `edu_db_company_users`;
CREATE TABLE IF NOT EXISTS `edu_db_company_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '1',
  `zone_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `charge` varchar(255) DEFAULT NULL COMMENT 'json 收费',
  `self_sale` tinyint(3) NOT NULL DEFAULT '90' COMMENT '除以100（这个价格是对我们的提成比例）',
  `payment` float DEFAULT '0' COMMENT '累计款项',
  `available_payment` float DEFAULT '0' COMMENT '可用的款项',
  `lng` double NOT NULL,
  `lat` double NOT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_delivery_address`
--

DROP TABLE IF EXISTS `edu_db_delivery_address`;
CREATE TABLE IF NOT EXISTS `edu_db_delivery_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `is_del` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `file_type` varchar(20) DEFAULT '',
  `file_path` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,
  `views_count` int(11) DEFAULT '0',
  `print_count` int(11) DEFAULT '0',
  `score` float DEFAULT '0',
  `score_num` int(11) DEFAULT '0',
  `download_count` int(11) DEFAULT '0',
  `create_pdf` tinyint(1) NOT NULL DEFAULT '0',
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=551 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document_classify`
--

DROP TABLE IF EXISTS `edu_db_document_classify`;
CREATE TABLE IF NOT EXISTS `edu_db_document_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `type` smallint(6) NOT NULL,
  `tag` smallint(6) NOT NULL,
  `intro` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document_comments`
--

DROP TABLE IF EXISTS `edu_db_document_comments`;
CREATE TABLE IF NOT EXISTS `edu_db_document_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `score` tinyint(1) NOT NULL DEFAULT '5',
  `comment_time` datetime DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document_corpus`
--

DROP TABLE IF EXISTS `edu_db_document_corpus`;
CREATE TABLE IF NOT EXISTS `edu_db_document_corpus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `intro` varchar(100) DEFAULT NULL,
  `document_ids` varchar(200) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document_like`
--

DROP TABLE IF EXISTS `edu_db_document_like`;
CREATE TABLE IF NOT EXISTS `edu_db_document_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `operate_id` int(11) NOT NULL,
  `operate_type` tinyint(1) DEFAULT '1' COMMENT '1收藏,2点赞',
  `operate_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_document_tags`
--

DROP TABLE IF EXISTS `edu_db_document_tags`;
CREATE TABLE IF NOT EXISTS `edu_db_document_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL,
  `tag_num` int(11) DEFAULT '1',
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_eligible_refund`
--

DROP TABLE IF EXISTS `edu_db_eligible_refund`;
CREATE TABLE IF NOT EXISTS `edu_db_eligible_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(26) NOT NULL,
  `source` varchar(30) NOT NULL COMMENT '退款原因',
  `message` varchar(200) DEFAULT NULL,
  `images` varchar(30) DEFAULT NULL,
  `apply_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '申请时间',
  `company_receive_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '店家受理时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '受理状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_login_attempts`
--

DROP TABLE IF EXISTS `edu_db_login_attempts`;
CREATE TABLE IF NOT EXISTS `edu_db_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `login` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_order`
--

DROP TABLE IF EXISTS `edu_db_order`;
CREATE TABLE IF NOT EXISTS `edu_db_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(26) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `sum_num` smallint(6) NOT NULL,
  `price` double NOT NULL,
  `sum_page` int(11) NOT NULL DEFAULT '1',
  `info` varchar(255) CHARACTER SET utf8 NOT NULL,
  `remarks` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `state` tinyint(1) DEFAULT '1',
  `place_time` datetime DEFAULT '0000-00-00 00:00:00',
  `payed_time` datetime DEFAULT '0000-00-00 00:00:00',
  `payed_func` tinyint(2) NOT NULL DEFAULT '1' COMMENT '支付方式、加载自配置文件',
  `serial_number` varchar(32) NOT NULL COMMENT '交易流水号',
  `company_receive_time` datetime DEFAULT '0000-00-00 00:00:00',
  `printed_time` datetime DEFAULT '0000-00-00 00:00:00',
  `user_confirm_time` datetime DEFAULT '0000-00-00 00:00:00',
  `receive_money_time` datetime DEFAULT '0000-00-00 00:00:00',
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_payed`
--

DROP TABLE IF EXISTS `edu_db_payed`;
CREATE TABLE IF NOT EXISTS `edu_db_payed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(32) NOT NULL,
  `func` varchar(20) DEFAULT 'alipany' COMMENT '支付方式 如 alipay wechat 银行英文简称等',
  `serial_number` varchar(32) NOT NULL,
  `trade_status` varchar(15) NOT NULL,
  `reback` tinyint(1) DEFAULT '0' COMMENT '是否退款',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_recommend`
--

DROP TABLE IF EXISTS `edu_db_recommend`;
CREATE TABLE IF NOT EXISTS `edu_db_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `func` varchar(10) NOT NULL DEFAULT 'index' COMMENT '推荐方式',
  `source` varchar(15) NOT NULL COMMENT '来源',
  `source_id` int(11) NOT NULL,
  `sorts` smallint(6) NOT NULL DEFAULT '255',
  `site_id` int(11) NOT NULL DEFAULT '1',
  `is_display` tinyint(1) NOT NULL DEFAULT '1',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_resource_acl`
--

DROP TABLE IF EXISTS `edu_db_resource_acl`;
CREATE TABLE IF NOT EXISTS `edu_db_resource_acl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `resource` varchar(100) NOT NULL,
  `action` varchar(32) NOT NULL,
  `roles` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='资源访问控制列表' AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_sites`
--

DROP TABLE IF EXISTS `edu_db_sites`;
CREATE TABLE IF NOT EXISTS `edu_db_sites` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `url` char(64) NOT NULL COMMENT '分站url',
  `unique_key` char(32) NOT NULL COMMENT '分站唯一标识',
  `name` char(32) NOT NULL COMMENT '分站名称',
  `title` varchar(100) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`unique_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分站表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_site_admin`
--

DROP TABLE IF EXISTS `edu_db_site_admin`;
CREATE TABLE IF NOT EXISTS `edu_db_site_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `roles` varchar(255) NOT NULL COMMENT '用户角色',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分站管理员角色表' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_site_roles`
--

DROP TABLE IF EXISTS `edu_db_site_roles`;
CREATE TABLE IF NOT EXISTS `edu_db_site_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `name` char(64) NOT NULL COMMENT '角色名',
  `code` char(64) NOT NULL COMMENT '角色代码',
  `menus` text NOT NULL,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分站管理角色定义' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_tag`
--

DROP TABLE IF EXISTS `edu_db_tag`;
CREATE TABLE IF NOT EXISTS `edu_db_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) CHARACTER SET utf8 NOT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_token`
--

DROP TABLE IF EXISTS `edu_db_token`;
CREATE TABLE IF NOT EXISTS `edu_db_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(64) CHARACTER SET utf8 NOT NULL,
  `access_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_users`
--

DROP TABLE IF EXISTS `edu_db_users`;
CREATE TABLE IF NOT EXISTS `edu_db_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '无',
  `qq` varchar(12) DEFAULT '0',
  `sex` enum('1','0','-1') DEFAULT '-1',
  `introduce` varchar(200) DEFAULT NULL,
  `province` varchar(10) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `province_now` varchar(10) DEFAULT NULL,
  `city_now` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `available_score` int(11) NOT NULL DEFAULT '0' COMMENT '可用积分',
  `deposit` float NOT NULL DEFAULT '0' COMMENT '存款',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `open_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `question_id` int(11) DEFAULT '0',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `email_is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) DEFAULT NULL,
  `new_password_key` varchar(50) DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `activate_email_key` varchar(60) NOT NULL,
  `activate_email_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `new_email` varchar(100) DEFAULT NULL,
  `new_email_key` varchar(50) DEFAULT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_search` tinyint(1) DEFAULT '1',
  `is_del` tinyint(1) DEFAULT '0',
  `user_type` enum('company','ordinary') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_user_actions`
--

DROP TABLE IF EXISTS `edu_db_user_actions`;
CREATE TABLE IF NOT EXISTS `edu_db_user_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(64) NOT NULL COMMENT '动作',
  `score` int(9) NOT NULL DEFAULT '0' COMMENT '积分-，+数',
  `grow` int(9) unsigned NOT NULL DEFAULT '0' COMMENT '成长值',
  `is_usefull` tinyint(1) NOT NULL DEFAULT '1' COMMENT '积分是否起效，1-算入用户积分，0-等待管理员确认',
  `data` varchar(255) NOT NULL DEFAULT '' COMMENT '序列号数据，长度要小于255',
  `ref_table` varchar(50) DEFAULT NULL,
  `ref_table_id` int(9) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分历史记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_user_autologin`
--

DROP TABLE IF EXISTS `edu_db_user_autologin`;
CREATE TABLE IF NOT EXISTS `edu_db_user_autologin` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_user_deposit_msg`
--

DROP TABLE IF EXISTS `edu_db_user_deposit_msg`;
CREATE TABLE IF NOT EXISTS `edu_db_user_deposit_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `actions` varchar(15) DEFAULT 'order' COMMENT '订单收入order、下载收入be_downloaded、消费consume_deposit,消费consume_score,提现reflect',
  `source_id` varchar(20) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  `is_true` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_user_download`
--

DROP TABLE IF EXISTS `edu_db_user_download`;
CREATE TABLE IF NOT EXISTS `edu_db_user_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `download_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_user_profiles`
--

DROP TABLE IF EXISTS `edu_db_user_profiles`;
CREATE TABLE IF NOT EXISTS `edu_db_user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_wechat_hot_key`
--

DROP TABLE IF EXISTS `edu_db_wechat_hot_key`;
CREATE TABLE IF NOT EXISTS `edu_db_wechat_hot_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(20) DEFAULT NULL,
  `open_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_wechat_keyword`
--

DROP TABLE IF EXISTS `edu_db_wechat_keyword`;
CREATE TABLE IF NOT EXISTS `edu_db_wechat_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(20) DEFAULT NULL,
  `intro` varchar(50) DEFAULT NULL,
  `keyword_pinyin` varchar(20) DEFAULT NULL,
  `source` text COMMENT '内容{["title":"2","source":"products","source_id":"3"......,"sort":"255"]}',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edu_db_zones`
--

DROP TABLE IF EXISTS `edu_db_zones`;
CREATE TABLE IF NOT EXISTS `edu_db_zones` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` smallint(4) NOT NULL COMMENT '分站id',
  `p_id` int(9) NOT NULL COMMENT '父级id',
  `path` char(64) NOT NULL COMMENT '分类路径',
  `name` char(64) NOT NULL COMMENT '分类名称',
  `sort_order` int(4) DEFAULT '255' COMMENT '排序，倒序排序',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='城市分站区域表' AUTO_INCREMENT=9 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
