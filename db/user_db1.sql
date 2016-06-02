/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : user_db1

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-06-02 11:41:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user_table0`
-- ----------------------------
DROP TABLE IF EXISTS `user_table0`;
CREATE TABLE `user_table0` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table0
-- ----------------------------

-- ----------------------------
-- Table structure for `user_table1`
-- ----------------------------
DROP TABLE IF EXISTS `user_table1`;
CREATE TABLE `user_table1` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table1
-- ----------------------------
INSERT INTO `user_table1` VALUES ('71', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table1` VALUES ('101', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table1` VALUES ('111', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `user_table2`
-- ----------------------------
DROP TABLE IF EXISTS `user_table2`;
CREATE TABLE `user_table2` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table2
-- ----------------------------

-- ----------------------------
-- Table structure for `user_table3`
-- ----------------------------
DROP TABLE IF EXISTS `user_table3`;
CREATE TABLE `user_table3` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table3
-- ----------------------------
INSERT INTO `user_table3` VALUES ('63', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table3` VALUES ('73', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table3` VALUES ('113', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `user_table4`
-- ----------------------------
DROP TABLE IF EXISTS `user_table4`;
CREATE TABLE `user_table4` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table4
-- ----------------------------

-- ----------------------------
-- Table structure for `user_table5`
-- ----------------------------
DROP TABLE IF EXISTS `user_table5`;
CREATE TABLE `user_table5` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table5
-- ----------------------------
INSERT INTO `user_table5` VALUES ('65', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table5` VALUES ('75', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table5` VALUES ('115', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `user_table6`
-- ----------------------------
DROP TABLE IF EXISTS `user_table6`;
CREATE TABLE `user_table6` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table6
-- ----------------------------

-- ----------------------------
-- Table structure for `user_table7`
-- ----------------------------
DROP TABLE IF EXISTS `user_table7`;
CREATE TABLE `user_table7` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table7
-- ----------------------------
INSERT INTO `user_table7` VALUES ('67', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table7` VALUES ('77', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table7` VALUES ('107', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `user_table8`
-- ----------------------------
DROP TABLE IF EXISTS `user_table8`;
CREATE TABLE `user_table8` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table8
-- ----------------------------

-- ----------------------------
-- Table structure for `user_table9`
-- ----------------------------
DROP TABLE IF EXISTS `user_table9`;
CREATE TABLE `user_table9` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_table9
-- ----------------------------
INSERT INTO `user_table9` VALUES ('69', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table9` VALUES ('79', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `user_table9` VALUES ('109', 'paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
