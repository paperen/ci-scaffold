-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 24 日 01:37
-- 服务器版本: 5.5.24
-- PHP 版本: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_group`
--

CREATE TABLE IF NOT EXISTS `admin_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `admin_group`
--

INSERT INTO `admin_group` (`group_id`, `group_name`, `group_description`, `created`, `modified`, `status`) VALUES
(1, '超级管理员', '超级管理员', 1339036432, 1354873967, 1),
(2, '管理员', '管理员', 1337332484, 1339479193, 1),
(3, '操作员', '最基本的操作人员', 1338777956, 1338777956, 1),
(4, '测试123', '仅供测试', 1353667213, 1354172669, 1),
(5, '仅供paperen使用', '仅供paperen使用', 1354610220, 0, 1),
(6, '测试43423', '33', 1354843730, 0, 1),
(7, '信息录入员', '只能用来添加信息', 1354847717, 0, 1),
(8, '测试', '测试', 1354848908, 0, 1),
(9, '信息查看员', '只有对信息进行查看的权限', 1354849294, 0, 1),
(10, '145', '1', 1354861325, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(30) NOT NULL COMMENT '帐号',
  `password` char(32) NOT NULL COMMENT '密码',
  `salt` char(6) NOT NULL COMMENT '密钥',
  `addtime` int(10) NOT NULL COMMENT '创建时间',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `state` enum('lock','normal') NOT NULL COMMENT '状态',
  `isadmin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是管理员',
  `coin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `state` (`state`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='user' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `addtime`, `email`, `state`, `isadmin`, `coin`) VALUES
(2, 'paperen', '89b9de5a100a163c805cd27b8f0d5ba4', 'a57f54', 1347184636, 'paperen@gmail.com', 'normal', 0, 5),
(3, 'admin', 'f9783b1ab056d32b36777276a25b4789', '74d1fe', 1347184667, 'admin@gmail.com', 'normal', 1, 0),
(4, 'test', '89b9de5a100a163c805cd27b8f0d5ba4', 'a57f54', 0, 'test@gmail.com', 'lock', 0, 0),
(5, 'father3', '35afa8c384f53ab42b5b8aca74f7252d', '38652d', 1355239321, NULL, 'normal', 0, 0);