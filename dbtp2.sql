/*
Navicat MySQL Data Transfer

Source Server         : RFsql
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : dbtp2

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-04-20 23:56:00
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `bidang_divisi`
-- ----------------------------
DROP TABLE IF EXISTS `bidang_divisi`;
CREATE TABLE `bidang_divisi` (
  `id_bidang` int(16) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(64) NOT NULL,
  `id_divisi` int(16) NOT NULL,
  PRIMARY KEY (`id_bidang`),
  KEY `divisi` (`id_divisi`),
  CONSTRAINT `divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bidang_divisi
-- ----------------------------
INSERT INTO `bidang_divisi` VALUES ('2', 'DPS', '2');
INSERT INTO `bidang_divisi` VALUES ('3', 'Waifu', '3');

-- ----------------------------
-- Table structure for `divisi`
-- ----------------------------
DROP TABLE IF EXISTS `divisi`;
CREATE TABLE `divisi` (
  `id_divisi` int(16) NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(32) NOT NULL,
  PRIMARY KEY (`id_divisi`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of divisi
-- ----------------------------
INSERT INTO `divisi` VALUES ('2', 'Genshin');
INSERT INTO `divisi` VALUES ('3', 'Anime');

-- ----------------------------
-- Table structure for `pengurus`
-- ----------------------------
DROP TABLE IF EXISTS `pengurus`;
CREATE TABLE `pengurus` (
  `id_pengurus` int(16) NOT NULL AUTO_INCREMENT,
  `nim` varchar(16) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `semester` varchar(16) NOT NULL,
  `id_bidang` int(16) NOT NULL,
  `img` varchar(32) NOT NULL,
  PRIMARY KEY (`id_pengurus`),
  KEY `bidang` (`id_bidang`),
  CONSTRAINT `bidang` FOREIGN KEY (`id_bidang`) REFERENCES `bidang_divisi` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pengurus
-- ----------------------------
INSERT INTO `pengurus` VALUES ('5', '2001', 'Hu Tao', '4', '2', 'source/Hu-Tao.png');
INSERT INTO `pengurus` VALUES ('6', '2002', 'Unmei', '5', '3', 'source/Unmei.jpg');
INSERT INTO `pengurus` VALUES ('8', '20003', 'Luminous Valentine', '4', '3', 'source/luminous.jpg');
INSERT INTO `pengurus` VALUES ('9', '20004', 'Heaven', '5', '3', 'source/heaven.jpg');
INSERT INTO `pengurus` VALUES ('10', '20005', 'Ueno', '3', '3', 'source/ueno.jpg');
