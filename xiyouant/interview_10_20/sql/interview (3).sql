-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-10-20 18:42:40
-- 服务器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `interview`
--

-- --------------------------------------------------------

--
-- 表的结构 `interview`
--

CREATE TABLE IF NOT EXISTS `interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `judges_id` int(11) DEFAULT NULL COMMENT '默认值为附一，标示无评委',
  `group_attitude` int(11) DEFAULT '0',
  `interview_attitude` int(11) DEFAULT '0',
  `life_attitude` int(11) DEFAULT '0',
  `base_knowledge` int(11) DEFAULT '0',
  `direction_knowledge` int(11) DEFAULT '0',
  `comment` varchar(200) DEFAULT NULL,
  `end_status` int(11) DEFAULT '0' COMMENT '12 一面一结束\n13　一面结束\n16 二面结束\n\n表示评分所属于的面试阶段',
  `score` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_interview_judges_idx` (`judges_id`),
  KEY `fk_interview_player1_idx` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentid` varchar(45) NOT NULL,
  `status` int(11) NOT NULL COMMENT '3 一面一等待\n4 一面一中\n10 一面二等待\n11 一面二中\n12 一面一结束\n13  一面结束\n16 　二面结束\n17 　　　所有的面试结束状态\n14 　等待(所有等待的状态)',
  `interview_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_job_interview1_idx` (`interview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `judge`
--

CREATE TABLE IF NOT EXISTS `judge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `direction` int(11) NOT NULL COMMENT '1 安全组\n2 web\n3  技术运营',
  `member_id` int(11) DEFAULT NULL COMMENT '0 为队长权限\n其它为队员\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentid` varchar(45) NOT NULL,
  `old` int(11) NOT NULL,
  `new` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `gender` varchar(10) NOT NULL COMMENT '性别',
  `studentid` varchar(45) NOT NULL,
  `grade` varchar(45) NOT NULL,
  `class` varchar(45) NOT NULL,
  `tel` varchar(45) NOT NULL,
  `direction` int(11) NOT NULL COMMENT '报哪个小组0 root1 安全组 2 web 3 技术运营 4 视觉设计',
  `status` int(11) NOT NULL COMMENT '1  报名 2 签到  3 一面一等待 4 一面一进行 5 一面一结束 6 一面二等待 7 一面二进行 8 一面结束 9  二面等待 10 二面进行 11 二面结束 12 一面通过 13 一面未通过 14 二面通过 15 二面未通过',
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentid_UNIQUE` (`studentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=158 ;

--
-- 转存表中的数据 `player`
--

INSERT INTO `player` (`id`, `name`, `gender`, `studentid`, `grade`, `class`, `tel`, `direction`, `status`) VALUES
(94, '王大锤', '男', '04131092', '15', '计科1303', '13201851975', 1, 1),
(95, '王大锤', '男', '04132222', '14', '计科1301', '13201851975', 1, 1),
(96, '李大花', '女', '05131099', '14', '计科1301', '13201851975', 3, 1),
(97, '王大锤', '男', '04125856', '15', '计科1303', '13201851975', 1, 4),
(108, '张玉坤', '男', '04138888', '15', '计科1301', '18829291558', 1, 1),
(109, '王立涛', '男', '05121456', '15', '计科1303', '13201851975', 1, 1),
(110, 'Tony stark', '男', '05131025', '15', '软件 1503', '18943389891', 2, 15),
(111, '张大贺', '男', '05132015', '15', '计科1401', '13201851975', 1, 1),
(112, '王大锤', '男', '00123698', '15', '计科1303', '13201851975', 1, 1),
(113, '王大锤', '男', '05236987', '15', '计科1303', '18829291558', 1, 1),
(114, '王大锤', '男', '04159875', '15', '计科1301', '13201851975', 1, 1),
(115, '王大锤', '男', '05241025', '15', '计科1303', '13201851975', 1, 1),
(116, '王丽坤', '男', '05120214', '14', '计科1401', '13201851975', 2, 1),
(147, '邱宇翰', '男', '04523698', '15', '计科1303', '13201851978', 1, 1),
(150, '江宏', '男', '08987415', '15', '计科1303', '13201851978', 1, 1),
(151, 'gggg', '男', 'ggggg', '15', 'ggggg', 'ggggg', 1, 1),
(152, 'Leo', '男', '05163896', '15', '软件1501', '13208856932', 2, 1),
(153, '王大锤', '男', '09131094', '15', '计科1301', '13201851978', 1, 1),
(154, '王丽坤', '男', '05552598', '14', '计科1303', '18829291558', 1, 1),
(155, '曲向轩', '男', '03125698', '15', '计科1303', '18829291558', 1, 1),
(156, '王大锤', '男', '04139999', '15', '计科1303', '18829291558', 1, 1),
(157, '4rtyy', '男', '09876789', '15', 'tgtt', '13201851975', 1, 1);

--
-- 限制导出的表
--

--
-- 限制表 `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `fk_interview_judges` FOREIGN KEY (`judges_id`) REFERENCES `judge` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_interview_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `fk_job_interview1` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
