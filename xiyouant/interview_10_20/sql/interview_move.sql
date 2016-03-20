-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-10-20 18:43:23
-- 服务器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `interview_move`
--

-- --------------------------------------------------------

--
-- 表的结构 `interview`
--

CREATE TABLE IF NOT EXISTS `interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `judge_id` int(11) DEFAULT '0',
  `interview_status` varchar(45) NOT NULL,
  `group_attitude` int(11) DEFAULT '0',
  `interview_attitude` int(11) DEFAULT '0',
  `life_attitude` int(11) DEFAULT '0',
  `base_knowledge` int(11) DEFAULT '0',
  `direction_knowledge` int(11) DEFAULT '0',
  `comment` varchar(200) DEFAULT NULL,
  `score` float DEFAULT '0',
  `flag` varchar(100) DEFAULT NULL COMMENT '用于插入后，返回 找到 id ',
  PRIMARY KEY (`id`),
  KEY `fk_interview_player1_idx` (`player_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `interview`
--

INSERT INTO `interview` (`id`, `player_id`, `judge_id`, `interview_status`, `group_attitude`, `interview_attitude`, `life_attitude`, `base_knowledge`, `direction_knowledge`, `comment`, `score`, `flag`) VALUES
(23, 26, 12, '5', 3, 3, 3, 3, 3, '123', 15, '261444745094'),
(24, 27, 12, '5', 1, 11, 1, 1, 1, '213', 15, '271444745100'),
(25, 28, 12, '5', 1, 1, 1, 1, 1, '123', 5, '281444745108'),
(26, 29, 12, '5', 1, 1, 1, 1, 1, '', 5, '291444745119'),
(27, 30, 12, '5', 1, 1, 1, 1, 1, '21', 5, '301444745127'),
(28, 31, 12, '5', 2, 2, 2, 2, 2, '21', 10, '311444745138'),
(29, 26, 12, '8', 2, 2, 2, 2, 2, '213', 10, '261444745193'),
(30, 27, 12, '8', 2, 2, 2, 2, 2, '2', 10, '271444745260'),
(31, 28, 12, '8', 2, 2, 2, 2, 2, '2', 10, '281444745278'),
(32, 29, 12, '8', 2, 2, 2, 2, 2, '123', 10, '291444745294'),
(33, 30, 12, '7', 0, 0, 0, 0, 0, '', 0, '301444745313'),
(34, 31, 12, '7', 0, 0, 0, 0, 0, '', 0, '311444745330'),
(35, 26, 12, '10', 0, 0, 0, 0, 0, '', 0, '261444745439'),
(36, 27, 0, '9', 0, 0, 0, 0, 0, NULL, 0, '271444745447'),
(37, 28, 0, '9', 0, 0, 0, 0, 0, NULL, 0, '281444745457'),
(38, 32, 12, '5', 2, 2, 2, 2, 2, 'test for interviewing', 10, '321444745546'),
(39, 33, 12, '5', 3, 2, 2, 4, 2, '号的的', 13, '331444745555'),
(40, 34, 12, '4', 0, 0, 0, 0, 0, '', 0, '341444745587'),
(41, 37, 12, '4', 0, 0, 0, 0, 0, '', 0, '371444811063'),
(42, 36, 0, '3', 0, 0, 0, 0, 0, NULL, 0, '361444811116'),
(43, 32, 0, '6', 0, 0, 0, 0, 0, NULL, 0, '321445076172'),
(44, 33, 0, '6', 0, 0, 0, 0, 0, NULL, 0, '331445255817');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `judge`
--

INSERT INTO `judge` (`id`, `name`, `password`, `direction`, `member_id`) VALUES
(10, 'safe', 'safe', 1, 0),
(11, 'web', 'web', 2, 0),
(12, 'safe_1', 'safe_1', 1, 1),
(13, 'web_1', 'web_1', 2, 1),
(14, 'operate', 'operate', 3, 0),
(15, 'operate_1', 'operate', 3, 1),
(16, 'root', 'root', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `judge` varchar(45) DEFAULT NULL,
  `direction` int(11) DEFAULT NULL,
  `message` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`id`, `student_id`, `name`, `status`, `judge`, `direction`, `message`) VALUES
(101, '04131104', '小会', 4, 'safe_1', 1, '请到 safe_1 面试组进行面试');

-- --------------------------------------------------------

--
-- 表的结构 `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `student_id` varchar(45) NOT NULL,
  `grade` varchar(45) NOT NULL,
  `class` varchar(45) NOT NULL,
  `tel` varchar(45) NOT NULL,
  `direction` int(11) NOT NULL COMMENT '报那个小组\n0 root\n1 安全组\n2 web\n3  技术运营\n4  视觉设计组',
  `status` int(11) NOT NULL COMMENT '1  报名 2 签到  3 一面一等待 4 一面一进行 5 一面一结束 6 一面二等待 7 一面二进行 8 一面结束 9  二面等待 10 二面进行 11 二面结束 12 一面通过 13 一面未通过 14 二面通过 15 二面未通过',
  `gender` varchar(13) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentid_UNIQUE` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- 转存表中的数据 `player`
--

INSERT INTO `player` (`id`, `name`, `student_id`, `grade`, `class`, `tel`, `direction`, `status`, `gender`) VALUES
(4, '', '12345678', 'a', 'a', 'a', 2, 3, ''),
(13, 'phpAd', '08131098', '1', '2', '1', 1, 3, ''),
(26, '张煜堃', '04131093', '13', '网络1303', '18829290080', 1, 10, ''),
(27, '张煜', '04131094', '13', '网络1303', '18829290081', 1, 9, ''),
(28, '张堃', '04131095', '14', '网络1303', '18829290082', 1, 9, ''),
(29, '王世方', '04131096', '13', '网络1303', '18829290070', 1, 12, ''),
(30, '小方', '04131097', '13', '网络1303', '18829290071', 1, 7, ''),
(31, '世方', '04131098', '14', '网络1303', '18829290072', 1, 7, ''),
(32, '王为', '04131099', '13', '网络1303', '18829290060', 1, 6, ''),
(33, '主为把', '04131100', '13', '网络1303', '18829290060', 1, 6, ''),
(34, '小会', '04131101', '14', '网络1303', '18829290062', 1, 4, ''),
(35, '张大和', '04131102', '13', '网络1303', '18829290050', 1, 1, ''),
(36, '王李堃', '04131103', '13', '网络1303', '18829290050', 1, 3, ''),
(37, '小会', '04131104', '14', '网络1303', '18829290042', 1, 4, '');

--
-- 限制导出的表
--

--
-- 限制表 `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `fk_interview_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
