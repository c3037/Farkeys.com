/*
Navicat MySQL Data Transfer

Source Server         : UpComCMS Base2
Source Server Version : 50541
Source Host           : 82.146.39.94:3333
Source Database       : dmitryqr_base2

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-05-11 21:34:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fkid` int(11) NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hashdate` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `usemc` tinyint(1) NOT NULL,
  `mc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'ZGltYW45MzAwQG1haWwucnU=', '1f4a04e5543d8760660bb080226040b987b88d47', '1', '', '0', '0', '0', '');
INSERT INTO `users` VALUES ('4', 'ZGltYW45MzAwQG1haWwucnU=', '258019518cc6e5b2b526043786eb0971721bbbbf', '0', '', '0', '1365969212', '0', '');
INSERT INTO `users` VALUES ('2', 'RkhGR0g=', '60294cbf4b44349500f9fc353aea04d54a9596de', '0', '', '0', '1359457330', '0', '');
INSERT INTO `users` VALUES ('3', '0YPQstGD0LLRg9Cy0YPQstGD', '1d40257f9ee185593e7c7e607742c104820c79d7', '0', '', '0', '1359740181', '0', '');
INSERT INTO `users` VALUES ('5', 'MDA3bmVzaEBtYWlsLnJ1', '3c368518aa4d657a277f60619d2155f9de8d7fc6', '0', 'bd9b7e6e31d1cff122f94607740b75a48447897b', '1373222672', '1373222538', '0', '');
INSERT INTO `users` VALUES ('6', 'ZW1haWxAZGltYXNtaXJub3YucnU=', 'b20f18d5052ace8974d7305a12eabad87e33cceb', '0', '', '0', '1378201989', '0', '');
INSERT INTO `users` VALUES ('7', 'ZWVl', '20c94baaa2841770a2588b7a491797b2047844ce', '0', '', '0', '1431022224', '0', '');
INSERT INTO `users` VALUES ('8', 'cnJy', '49f4a4994d4db53122e58b9da2a1da2dece9557a', '0', '', '0', '1431024309', '0', '');
