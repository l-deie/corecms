-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 05 日 09:46
-- 服务器版本: 5.6.10
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `cp_access`
--

DROP TABLE IF EXISTS `cp_access`;
CREATE TABLE IF NOT EXISTS `cp_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id主键',
  `user_group_id` smallint(6) unsigned NOT NULL COMMENT '用户组id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '功能节点id',
  PRIMARY KEY (`id`),
  KEY `groupId` (`user_group_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `cp_access`
--

INSERT INTO `cp_access` (`id`, `user_group_id`, `node_id`) VALUES
(1, 2, 1),
(2, 2, 40),
(3, 2, 30),
(4, 3, 1),
(5, 2, 69),
(6, 2, 50),
(7, 3, 50),
(8, 1, 50),
(9, 3, 7),
(10, 3, 39),
(11, 2, 39),
(12, 2, 49),
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
(23, 1, 1),
(24, 1, 39),
(25, 1, 69),
(26, 1, 30),
(27, 1, 40),
(28, 1, 49),
(29, 3, 69),
(30, 3, 30),
(31, 3, 40),
(32, 1, 37),
(33, 1, 36),
(34, 1, 35),
(35, 1, 34),
(36, 1, 33),
(37, 1, 32),
(38, 1, 31),
(39, 2, 32),
(40, 2, 31),
(41, 7, 1),
(42, 7, 30),
(43, 7, 40),
(44, 7, 69),
(45, 7, 50),
(46, 7, 39),
(47, 7, 49);

-- --------------------------------------------------------

--
-- 表的结构 `cp_node`
--

DROP TABLE IF EXISTS `cp_node`;
CREATE TABLE IF NOT EXISTS `cp_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '节点名称',
  `title` varchar(50) DEFAULT NULL COMMENT '描述说明',
  `sort` smallint(6) unsigned DEFAULT NULL COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父级',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- 转存表中的数据 `cp_node`
--

INSERT INTO `cp_node` (`id`, `name`, `title`, `sort`, `pid`) VALUES
(49, 'read', '查看', NULL, 30),
(40, 'Index', '默认模块', 1, 1),
(39, 'index', '列表', NULL, 30),
(37, 'resume', '恢复', NULL, 30),
(36, 'forbid', '禁用', NULL, 30),
(35, 'foreverdelete', '删除', NULL, 30),
(34, 'update', '更新', NULL, 30),
(33, 'edit', '编辑', NULL, 30),
(32, 'insert', '写入', NULL, 30),
(31, 'add', '新增', NULL, 30),
(30, 'Public', '公共模块', 2, 1),
(69, 'Form', '数据管理', 1, 1),
(7, 'User', '后台用户', 4, 1),
(6, 'Role', '角色管理', 3, 1),
(2, 'Node', '节点管理', 2, 1),
(1, 'App', 'Rbac后台管理', NULL, 0),
(50, 'main', '空白首页', NULL, 40);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
