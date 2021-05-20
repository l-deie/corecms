-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 08 月 21 日 14:57
-- 服务器版本: 5.0.77
-- PHP 版本: 5.2.9-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cp`
--

-- --------------------------------------------------------

--
-- 表的结构 `cp_article`
--

CREATE TABLE IF NOT EXISTS `cp_article` (
  `id` int(11) unsigned NOT NULL,
  `thumb` varchar(200) character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `cp_article`
--

INSERT INTO `cp_article` (`id`, `thumb`, `content`) VALUES
(1, 'data/article/2012/08/8375749111667737fe53d256b81811e6.jpg', '随碟附送地方撒旦法士大夫似的'),
(3, 'data/article/2012/08/d5473915dfc92a8401eee0e8e462abb2.jpg', '的萨芬是大方撒地方撒旦的萨芬是大方撒地方撒旦的萨芬是大方撒地方撒旦的萨芬是大方撒地方撒旦'),
(2, 'data/article/2012/08/53074b9379af46f98684d91e213ed3c7.jpg', '随碟附送地方撒旦法发郭德纲'),
(4, '', '按时大法师打发士大夫士大夫'),
(6, 'data/article/2012/08/7e714909ba5f88579ea28dfbb1ec780b.jpg', '所到发送到发送到发送到发送到发生大'),
(7, 'data/article/2012/08/1c6a62309425c8edf0ea12c6aac7a4de.jpg', '撒旦发送到发送到发生的发送到发都是'),
(8, 'data/article/2012/08/acc5dd829b74e86c1a415c11559243d4.jpg', 'ssdfsdfsdfsdfsdfs'),
(11, 'data/article/2012/08/d2529fdd7b5f138433c6ec5476b30e57.jpg', '松岛枫松岛枫上的封锁石凳');

-- --------------------------------------------------------

--
-- 表的结构 `cp_categories`
--

CREATE TABLE IF NOT EXISTS `cp_categories` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` char(50) NOT NULL,
  `parentid` mediumint(9) NOT NULL,
  `parenttitle` char(50) NOT NULL,
  `childid` varchar(250) NOT NULL,
  `model` char(50) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `template` varchar(200) NOT NULL COMMENT '列表模板',
  `vtemplate` varchar(200) NOT NULL COMMENT '查看模板',
  `orderfield` int(11) NOT NULL default '0',
  `viewnum` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `cp_categories`
--

INSERT INTO `cp_categories` (`id`, `title`, `parentid`, `parenttitle`, `childid`, `model`, `keywords`, `description`, `template`, `vtemplate`, `orderfield`, `viewnum`) VALUES
(1, '关于DOWN', 0, '', '', 'special', '', '', '', '', 1, 0),
(2, '作品展示', 0, '', '', 'article', '', '', 'zuopin', 'show', 2, 0),
(3, '服务优势', 0, '', '', 'special', '', '', '', '', 3, 0),
(4, '合作客户', 0, '', '', 'article', '', '', 'kehu', 'show', 5, 0),
(5, '合作流程', 0, '', '', 'special', '', '', '', '', 4, 0),
(6, '联系我们', 0, '', '', 'special', '', '', '', '', 6, 0),
(7, '实际案例', 0, '', '', 'article', '', '', 'zuopin', 'show', 7, 0),
(8, '服务品牌', 0, '', '', 'article', '', '', '', 'show', 8, 0),
(9, '最新动态', 0, '', '', 'article', '', '', '', 'show', 9, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cp_comment`
--

CREATE TABLE IF NOT EXISTS `cp_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `uid` mediumint(9) NOT NULL,
  `username` varchar(20) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `parentid` int(11) NOT NULL,
  `content` varchar(140) NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `cp_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `cp_group`
--

CREATE TABLE IF NOT EXISTS `cp_group` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `power_value` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 导出表中的数据 `cp_group`
--

INSERT INTO `cp_group` (`id`, `name`, `power_value`) VALUES
(1, '超级管理员', '-1'),
(2, '普通管理员', '2,3,4,5,10,24,25,26,27,14,15,16,17'),
(3, '普通会员', '2,3,4,5,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,63'),
(4, '游客', '2,45,63');

-- --------------------------------------------------------

--
-- 表的结构 `cp_img`
--

CREATE TABLE IF NOT EXISTS `cp_img` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `name` varchar(100) character set utf8 NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) character set utf8 NOT NULL,
  `savepath` varchar(100) character set utf8 NOT NULL,
  `savename` varchar(40) character set utf8 NOT NULL,
  `description` varchar(250) character set utf8 NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- 导出表中的数据 `cp_img`
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
  `uid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` char(15) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `email` char(32) NOT NULL default '',
  `regip` char(15) NOT NULL default '',
  `regdate` int(10) unsigned NOT NULL default '0',
  `lastloginip` char(15) NOT NULL default '0',
  `lastlogintime` int(10) unsigned NOT NULL default '0',
  `salt` char(6) NOT NULL,
  `usergroup` int(11) NOT NULL,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 导出表中的数据 `cp_member`
--

INSERT INTO `cp_member` (`uid`, `username`, `password`, `email`, `regip`, `regdate`, `lastloginip`, `lastlogintime`, `salt`, `usergroup`) VALUES
(1, 'admin', 'a54e87e4eb45e8b2fbcea1cdeb4e9746', 'admin@admin.com', '127.0.0.1', 1321327262, '127.0.0.1', 1321327262, '01wfwZ', 1);

-- --------------------------------------------------------

--
-- 表的结构 `cp_mytag`
--

CREATE TABLE IF NOT EXISTS `cp_mytag` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `tagname` varchar(50) character set utf8 NOT NULL COMMENT 'tag name',
  `nums` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `cp_mytag`
--

INSERT INTO `cp_mytag` (`id`, `uid`, `tagname`, `nums`) VALUES
(1, 1, '', 12);

-- --------------------------------------------------------

--
-- 表的结构 `cp_resource`
--

CREATE TABLE IF NOT EXISTS `cp_resource` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL,
  `operate` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- 导出表中的数据 `cp_resource`
--

INSERT INTO `cp_resource` (`id`, `pid`, `operate`, `name`, `display`) VALUES
(1, 0, 'article', '文章模块', 1),
(2, 1, 'index', '文章列表', 0),
(3, 1, 'add', '文章增加', 0),
(4, 1, 'edit', '文章修改', 0),
(5, 1, 'del', '文章删除', 0),
(45, 1, 'show', '文章浏览', 0),
(62, 0, 'comment', '评论模块', 0),
(63, 62, 'add', '添加评论', 0),
(67, 0, 'special', '单页面模块', 1),
(68, 67, 'show', '查看', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cp_site`
--

CREATE TABLE IF NOT EXISTS `cp_site` (
  `title` varchar(80) NOT NULL,
  `keywords` varchar(100) NOT NULL default '',
  `description` varchar(200) NOT NULL default '',
  `email` char(32) NOT NULL default '',
  `personality` varchar(200) NOT NULL default '',
  `icp` char(20) NOT NULL default '',
  `tj` varchar(200) NOT NULL default '',
  `salt` char(6) NOT NULL,
  PRIMARY KEY  (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `cp_site`
--

INSERT INTO `cp_site` (`title`, `keywords`, `description`, `email`, `personality`, `icp`, `tj`, `salt`) VALUES
('cms', '加华国际咨询中心', '加华国际咨询中心', 'fengzi945@hotmail.com', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cp_special`
--

CREATE TABLE IF NOT EXISTS `cp_special` (
  `id` int(11) unsigned NOT NULL,
  `thumb` varchar(200) character set utf8 NOT NULL,
  `time` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `content` text character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `cp_special`
--

INSERT INTO `cp_special` (`id`, `thumb`, `time`, `city`, `address`, `content`) VALUES
(5, '', '', '', '', '<div class="title">关于DOWN</div>        <div class="cc">DOWIN东文传媒——您身边最好的品牌传播机构东文传媒是一家以商业思维发现盈利，以战略态度发现价值、以形象方式呈现价值、以实效营销传播价值，帮助客户实现盈利模式构建，建立长期品牌价值，提升品牌立体竞争力的品牌营销服务机构。主要服务范围包括：市场研究、品牌设计规划、产品设计规划、广告创意、营销推广等。公司围绕品牌轴心，通过VI视觉规划、策划创意、广告制作、公众形象策划、顾客关系、终端形象设计等加以全线整合，将统一清晰的资讯传播给消费者，为客户获得长期的品牌竞争优势。以“定位”为中心，“消费者盘中盘和渠道盘中盘” 为两个基本点。运用打造品类的方法开发新产品，并且用新产品成功创建新品牌。我们相信“定位打造新品”是当前众多企业突破营销瓶颈最现实和最实效的方法。中国制造走遍世界，而中国品牌却寥寥无几，东文传媒将用定位理论聚焦于品类的打造，为中国本土企业创建强势品牌而努力。</div><div class="title">DOWN理念</div>        <div class="cc">东文传媒鲜明的提出“生活者”理论，强调营销首先要把受众作为“生活的人”，而不要当成是购买产品<br />的“购物机器”。东文传媒认为在营销中应该遵循这样一个原则：不是卖产品，而是满足需求。<br />营销必须建立在对生活者生活状态的深刻理解上：了解生活者的需求点，是创新产品的指导，了解生活<br />者的兴趣点，是创作广告的指导，了解生活者的接触点是影响顾客的指导。</div><div class="title">DOWN架构</div>        <div class="cc"><img src="template/images/jiagou.jpg" alt="" /><br /></div>'),
(9, '', '', '', '', '<div style="margin-bottom:20px">      DOWIN是立足于视觉传达设计，传播品牌价值，做360°品牌策划，无论是平面媒体还是影视媒体，无论是室内传播媒介还是户外传播媒介，只要找到我们，一站式服务到底！      logo（标志）、CI（企业识别系统）、VI（视觉识别系统）、画册、包装、海报、样本、宣传册，企业专题片，品牌专刊、户外广告等，只要是您能想到的，我们都能做到，真正的广告领域全能冠军！</div><div class="title">服务优势</div>        <div class="cc"><img src="template/images/jiagou.jpg" alt="" /><br /></div>'),
(10, '', '', '', '', '<div class="title">合作流程</div><div class="cc"><img src="http://127.0.0.1/template/images/jiagou.jpg" alt="" /></div>'),
(12, '', '', '', '', '<div class="title">联系我们</div><div class="cc">地址：济南市清河北路1号<br />邮箱：dowindesign@163.com<br />客服QQ:84580414<br />联系电话：13356665862 &nbsp; 15318815808</div>');

-- --------------------------------------------------------

--
-- 表的结构 `cp_subject`
--

CREATE TABLE IF NOT EXISTS `cp_subject` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `author` char(15) character set utf8 NOT NULL,
  `dateline` int(11) NOT NULL,
  `editdate` int(10) NOT NULL,
  `title` varchar(80) character set utf8 NOT NULL,
  `keywords` varchar(100) character set utf8 NOT NULL,
  `description` varchar(200) character set utf8 NOT NULL,
  `viewnum` int(11) NOT NULL default '1',
  `commentnum` int(11) NOT NULL default '0',
  `allow` int(11) NOT NULL default '0',
  `top` int(11) NOT NULL default '0',
  `recommend` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `authorid` (`authorid`,`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `cp_subject`
--

INSERT INTO `cp_subject` (`id`, `cid`, `authorid`, `author`, `dateline`, `editdate`, `title`, `keywords`, `description`, `viewnum`, `commentnum`, `allow`, `top`, `recommend`, `type`) VALUES
(1, 7, 1, 'admin', 1345552238, 1345553490, '地方发撒旦法撒旦法', '', '', 1, 0, 0, 0, 0, 'article'),
(2, 7, 1, 'admin', 1345552264, 1345552264, '啊随碟附送地方撒旦法', '', '', 7, 0, 0, 0, 0, 'article'),
(3, 8, 1, 'admin', 1345553525, 1345553777, '的萨芬是大方撒地方撒旦', '', '', 4, 0, 0, 0, 0, 'article'),
(4, 9, 1, 'admin', 1345553926, 1345553926, '最新动态', '', '', 1, 0, 0, 0, 0, 'article'),
(5, 1, 1, 'admin', 1345554341, 1345555349, '关于DOWN', '', '', 1, 0, 0, 0, 0, 'special'),
(6, 2, 1, 'admin', 1345556867, 1345557030, '到发三发撒旦法撒旦法', '', '', 1, 0, 0, 0, 0, 'article'),
(7, 2, 1, 'admin', 1345557073, 1345557073, '按时大法师打发', '', '', 2, 0, 0, 0, 0, 'article'),
(8, 2, 1, 'admin', 1345557480, 1345557480, '松岛枫松岛枫上的发松岛枫', '', '', 1, 0, 0, 0, 0, 'article'),
(9, 3, 1, 'admin', 1345558206, 1345558473, '服务优势', '', '', 1, 0, 0, 0, 0, 'special'),
(10, 5, 1, 'admin', 1345558893, 1345559170, '合作流程', '', '', 1, 0, 0, 0, 0, 'special'),
(11, 4, 1, 'admin', 1345559682, 1345559682, '撒旦冯绍峰', '', '', 1, 0, 0, 0, 0, 'article'),
(12, 6, 1, 'admin', 1345559957, 1345559957, '联系我们', '', '', 1, 0, 0, 0, 0, 'special');

-- --------------------------------------------------------

--
-- 表的结构 `cp_tagc`
--

CREATE TABLE IF NOT EXISTS `cp_tagc` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sid` int(11) NOT NULL COMMENT '主题id',
  `tagname` varchar(50) character set utf8 NOT NULL COMMENT 'tag name',
  `model` varchar(50) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sid` (`sid`,`tagname`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `cp_tagc`
--


-- --------------------------------------------------------

--
-- 表的结构 `cp_tags`
--

CREATE TABLE IF NOT EXISTS `cp_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) character set utf8 NOT NULL,
  `nums` int(11) NOT NULL default '0' COMMENT '统计',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `cp_tags`
--


-- --------------------------------------------------------

--
-- 表的结构 `cp_temp`
--

CREATE TABLE IF NOT EXISTS `cp_temp` (
  `uid` int(11) NOT NULL,
  `imgid` varchar(200) NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `cp_temp`
--

