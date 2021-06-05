-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 02 月 24 日 17:31
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `corecms`
--

-- --------------------------------------------------------

--
-- 表的结构 `cp_access`
--

CREATE TABLE IF NOT EXISTS `cp_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id主键',
  `user_group_id` smallint(6) unsigned NOT NULL COMMENT '用户组id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '功能节点id',
  PRIMARY KEY (`id`),
  KEY `groupId` (`user_group_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组与功能节点对应表' AUTO_INCREMENT=210 ;

--
-- 转存表中的数据 `cp_access`
--

INSERT INTO `cp_access` (`id`, `user_group_id`, `node_id`) VALUES
(208, 2, 2),
(207, 2, 6),
(206, 2, 102),
(63, 3, 33),
(205, 2, 101),
(204, 2, 100),
(62, 3, 35),
(203, 2, 31),
(61, 3, 36),
(60, 3, 37),
(202, 2, 32),
(201, 2, 33),
(13, 4, 1),
(14, 4, 2),
(15, 4, 3),
(16, 4, 4),
(17, 4, 5),
(18, 4, 6),
(19, 4, 7),
(20, 4, 11),
(21, 5, 25),
(22, 5, 51),
(200, 2, 35),
(199, 2, 36),
(198, 2, 37),
(177, 1, 102),
(176, 1, 101),
(175, 1, 100),
(59, 3, 39),
(58, 3, 49),
(57, 3, 50),
(174, 1, 31),
(173, 1, 32),
(172, 1, 33),
(171, 1, 35),
(170, 1, 36),
(169, 1, 37),
(168, 1, 39),
(197, 2, 39),
(196, 2, 49),
(41, 7, 1),
(42, 7, 30),
(43, 7, 40),
(44, 7, 69),
(45, 7, 50),
(46, 7, 39),
(47, 7, 49),
(64, 3, 32),
(65, 3, 31),
(195, 2, 50),
(167, 1, 49),
(166, 1, 50),
(165, 20, 2),
(178, 1, 69),
(179, 1, 7),
(180, 1, 6),
(181, 1, 2),
(182, 1, 86),
(183, 1, 87),
(184, 1, 88),
(185, 1, 89),
(186, 1, 91),
(187, 1, 92),
(188, 1, 93),
(189, 1, 94),
(190, 1, 95),
(191, 1, 96),
(192, 1, 97),
(193, 1, 98),
(194, 1, 99),
(209, 2, 84);

-- --------------------------------------------------------

--
-- 表的结构 `cp_article`
--

CREATE TABLE IF NOT EXISTS `cp_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `title` varchar(80) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `commentnum` int(11) NOT NULL DEFAULT '0',
  `allow` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `recommend` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `cp_article`
--

INSERT INTO `cp_article` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `title`, `keywords`, `description`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `type`) VALUES
(1, 1, 0, '', 1393259998, 1393259998, '简介', '', '', 1, 0, 0, 0, 0, ''),
(2, 1, 0, '', 1393260089, 1393260089, '优势', '', '', 1, 0, 0, 0, 0, ''),
(3, 1, 0, '', 1393260205, 1393260205, '主要业务', '', '', 1, 0, 0, 0, 0, ''),
(4, 2, 0, '', 1393260270, 1393260270, '课程推荐', '', '', 1, 0, 0, 0, 0, ''),
(5, 2, 0, '', 1393260320, 1393260320, '留学办理流程', '', '', 1, 0, 0, 0, 0, ''),
(6, 3, 0, '', 1393260733, 1393260733, '加拿大概述', '', '', 1, 0, 0, 0, 0, ''),
(7, 3, 0, '', 1393260786, 1393260786, '福利与教育', '', '', 1, 0, 0, 0, 0, ''),
(8, 3, 0, '', 1393260840, 1393260840, '行政区域', '', '', 1, 0, 0, 0, 0, ''),
(9, 3, 0, '', 1393260887, 1393260887, '主要省份城市', '', '', 1, 0, 0, 0, 0, ''),
(10, 4, 0, '', 1393258474, 1393258474, '签证及移民', '', '', 1, 0, 0, 0, 0, ''),
(11, 4, 0, '', 1393258483, 1393258483, '签证类别', '', '', 1, 0, 0, 0, 0, ''),
(12, 4, 0, '', 1393258492, 1393258492, '移民项目', '', '', 1, 0, 0, 0, 0, ''),
(13, 4, 0, '', 1393258502, 1393258502, '办理流程服务', '', '', 1, 0, 0, 0, 0, ''),
(14, 4, 0, '', 1393258511, 1393258511, '成功保障', '', '', 1, 0, 0, 0, 0, ''),
(15, 5, 0, '', 1393258530, 1393258530, '亲友支持与国际学生', '', '', 1, 0, 0, 0, 0, ''),
(16, 5, 0, '', 1393258542, 1393258542, '移民类别', '', '', 1, 0, 0, 0, 0, ''),
(17, 5, 0, '', 1393258551, 1393258551, '申请流程', '', '', 1, 0, 0, 0, 0, ''),
(18, 2, 0, '', 1393260460, 1393260460, '温尼伯公立技术学院', '', '', 1, 0, 0, 0, 0, ''),
(19, 2, 0, '', 1393260597, 1393260597, '海外安家服务', '', '', 1, 0, 0, 0, 0, ''),
(20, 2, 0, '', 1393260657, 1393260657, '赴加物品准备清单', '', '', 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_article_content`
--

CREATE TABLE IF NOT EXISTS `cp_article_content` (
  `id` int(11) unsigned NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章内容表';

--
-- 转存表中的数据 `cp_article_content`
--

INSERT INTO `cp_article_content` (`id`, `thumb`, `content`) VALUES
(3, '', '<p><img src="upload/oldimg/zhuyingyewu.jpg"  /></p>'),
(1, '', '<p><img src="upload/oldimg/jianjie.jpg"/></p>'),
(2, '', '<p><img src="upload/oldimg/youshi.jpg"  /></p>'),
(4, '', '<p><img src="upload/oldimg/kechengtuijian.jpg"  /></p>'),
(5, '', '<p><img src="upload/oldimg/liuxuebanliliucheng.jpg"  /></p>'),
(6, '', '<p><img src="upload/oldimg/jianadagaikuang.jpg"  /></p>'),
(7, '', '<p><img src="upload/oldimg/fuliyujiaoyu.jpg"  /></p>'),
(8, '', '<p><img src="upload/oldimg/xingzhengquyuhuafen.jpg"  /></p>'),
(9, '', '<p><img src="upload/oldimg/zhuyaoshengfen.jpg"  /></p>'),
(10, '', '<p><img src="upload/oldimg/qianzhengjiyimin.jpg"  /></p>'),
(11, '', '<p><img src="upload/oldimg/qianzhengleibie.jpg"  /></p>'),
(12, '', '<p><img src="upload/oldimg/yiminxiangmu.jpg"  /></p>'),
(13, '', '<p><img src="upload/oldimg/yiminliucheng.jpg"  /></p>'),
(14, '', '<p><img src="upload/oldimg/chenggongbaozhang.jpg"  /></p>'),
(15, '', '	<p><img src="upload/oldimg/youqing.jpg"  /></p>'),
(16, '', '<p><img src="upload/oldimg/yiminleibie.jpg"  /></p>'),
(17, '', '<p><img src="upload/oldimg/shenqingliucheng.jpg"  /></p>'),
(18, '', '<p><img src="upload/oldimg/gonglixueyuan.jpg"/></p>'),
(19, '', '<p><img src="upload/oldimg/haiwaianjia.jpg"  /></p>'),
(20, '', '<p><img src="upload/oldimg/wupinqingdan.jpg"  /></p>');

-- --------------------------------------------------------

--
-- 表的结构 `cp_banner`
--

CREATE TABLE IF NOT EXISTS `cp_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `title` varchar(80) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `commentnum` int(11) NOT NULL DEFAULT '0',
  `allow` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `recommend` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='单页面表' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `cp_banner`
--

INSERT INTO `cp_banner` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `thumb`, `title`, `keywords`, `description`, `content`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `type`) VALUES
(21, 16, 0, '', 1383120797, 1383120797, 'upload/banner/13831207979710.jpg', 'df', '', '', 'd', 1, 0, 0, 0, 0, ''),
(20, 16, 0, '', 1383120678, 1383120678, 'upload/banner/1383120303325.jpg', 'dfd', '', '', 'ddd', 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_categories`
--

CREATE TABLE IF NOT EXISTS `cp_categories` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) CHARACTER SET gbk NOT NULL,
  `parentid` mediumint(9) NOT NULL,
  `parenttitle` char(50) CHARACTER SET gbk NOT NULL,
  `childid` varchar(250) CHARACTER SET gbk NOT NULL,
  `model` char(50) CHARACTER SET gbk NOT NULL,
  `keywords` varchar(100) CHARACTER SET gbk NOT NULL,
  `description` varchar(200) CHARACTER SET gbk NOT NULL,
  `template` varchar(200) CHARACTER SET gbk NOT NULL COMMENT '列表模板',
  `vtemplate` varchar(200) CHARACTER SET gbk NOT NULL COMMENT '查看模板',
  `orderfield` int(11) NOT NULL DEFAULT '0',
  `viewnum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分类' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `cp_categories`
--

INSERT INTO `cp_categories` (`id`, `title`, `parentid`, `parenttitle`, `childid`, `model`, `keywords`, `description`, `template`, `vtemplate`, `orderfield`, `viewnum`) VALUES
(1, '公司简介', 0, '', '', 'article', '', '', '', '', 0, 0),
(2, '特别推荐', 0, '', '', 'article', '', '', '', '', 0, 0),
(3, '加拿大概况', 0, '', '', 'article', '', '', '', '', 0, 0),
(4, '加拿大移民', 0, '', '', 'article', '', '', '', '', 0, 0),
(5, '曼尼托巴省提名', 0, '', '', 'article', '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cp_group`
--

CREATE TABLE IF NOT EXISTS `cp_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组主键id',
  `name` varchar(255) NOT NULL COMMENT '用户组名称',
  `description` varchar(200) NOT NULL COMMENT '解释描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组表' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `cp_group`
--

INSERT INTO `cp_group` (`id`, `name`, `description`) VALUES
(1, '超级管理员', '-1'),
(2, '商户会员', '2,3,4,5,10,24,25,26,27,14,15,16,17'),
(3, '普通会员', '2,3,4,5,45,63'),
(4, '游客', '2,45,63');

-- --------------------------------------------------------

--
-- 表的结构 `cp_img`
--

CREATE TABLE IF NOT EXISTS `cp_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `savepath` varchar(100) NOT NULL,
  `savename` varchar(40) NOT NULL,
  `description` varchar(250) NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图片附件' AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `cp_img`
--

INSERT INTO `cp_img` (`id`, `uid`, `sid`, `name`, `size`, `ext`, `savepath`, `savename`, `description`, `dateline`) VALUES
(11, 1, 2, '23.jpg', 75971, 'jpg', 'data/article/2012/08/', '53074b9379af46f98684d91e213ed3c7.jpg', '', 1345552264),
(10, 1, 1, '17.jpg', 1003338, 'jpg', 'data/article/2012/08/', '57b56babd4d831a3533c485ba3a4db64.jpg', '', 1345552238),
(9, 1, 71, '1.jpg', 15426, 'jpg', '../data/special/2012/05/', '6c2e64047c327567141ef834b3d08fd7.jpg', '', 1337136955),
(12, 1, 1, 'psb.jpg', 114021, 'jpg', 'data/article/2012/08/', '8375749111667737fe53d256b81811e6.jpg', '', 1345553490),
(13, 1, 3, 'psb.jpg', 114021, 'jpg', 'data/article/2012/08/', 'f4f8351d4ad55a2c83db4e473e6ed256.jpg', '', 1345553525),
(14, 1, 3, 'pinpai.jpg', 33526, 'jpg', 'data/article/2012/08/', 'd5473915dfc92a8401eee0e8e462abb2.jpg', '', 1345553777),
(15, 1, 6, 'pinpai.jpg', 33526, 'jpg', 'data/article/2012/08/', '68b40946d13b39649f9a99816fe18b6d.jpg', '', 1345556867),
(16, 1, 6, 'pinpai.jpg', 33526, 'jpg', 'data/article/2012/08/', '7e714909ba5f88579ea28dfbb1ec780b.jpg', '', 1345557030),
(17, 1, 7, 'anli.jpg', 35133, 'jpg', 'data/article/2012/08/', '1c6a62309425c8edf0ea12c6aac7a4de.jpg', '', 1345557073),
(18, 1, 8, 'anli.jpg', 35133, 'jpg', 'data/article/2012/08/', 'acc5dd829b74e86c1a415c11559243d4.jpg', '', 1345557480),
(19, 1, 11, 'pinpai.jpg', 33526, 'jpg', 'data/article/2012/08/', 'd2529fdd7b5f138433c6ec5476b30e57.jpg', '', 1345559682);

-- --------------------------------------------------------

--
-- 表的结构 `cp_member`
--

CREATE TABLE IF NOT EXISTS `cp_member` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id 主键',
  `username` char(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `regip` char(15) NOT NULL DEFAULT '' COMMENT '注册ip',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lastloginip` char(15) NOT NULL DEFAULT '0' COMMENT '最后登陆ip',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `salt` char(6) NOT NULL COMMENT '加密密钥',
  `usergroup` int(11) NOT NULL COMMENT '用户组',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `cp_member`
--

INSERT INTO `cp_member` (`uid`, `username`, `password`, `email`, `regip`, `regdate`, `lastloginip`, `lastlogintime`, `salt`, `usergroup`) VALUES
(8, 'shooke', '7fb5b8f5bece51d840bbc1c1333c896a', 'dfsd@32123.dsf', '127.0.0.1', 1346294733, '127.0.0.1', 1346294733, '70POzz', 1),
(10, 'test', '872127ac261d7be72db4f88ce3c61083', 'dfsd@31.dfff', '127.0.0.1', 1346387122, '127.0.0.1', 1346387122, 'J0QJZE', 2),
(1, 'admin', 'c4dc0d3b5af9c18aeeb9bb5561a35392', 'admin@admin.com', '127.0.0.1', 1321327262, '127.0.0.1', 1321327262, 'IqAmgV', 1),
(17, 'test2', '1403bf65b656f06e9344446c97105a7c', 'dfd', '127.0.0.1', 1374065705, '127.0.0.1', 1374065705, 'HayoMD', 2),
(18, 'uuu', '29af230702cf40ebe2211d79b5406d7e', '', '127.0.0.1', 1376536964, '127.0.0.1', 1376536964, 'AutUYQ', 1);

-- --------------------------------------------------------

--
-- 表的结构 `cp_member_field`
--

CREATE TABLE IF NOT EXISTS `cp_member_field` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id 主键',
  `shop` varchar(200) DEFAULT '' COMMENT '门店',
  `name` varchar(32) DEFAULT '' COMMENT '真实姓名',
  `phone` varchar(15) DEFAULT '' COMMENT '电话',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `qq` varchar(11) DEFAULT '' COMMENT 'QQ',
  `address` varchar(200) DEFAULT '' COMMENT '居住地址',
  `company_address` varchar(200) DEFAULT '' COMMENT '公司地址',
  `company` varchar(100) DEFAULT NULL COMMENT '公司名称',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户扩展资料表' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `cp_member_field`
--

INSERT INTO `cp_member_field` (`uid`, `shop`, `name`, `phone`, `mobile`, `qq`, `address`, `company_address`, `company`) VALUES
(8, 'shooke', '舒克', '15963100710', '127.0.0.1', '1346294733', '似的发生地方', '1346294733', '70POzz'),
(10, 'test', '老张', '15963100710', '127.0.0.1', '1346387122', '的发送到发送到', '1346387122', 'J0QJZE'),
(1, 'admin', '老李', '82828282', '127.0.0.1', '1321327262', '师傅水电费', '1321327262', '01wfwZ'),
(17, '', '地方', 'dfd', 'd', '', '', '', ''),
(18, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_node`
--

CREATE TABLE IF NOT EXISTS `cp_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '节点名称',
  `title` varchar(50) DEFAULT NULL COMMENT '描述说明',
  `sort` smallint(6) unsigned DEFAULT NULL COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父级',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '添加栏目时是否显示 0不显示 1显示',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='功能操作节点' AUTO_INCREMENT=110 ;

--
-- 转存表中的数据 `cp_node`
--

INSERT INTO `cp_node` (`id`, `name`, `title`, `sort`, `pid`, `type`) VALUES
(1, 'admin', '后台管理', NULL, 0, 0),
(109, 'banner', '广告管理', 0, 1, 1),
(108, 'shejishi', '设计师', 0, 1, 1),
(107, 'sheji', '设计作品', 3, 1, 1),
(106, 'onepage', '单页面', 2, 1, 1),
(105, 'article', '文章模块', 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cp_onepage`
--

CREATE TABLE IF NOT EXISTS `cp_onepage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `title` varchar(80) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `commentnum` int(11) NOT NULL DEFAULT '0',
  `allow` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `recommend` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='单页面表' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `cp_onepage`
--

INSERT INTO `cp_onepage` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `thumb`, `title`, `keywords`, `description`, `content`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `type`) VALUES
(11, 11, 1, '', 1381916631, 1382099366, '', '关于黑树', '', '', '<p><span>黑树工作室是一家专注设计集企业形象设计、平面设计、网站设计、插话设计建设于一体的品牌整合服务机构。</span><br/>\r\n &nbsp; &nbsp; &nbsp;倡导&quot;设计能动品牌，设计盈造价值&quot;的价值观，我们注重商业与设计间的目标结合，更注重自身素养的修炼及孕育。在关注纷繁复杂与日趋多元化市场需求的同时，审时度势，顺势而为，积极倡导高品质的品牌形象传播成果呈现。将与高瞻远瞩者共谋品牌未来。</p><p><img src="template/cms/images/abouttu.jpg"  alt="" width="757" height="226" /><br/>\r\n &nbsp; &nbsp; &nbsp;核心价值：设计能动品牌，品牌盈造价值。</p><p>我们不虚夸自己的本领，不骄傲于自己的成绩，不止步于自己的能力。<br/>\r\n &nbsp; &nbsp; &nbsp;以小博大的逗号精神一直指引我们朝着更高，更强的梦想前进着。<br/>\r\n &nbsp; &nbsp; &nbsp;我们会把我们的激情，梦想注入我们的工作中，使每件作品都栩栩如生。<br/>\r\n &nbsp; &nbsp; &nbsp;我们是您品牌策略中的帮手，您成功路上的垫脚石。<br/>\r\n &nbsp; &nbsp; &nbsp;坚定，认真，努力，热爱，这就是我们的品格。<br/>\r\n &nbsp; &nbsp;专注设计，清空杂念。因专注，更专业！</p>', 1, 0, 0, 0, 0, ''),
(10, 10, 1, '', 1381916820, 1382099623, '', '项目服务', '', '', '<p><img src="template/cms/images/fuw.jpg"  width="998" height="561" /></p>', 1, 0, 0, 0, 0, ''),
(14, 14, 1, '', 1381931402, 1382099838, '', '联系我们', '', '', '<table width="979" height="57" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><span>黑树工作室</span><br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;hitree.cn<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;公司地址 :济南市槐荫区纬十二路191号<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;业务电话 :15254188517<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;电子邮件 : 1051560760@qq.com<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;在线咨询 : QQ:1051560760<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp;新浪微博 :http://weibo.com/u/1739041655</td><td>For International Business:<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Company address: jinan HuaiYinOu weft 12 road no. 191<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Phone：15254188517<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;E-mail: 1051560760.cn<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;QQ:1051560760<br/>\r\n &nbsp; &nbsp; &nbsp; &nbsp;Weibo: http://weibo.com/u/1739041655&nbsp;</td></tr></tbody></table>', 1, 0, 0, 0, 0, ''),
(15, 15, 1, '', 1381931404, 1382100606, '', '付款方式', '', '', '<p><img src="template/cms/images/fuki.jpg"  width="1000" height="210" />&nbsp;</p>', 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_sheji`
--

CREATE TABLE IF NOT EXISTS `cp_sheji` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `title` varchar(80) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `commentnum` int(11) NOT NULL DEFAULT '0',
  `allow` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `recommend` int(11) NOT NULL DEFAULT '0',
  `createtime` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `cp_sheji`
--

INSERT INTO `cp_sheji` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `title`, `thumb`, `keywords`, `description`, `content`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `createtime`) VALUES
(33, 12, 0, '速度', 1382104000, 0, '水电费', 'upload/2013/10/13819282136846.jpg', '画册设计', '水电费', '<p>水电费是否&nbsp;</p><p><img src="upload/20131018/13821039028429.jpg"  width="172" _src="http://localhost/corecms/upload/20131018/13821039028429.jpg" height="172" style="/" /></p><p><img src="upload/20131018/13821039049645.jpg"  width="171" _src="http://localhost/corecms/upload/20131018/13821039049645.jpg" height="15" style="/" /></p><p><img src="upload/20131018/13821039298021.jpg"  _src="http://localhost/corecms/upload/20131018/13821039298021.jpg" width="642" height="454" /></p>', 1, 0, 0, 0, 0, '啊啊'),
(32, 12, 0, '小桃子', 1382105296, 0, '水电费', 'upload/2013/10/13819281903535.jpg', 'web', '', '<p>发给<img src="upload/20131016/13819262851374.jpg"  _src="http://localhost/corecms/upload/20131016/13819262851374.jpg" width="797" height="100" /></p>', 1, 0, 0, 0, 0, '2012-11-11');

-- --------------------------------------------------------

--
-- 表的结构 `cp_shejishi`
--

CREATE TABLE IF NOT EXISTS `cp_shejishi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `title` varchar(80) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `commentnum` int(11) NOT NULL DEFAULT '0',
  `allow` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `recommend` int(11) NOT NULL DEFAULT '0',
  `createtime` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `cp_shejishi`
--

INSERT INTO `cp_shejishi` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `title`, `thumb`, `keywords`, `description`, `content`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `createtime`) VALUES
(35, 13, 0, '', 1382105382, 0, '小桃子', 'upload/2013/10/13819289717130.jpg', 'web', '水电费', '<p><span style="line-height: 1.8;">姓名：小桃子</span></p><p><span style="line-height: 1.8;">擅长：网页，平面，画册,logo</span></p><p>从事设计工作4年</p><p>毕业于山东省工艺美术学院，爱生活，喜欢动物，狗狗，有一颗童心</p><p>设计网站多达百十余个，涉及到各行各业。</p>', 1, 0, 0, 0, 0, ''),
(33, 13, 0, '', 1381929081, 0, '小桃子', 'upload/2013/10/13819290816276.jpg', '', 'sdfsd', '<p>工作4年了快速减肥了速度范围哦ihogisdfg</p>', 1, 0, 0, 0, 0, ''),
(34, 13, 0, '', 1381928511, 0, '速度', 'upload/2013/10/13819285116884.jpg', '', '水电费速度', '<p>胜多负少士大夫似的</p>', 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_site`
--

CREATE TABLE IF NOT EXISTS `cp_site` (
  `title` varchar(80) NOT NULL,
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL DEFAULT '',
  `personality` varchar(200) NOT NULL DEFAULT '',
  `icp` char(20) NOT NULL DEFAULT '',
  `tj` varchar(200) NOT NULL DEFAULT '',
  `salt` char(6) NOT NULL,
  PRIMARY KEY (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cp_site`
--

INSERT INTO `cp_site` (`title`, `keywords`, `description`, `email`, `personality`, `icp`, `tj`, `salt`) VALUES
('cms', '加华国际咨询中心', '加华国际咨询中心', 'fengzi945@hotmail.com', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
