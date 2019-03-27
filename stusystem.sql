/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : stusystem

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-08 19:50:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `cno` varchar(10) NOT NULL,
  `cname` varchar(15) DEFAULT NULL,
  `credit` float(3,1) DEFAULT NULL,
  PRIMARY KEY (`cno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('CS1001', '数据结构', '3.5');
INSERT INTO `course` VALUES ('CS1002', 'C++程序设计', '2.5');
INSERT INTO `course` VALUES ('CS1011', '集合论与图论', '2.0');
INSERT INTO `course` VALUES ('CS2001', 'Java语言程序设计', '2.5');
INSERT INTO `course` VALUES ('CS2002', '计算机网络', '3.0');
INSERT INTO `course` VALUES ('CS2005', '计算机组成原理', '1.5');
INSERT INTO `course` VALUES ('CS3001', '数据库系统概论', '3.5');
INSERT INTO `course` VALUES ('CS3002', '操作系统', '3.5');
INSERT INTO `course` VALUES ('CS3003', '计算机系统安全', '2.5');
INSERT INTO `course` VALUES ('CS3006', '计算机体系结构', '3.0');
INSERT INTO `course` VALUES ('CS3007', '软件工程', '3.0');
INSERT INTO `course` VALUES ('CS3008', '计算机图形学', '3.0');
INSERT INTO `course` VALUES ('CS3011', '密码学基础', '2.0');
INSERT INTO `course` VALUES ('CS3012', '计算机系统安全', '2.5');
INSERT INTO `course` VALUES ('CS3021', '软件开发与实践1', '2.0');
INSERT INTO `course` VALUES ('CS3022', '软件开发与实践2', '2.0');
INSERT INTO `course` VALUES ('CS4001', '人工智能导论', '2.5');
INSERT INTO `course` VALUES ('CS4002', '计算机毕业设计', '14.0');
INSERT INTO `course` VALUES ('CS4003', '信息安全毕业设计', '14.0');
INSERT INTO `course` VALUES ('CS4004', '网络空间安全毕业设计', '14.0');
INSERT INTO `course` VALUES ('CS4005', '软件工程毕业设计', '14.0');
INSERT INTO `course` VALUES ('IS2001', '数字逻辑设计', '4.0');
INSERT INTO `course` VALUES ('LX1001', '大学物理A', '4.5');
INSERT INTO `course` VALUES ('SC1001', 'C语言程序设计', '3.0');
INSERT INTO `course` VALUES ('SX1001', '工科数学分析', '5.0');
INSERT INTO `course` VALUES ('SX1002', '代数与几何', '3.5');
INSERT INTO `course` VALUES ('SX2004', '数理逻辑', '2.0');
INSERT INTO `course` VALUES ('YY1001', '大学英语', '1.5');

-- ----------------------------
-- Table structure for dept
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `dno` varchar(5) NOT NULL,
  `dname` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`dno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dept
-- ----------------------------
INSERT INTO `dept` VALUES ('010', '计算机科学与技术');
INSERT INTO `dept` VALUES ('020', '经济管理');
INSERT INTO `dept` VALUES ('030', '理学');
INSERT INTO `dept` VALUES ('040', '海洋科学与技术');
INSERT INTO `dept` VALUES ('050', '信息科学与工程');
INSERT INTO `dept` VALUES ('060', '汽车工程');

-- ----------------------------
-- Table structure for login
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `user` varchar(10) NOT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('admin1', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `login` VALUES ('admin2', '098f6bcd4621d373cade4e832627b4f6');

-- ----------------------------
-- Table structure for major
-- ----------------------------
DROP TABLE IF EXISTS `major`;
CREATE TABLE `major` (
  `mno` varchar(5) NOT NULL,
  `dno` varchar(5) DEFAULT NULL,
  `mname` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`mno`),
  KEY `dno` (`dno`),
  CONSTRAINT `major_ibfk_1` FOREIGN KEY (`dno`) REFERENCES `dept` (`dno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of major
-- ----------------------------
INSERT INTO `major` VALUES ('011', '010', '计算机科学与技术');
INSERT INTO `major` VALUES ('012', '010', '信息安全');
INSERT INTO `major` VALUES ('013', '010', '网络空间安全');
INSERT INTO `major` VALUES ('014', '010', '软件工程');
INSERT INTO `major` VALUES ('021', '020', '信息管理与信息系统');
INSERT INTO `major` VALUES ('022', '020', '会计学');
INSERT INTO `major` VALUES ('031', '030', '数学与应用数学');
INSERT INTO `major` VALUES ('032', '030', '信息与计算科学');
INSERT INTO `major` VALUES ('041', '040', '生物工程');
INSERT INTO `major` VALUES ('051', '050', '通信工程');
INSERT INTO `major` VALUES ('061', '060', '车辆工程');

-- ----------------------------
-- Table structure for mc
-- ----------------------------
DROP TABLE IF EXISTS `mc`;
CREATE TABLE `mc` (
  `mno` varchar(5) NOT NULL,
  `cno` varchar(10) NOT NULL,
  `semester` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`mno`,`cno`),
  KEY `cno` (`cno`),
  CONSTRAINT `mc_ibfk_2` FOREIGN KEY (`cno`) REFERENCES `course` (`cno`),
  CONSTRAINT `mc_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `major` (`mno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mc
-- ----------------------------
INSERT INTO `mc` VALUES ('011', 'CS1002', '2');
INSERT INTO `mc` VALUES ('011', 'CS1011', '2');
INSERT INTO `mc` VALUES ('011', 'CS2001', '3');
INSERT INTO `mc` VALUES ('011', 'CS2005', '4');
INSERT INTO `mc` VALUES ('011', 'CS3001', '5');
INSERT INTO `mc` VALUES ('011', 'CS3002', '5');
INSERT INTO `mc` VALUES ('011', 'CS3006', '6');
INSERT INTO `mc` VALUES ('011', 'CS3007', '6');
INSERT INTO `mc` VALUES ('011', 'CS3008', '5');
INSERT INTO `mc` VALUES ('011', 'CS3021', '3');
INSERT INTO `mc` VALUES ('011', 'CS3022', '4');
INSERT INTO `mc` VALUES ('011', 'CS4001', '7');
INSERT INTO `mc` VALUES ('011', 'CS4002', '8');
INSERT INTO `mc` VALUES ('011', 'IS2001', '3');
INSERT INTO `mc` VALUES ('011', 'LX1001', '2');
INSERT INTO `mc` VALUES ('011', 'SC1001', '1');
INSERT INTO `mc` VALUES ('011', 'SX1001', '1');
INSERT INTO `mc` VALUES ('011', 'SX1002', '1');
INSERT INTO `mc` VALUES ('011', 'SX2004', '4');
INSERT INTO `mc` VALUES ('011', 'YY1001', '1');
INSERT INTO `mc` VALUES ('012', 'CS1002', '2');
INSERT INTO `mc` VALUES ('012', 'CS1011', '2');
INSERT INTO `mc` VALUES ('012', 'CS2001', '3');
INSERT INTO `mc` VALUES ('012', 'CS2002', '3');
INSERT INTO `mc` VALUES ('012', 'CS2005', '4');
INSERT INTO `mc` VALUES ('012', 'CS3001', '5');
INSERT INTO `mc` VALUES ('012', 'CS3002', '5');
INSERT INTO `mc` VALUES ('012', 'CS3007', '6');
INSERT INTO `mc` VALUES ('012', 'CS3011', '5');
INSERT INTO `mc` VALUES ('012', 'CS3012', '6');
INSERT INTO `mc` VALUES ('012', 'CS3021', '5');
INSERT INTO `mc` VALUES ('012', 'CS4001', '7');
INSERT INTO `mc` VALUES ('012', 'CS4003', '8');
INSERT INTO `mc` VALUES ('012', 'IS2001', '3');
INSERT INTO `mc` VALUES ('012', 'LX1001', '2');
INSERT INTO `mc` VALUES ('012', 'SC1001', '1');
INSERT INTO `mc` VALUES ('012', 'SX1001', '1');
INSERT INTO `mc` VALUES ('012', 'SX1002', '1');
INSERT INTO `mc` VALUES ('012', 'YY1001', '1');
INSERT INTO `mc` VALUES ('013', 'YY1001', '1');
INSERT INTO `mc` VALUES ('014', 'YY1001', '1');
INSERT INTO `mc` VALUES ('021', 'SX1001', '1');
INSERT INTO `mc` VALUES ('021', 'YY1001', '1');
INSERT INTO `mc` VALUES ('022', 'YY1001', '1');
INSERT INTO `mc` VALUES ('031', 'YY1001', '1');
INSERT INTO `mc` VALUES ('032', 'YY1001', '1');
INSERT INTO `mc` VALUES ('041', 'YY1001', '1');
INSERT INTO `mc` VALUES ('051', 'YY1001', '1');
INSERT INTO `mc` VALUES ('061', 'YY1001', '1');

-- ----------------------------
-- Table structure for sc
-- ----------------------------
DROP TABLE IF EXISTS `sc`;
CREATE TABLE `sc` (
  `sno` varchar(10) NOT NULL,
  `cno` varchar(10) NOT NULL,
  `grade` tinyint(4) DEFAULT NULL,
  `semester` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sno`,`cno`),
  KEY `cno` (`cno`),
  CONSTRAINT `sc_ibfk_2` FOREIGN KEY (`cno`) REFERENCES `course` (`cno`),
  CONSTRAINT `sc_ibfk_1` FOREIGN KEY (`sno`) REFERENCES `student` (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sc
-- ----------------------------
INSERT INTO `sc` VALUES ('160110101', 'CS1002', '74', '2');
INSERT INTO `sc` VALUES ('160110101', 'CS1011', '86', '2');
INSERT INTO `sc` VALUES ('160110101', 'CS2001', '54', '3');
INSERT INTO `sc` VALUES ('160110101', 'CS2005', '57', '4');
INSERT INTO `sc` VALUES ('160110101', 'CS3001', '75', '5');
INSERT INTO `sc` VALUES ('160110101', 'CS3002', '78', '5');
INSERT INTO `sc` VALUES ('160110101', 'CS3006', '67', '6');
INSERT INTO `sc` VALUES ('160110101', 'CS3007', '57', '6');
INSERT INTO `sc` VALUES ('160110101', 'CS3008', '88', '5');
INSERT INTO `sc` VALUES ('160110101', 'CS3021', '60', '3');
INSERT INTO `sc` VALUES ('160110101', 'CS3022', '50', '4');
INSERT INTO `sc` VALUES ('160110101', 'CS4001', '60', '7');
INSERT INTO `sc` VALUES ('160110101', 'CS4002', '57', '8');
INSERT INTO `sc` VALUES ('160110101', 'IS2001', '79', '3');
INSERT INTO `sc` VALUES ('160110101', 'LX1001', '68', '2');
INSERT INTO `sc` VALUES ('160110101', 'SC1001', '86', '1');
INSERT INTO `sc` VALUES ('160110101', 'SX1001', '71', '1');
INSERT INTO `sc` VALUES ('160110101', 'SX1002', '58', '1');
INSERT INTO `sc` VALUES ('160110101', 'SX2004', '78', '4');
INSERT INTO `sc` VALUES ('160110101', 'YY1001', '74', '1');
INSERT INTO `sc` VALUES ('160110102', 'CS1002', '87', '2');
INSERT INTO `sc` VALUES ('160110102', 'CS1011', '68', '2');
INSERT INTO `sc` VALUES ('160110102', 'CS2001', '88', '3');
INSERT INTO `sc` VALUES ('160110102', 'CS2005', '79', '4');
INSERT INTO `sc` VALUES ('160110102', 'CS3001', '89', '5');
INSERT INTO `sc` VALUES ('160110102', 'CS3002', '95', '5');
INSERT INTO `sc` VALUES ('160110102', 'CS3006', '96', '6');
INSERT INTO `sc` VALUES ('160110102', 'CS3007', '75', '6');
INSERT INTO `sc` VALUES ('160110102', 'CS3008', '75', '5');
INSERT INTO `sc` VALUES ('160110102', 'CS3021', '86', '3');
INSERT INTO `sc` VALUES ('160110102', 'CS3022', '93', '4');
INSERT INTO `sc` VALUES ('160110102', 'CS4001', '83', '7');
INSERT INTO `sc` VALUES ('160110102', 'CS4002', '88', '8');
INSERT INTO `sc` VALUES ('160110102', 'IS2001', '92', '3');
INSERT INTO `sc` VALUES ('160110102', 'LX1001', '86', '2');
INSERT INTO `sc` VALUES ('160110102', 'SC1001', '68', '1');
INSERT INTO `sc` VALUES ('160110102', 'SX1001', '88', '1');
INSERT INTO `sc` VALUES ('160110102', 'SX1002', '94', '1');
INSERT INTO `sc` VALUES ('160110102', 'SX2004', '90', '4');
INSERT INTO `sc` VALUES ('160110102', 'YY1001', '78', '1');
INSERT INTO `sc` VALUES ('160110103', 'CS1002', '85', '2');
INSERT INTO `sc` VALUES ('160110103', 'CS1011', '67', '2');
INSERT INTO `sc` VALUES ('160110103', 'CS2001', '78', '3');
INSERT INTO `sc` VALUES ('160110103', 'CS2005', '98', '4');
INSERT INTO `sc` VALUES ('160110103', 'CS3001', '87', '5');
INSERT INTO `sc` VALUES ('160110103', 'CS3002', '90', '5');
INSERT INTO `sc` VALUES ('160110103', 'CS3006', '85', '6');
INSERT INTO `sc` VALUES ('160110103', 'CS3007', '71', '6');
INSERT INTO `sc` VALUES ('160110103', 'CS3008', '73', '5');
INSERT INTO `sc` VALUES ('160110103', 'CS3021', '80', '3');
INSERT INTO `sc` VALUES ('160110103', 'CS3022', '78', '4');
INSERT INTO `sc` VALUES ('160110103', 'CS4001', '85', '7');
INSERT INTO `sc` VALUES ('160110103', 'CS4002', '80', '8');
INSERT INTO `sc` VALUES ('160110103', 'IS2001', '96', '3');
INSERT INTO `sc` VALUES ('160110103', 'LX1001', '86', '2');
INSERT INTO `sc` VALUES ('160110103', 'SC1001', '79', '1');
INSERT INTO `sc` VALUES ('160110103', 'SX1001', '86', '1');
INSERT INTO `sc` VALUES ('160110103', 'SX1002', '78', '1');
INSERT INTO `sc` VALUES ('160110103', 'SX2004', '68', '4');
INSERT INTO `sc` VALUES ('160110103', 'YY1001', '91', '1');
INSERT INTO `sc` VALUES ('160110201', 'CS1002', '78', '2');
INSERT INTO `sc` VALUES ('160110201', 'CS1011', '86', '2');
INSERT INTO `sc` VALUES ('160110201', 'CS2001', '98', '3');
INSERT INTO `sc` VALUES ('160110201', 'CS2005', '77', '4');
INSERT INTO `sc` VALUES ('160110201', 'CS3001', '74', '5');
INSERT INTO `sc` VALUES ('160110201', 'CS3002', '69', '5');
INSERT INTO `sc` VALUES ('160110201', 'CS3006', '82', '6');
INSERT INTO `sc` VALUES ('160110201', 'CS3007', '86', '6');
INSERT INTO `sc` VALUES ('160110201', 'CS3008', '88', '5');
INSERT INTO `sc` VALUES ('160110201', 'CS3021', '76', '3');
INSERT INTO `sc` VALUES ('160110201', 'CS3022', '79', '4');
INSERT INTO `sc` VALUES ('160110201', 'CS4001', '74', '7');
INSERT INTO `sc` VALUES ('160110201', 'CS4002', '77', '8');
INSERT INTO `sc` VALUES ('160110201', 'IS2001', '79', '3');
INSERT INTO `sc` VALUES ('160110201', 'LX1001', '88', '2');
INSERT INTO `sc` VALUES ('160110201', 'SC1001', '94', '1');
INSERT INTO `sc` VALUES ('160110201', 'SX1001', '87', '1');
INSERT INTO `sc` VALUES ('160110201', 'SX1002', '77', '1');
INSERT INTO `sc` VALUES ('160110201', 'SX2004', '71', '4');
INSERT INTO `sc` VALUES ('160110201', 'YY1001', '83', '1');
INSERT INTO `sc` VALUES ('160120101', 'CS1002', '78', '2');
INSERT INTO `sc` VALUES ('160120101', 'CS1011', '57', '2');
INSERT INTO `sc` VALUES ('160120101', 'CS2001', '89', '3');
INSERT INTO `sc` VALUES ('160120101', 'CS2002', '81', '3');
INSERT INTO `sc` VALUES ('160120101', 'CS2005', '80', '4');
INSERT INTO `sc` VALUES ('160120101', 'CS3001', '86', '5');
INSERT INTO `sc` VALUES ('160120101', 'CS3002', '92', '5');
INSERT INTO `sc` VALUES ('160120101', 'CS3007', '89', '6');
INSERT INTO `sc` VALUES ('160120101', 'CS3011', '86', '5');
INSERT INTO `sc` VALUES ('160120101', 'CS3012', '93', '6');
INSERT INTO `sc` VALUES ('160120101', 'CS3021', '90', '5');
INSERT INTO `sc` VALUES ('160120101', 'CS4001', '90', '7');
INSERT INTO `sc` VALUES ('160120101', 'CS4003', '89', '8');
INSERT INTO `sc` VALUES ('160120101', 'IS2001', '69', '3');
INSERT INTO `sc` VALUES ('160120101', 'LX1001', '80', '2');
INSERT INTO `sc` VALUES ('160120101', 'SC1001', '88', '1');
INSERT INTO `sc` VALUES ('160120101', 'SX1001', '85', '1');
INSERT INTO `sc` VALUES ('160120101', 'SX1002', '70', '1');
INSERT INTO `sc` VALUES ('160120101', 'YY1001', '77', '1');
INSERT INTO `sc` VALUES ('170110101', 'CS1002', '87', '2');
INSERT INTO `sc` VALUES ('170110101', 'CS1011', '80', '2');
INSERT INTO `sc` VALUES ('170110101', 'CS2001', '64', '3');
INSERT INTO `sc` VALUES ('170110101', 'CS2005', '62', '4');
INSERT INTO `sc` VALUES ('170110101', 'CS3001', '82', '5');
INSERT INTO `sc` VALUES ('170110101', 'CS3002', '86', '5');
INSERT INTO `sc` VALUES ('170110101', 'CS3006', '89', '6');
INSERT INTO `sc` VALUES ('170110101', 'CS3007', '71', '6');
INSERT INTO `sc` VALUES ('170110101', 'CS3008', '76', '5');
INSERT INTO `sc` VALUES ('170110101', 'CS3021', '80', '3');
INSERT INTO `sc` VALUES ('170110101', 'CS3022', '80', '4');
INSERT INTO `sc` VALUES ('170110101', 'CS4001', null, '7');
INSERT INTO `sc` VALUES ('170110101', 'CS4002', null, '8');
INSERT INTO `sc` VALUES ('170110101', 'IS2001', '76', '3');
INSERT INTO `sc` VALUES ('170110101', 'LX1001', '82', '2');
INSERT INTO `sc` VALUES ('170110101', 'SC1001', '75', '1');
INSERT INTO `sc` VALUES ('170110101', 'SX1001', '77', '1');
INSERT INTO `sc` VALUES ('170110101', 'SX1002', '69', '1');
INSERT INTO `sc` VALUES ('170110101', 'SX2004', '83', '4');
INSERT INTO `sc` VALUES ('170110101', 'YY1001', '73', '1');
INSERT INTO `sc` VALUES ('170110102', 'CS1002', '95', '2');
INSERT INTO `sc` VALUES ('170110102', 'CS1011', '97', '2');
INSERT INTO `sc` VALUES ('170110102', 'CS2001', '90', '3');
INSERT INTO `sc` VALUES ('170110102', 'CS2005', '91', '4');
INSERT INTO `sc` VALUES ('170110102', 'CS3001', '85', '5');
INSERT INTO `sc` VALUES ('170110102', 'CS3002', '96', '5');
INSERT INTO `sc` VALUES ('170110102', 'CS3006', '90', '6');
INSERT INTO `sc` VALUES ('170110102', 'CS3007', '88', '6');
INSERT INTO `sc` VALUES ('170110102', 'CS3008', '87', '5');
INSERT INTO `sc` VALUES ('170110102', 'CS3021', '91', '3');
INSERT INTO `sc` VALUES ('170110102', 'CS3022', '92', '4');
INSERT INTO `sc` VALUES ('170110102', 'CS4001', null, '7');
INSERT INTO `sc` VALUES ('170110102', 'CS4002', null, '8');
INSERT INTO `sc` VALUES ('170110102', 'IS2001', '97', '3');
INSERT INTO `sc` VALUES ('170110102', 'LX1001', '83', '2');
INSERT INTO `sc` VALUES ('170110102', 'SC1001', '86', '1');
INSERT INTO `sc` VALUES ('170110102', 'SX1001', '98', '1');
INSERT INTO `sc` VALUES ('170110102', 'SX1002', '88', '1');
INSERT INTO `sc` VALUES ('170110102', 'SX2004', '98', '4');
INSERT INTO `sc` VALUES ('170110102', 'YY1001', '90', '1');
INSERT INTO `sc` VALUES ('180110101', 'CS1002', '98', '2');
INSERT INTO `sc` VALUES ('180110101', 'CS1011', '89', '2');
INSERT INTO `sc` VALUES ('180110101', 'CS2001', '87', '3');
INSERT INTO `sc` VALUES ('180110101', 'CS2005', '90', '4');
INSERT INTO `sc` VALUES ('180110101', 'CS3001', null, '5');
INSERT INTO `sc` VALUES ('180110101', 'CS3002', null, '5');
INSERT INTO `sc` VALUES ('180110101', 'CS3006', null, '6');
INSERT INTO `sc` VALUES ('180110101', 'CS3007', null, '6');
INSERT INTO `sc` VALUES ('180110101', 'CS3008', null, '5');
INSERT INTO `sc` VALUES ('180110101', 'CS3021', '91', '3');
INSERT INTO `sc` VALUES ('180110101', 'CS3022', '93', '4');
INSERT INTO `sc` VALUES ('180110101', 'CS4001', null, '7');
INSERT INTO `sc` VALUES ('180110101', 'CS4002', null, '8');
INSERT INTO `sc` VALUES ('180110101', 'IS2001', '96', '3');
INSERT INTO `sc` VALUES ('180110101', 'LX1001', '96', '2');
INSERT INTO `sc` VALUES ('180110101', 'SC1001', '87', '1');
INSERT INTO `sc` VALUES ('180110101', 'SX1001', '97', '1');
INSERT INTO `sc` VALUES ('180110101', 'SX1002', '89', '1');
INSERT INTO `sc` VALUES ('180110101', 'SX2004', '87', '4');
INSERT INTO `sc` VALUES ('180110101', 'YY1001', '87', '1');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `sno` varchar(10) NOT NULL,
  `sname` varchar(8) DEFAULT NULL,
  `ssex` varchar(2) DEFAULT NULL,
  `sage` tinyint(4) DEFAULT NULL,
  `dno` varchar(5) DEFAULT NULL,
  `mno` varchar(5) DEFAULT NULL,
  `sclass` varchar(10) DEFAULT NULL,
  `saddr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `dno` (`dno`),
  KEY `mno` (`mno`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`mno`) REFERENCES `major` (`mno`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`dno`) REFERENCES `dept` (`dno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('160110101', '张三', '男', '19', '010', '011', '1601101', '山东省威海市环翠区');
INSERT INTO `student` VALUES ('160110102', '李四', '男', '19', '010', '011', '1601101', '河北省石家庄市藁城区');
INSERT INTO `student` VALUES ('160110103', '李欣然', '女', '20', '010', '011', '1601101', '福建省厦门市思明区');
INSERT INTO `student` VALUES ('160110201', '张佳丽', '女', '20', '010', '011', '1601102', '江苏省徐州市贾汪区');
INSERT INTO `student` VALUES ('160120101', '孟晨', '男', '21', '010', '012', '1601201', '北京市海淀区');
INSERT INTO `student` VALUES ('170110101', '柳晓峰', '男', '19', '010', '011', '1701101', '辽宁省大连市金州区');
INSERT INTO `student` VALUES ('170110102', '马文倩', '女', '19', '010', '011', '1701101', '山东省济南市槐荫区');
INSERT INTO `student` VALUES ('180110101', '王林山', '男', '18', '010', '011', '1801101', '山东省潍坊市奎文区');

-- ----------------------------
-- View structure for stucredit
-- ----------------------------
DROP VIEW IF EXISTS `stucredit`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `stucredit` AS select `stucregra`.`sno` AS `sno`,sum(`stucregra`.`credit`) AS `earncredit` from `stucregra` where (`stucregra`.`grade` >= 60) group by `stucregra`.`sno` ;

-- ----------------------------
-- View structure for stucregra
-- ----------------------------
DROP VIEW IF EXISTS `stucregra`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `stucregra` AS select `sc`.`sno` AS `sno`,`sc`.`grade` AS `grade`,`course`.`credit` AS `credit`,`sc`.`semester` AS `semester` from (`sc` join `course`) where ((`sc`.`cno` = `course`.`cno`) and (`sc`.`grade` is not null)) ;

-- ----------------------------
-- View structure for studmname
-- ----------------------------
DROP VIEW IF EXISTS `studmname`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `studmname` AS select `s`.`sno` AS `sno`,`s`.`sname` AS `sname`,`s`.`sclass` AS `sclass`,`m`.`mname` AS `mname`,`d`.`dname` AS `dname` from ((`student` `s` join `major` `m`) join `dept` `d`) where ((`s`.`mno` = `m`.`mno`) and (`s`.`dno` = `d`.`dno`)) ;

-- ----------------------------
-- View structure for stugrade
-- ----------------------------
DROP VIEW IF EXISTS `stugrade`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `stugrade` AS select `s`.`sno` AS `sno`,`s`.`sname` AS `sname`,`s`.`sclass` AS `sclass`,`s`.`mno` AS `mno`,`m`.`mname` AS `mname`,`c`.`cno` AS `cno`,`c`.`cname` AS `cname`,`sc`.`grade` AS `grade`,`sc`.`semester` AS `semester` from (((`student` `s` join `major` `m`) join `course` `c`) join `sc`) where ((`s`.`mno` = `m`.`mno`) and (`s`.`sno` = `sc`.`sno`) and (`c`.`cno` = `sc`.`cno`)) ;

-- ----------------------------
-- View structure for stuwgrade1
-- ----------------------------
DROP VIEW IF EXISTS `stuwgrade1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `stuwgrade1` AS select `stucregra`.`sno` AS `sno`,`stucregra`.`semester` AS `semester`,(sum((`stucregra`.`grade` * `stucregra`.`credit`)) / sum(`stucregra`.`credit`)) AS `wgrade` from `stucregra` group by `stucregra`.`sno`,`stucregra`.`semester` ;

-- ----------------------------
-- View structure for stuwgrade2
-- ----------------------------
DROP VIEW IF EXISTS `stuwgrade2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `stuwgrade2` AS select `stucregra`.`sno` AS `sno`,(sum((`stucregra`.`grade` * `stucregra`.`credit`)) / sum(`stucregra`.`credit`)) AS `wgrade` from `stucregra` group by `stucregra`.`sno` ;
