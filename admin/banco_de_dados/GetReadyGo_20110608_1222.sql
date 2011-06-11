DROP TABLE IF EXISTS `tb_post_pageview`;
CREATE TABLE `tb_post_pageview` (
  `post_id` bigint(20) unsigned NOT NULL,
  `categoria_id` int(10) unsigned NOT NULL,
  `post_dt_pageview` date NOT NULL,
  `post_ip_pageview` varchar(18) NOT NULL,
  PRIMARY KEY (`post_id`,`categoria_id`,`post_dt_pageview`,`post_ip_pageview`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='totalizador de pageviews';

