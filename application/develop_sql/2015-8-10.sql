
ALTER TABLE  `edu_db_document` ADD  `swf_file_path` VARCHAR( 255 ) NOT NULL AFTER  `file_path`

CREATE TABLE IF NOT EXISTS `edu_db_document_md5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `md5` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `edu_db_document_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `swf_path` varchar(255) DEFAULT NULL,
  `error_message` varchar(100) NOT NULL,
  `is_clear` tinyint(1) DEFAULT '0' COMMENT '是否清除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

