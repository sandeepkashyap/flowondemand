-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2007 at 12:39 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `cuteflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `cf_additional_text`
--

CREATE TABLE `cf_additional_text` (
  `id` int(11) NOT NULL auto_increment,
  `title` text collate latin1_general_ci NOT NULL,
  `content` text collate latin1_general_ci NOT NULL,
  `is_default` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cf_additional_text`
--


-- --------------------------------------------------------

--
-- Table structure for table `cf_attachment`
--

CREATE TABLE `cf_attachment` (
  `nID` int(11) NOT NULL auto_increment,
  `strPath` text collate latin1_general_ci NOT NULL,
  `nCirculationHistoryId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cf_attachment`
--

INSERT INTO `cf_attachment` (`nID`, `strPath`, `nCirculationHistoryId`) VALUES
(2, '../attachments/cf_16/1191921281/Sales Workflow.pdf', 34),
(3, '../attachments/cf_17/1191921433/Sales Workflow.pdf', 35);

-- --------------------------------------------------------

--
-- Table structure for table `cf_circulationform`
--

CREATE TABLE `cf_circulationform` (
  `nID` int(11) NOT NULL auto_increment,
  `nSenderId` int(11) NOT NULL default '0',
  `strName` text collate latin1_general_ci NOT NULL,
  `nMailingListId` int(11) NOT NULL default '0',
  `bIsArchived` tinyint(4) NOT NULL default '0',
  `nEndAction` tinyint(4) NOT NULL default '0',
  `bDeleted` int(11) NOT NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `cf_circulationform`
--

INSERT INTO `cf_circulationform` (`nID`, `nSenderId`, `strName`, `nMailingListId`, `bIsArchived`, `nEndAction`, `bDeleted`) VALUES
(10, 1, 'My First Circulation No1', 1, 0, 3, 0),
(11, 1, 'My First Circulation No2', 2, 0, 3, 0),
(12, 1, 'My First Circulation No333', 3, 0, 3, 0),
(13, 1, 'Checkbox Testing', 2, 1, 3, 0),
(14, 1, 'Product 200 Test No1', 4, 0, 3, 0),
(16, 35, 'Ngôi nhà m&#417; &#432;&#7899;c tháng 1/2008', 5, 0, 3, 0),
(17, 35, 'Hello', 5, 0, 3, 0),
(18, 35, 'Xin ngh&#7881; c&#432;&#7899;i v&#7907;', 6, 0, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_circulationhistory`
--

CREATE TABLE `cf_circulationhistory` (
  `nID` int(11) NOT NULL auto_increment,
  `nRevisionNumber` int(11) NOT NULL default '0',
  `dateSending` int(15) NOT NULL default '0',
  `strAdditionalText` text collate latin1_general_ci NOT NULL,
  `nCirculationFormId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `cf_circulationhistory`
--

INSERT INTO `cf_circulationhistory` (`nID`, `nRevisionNumber`, `dateSending`, `strAdditionalText`, `nCirculationFormId`) VALUES
(21, 3, 1180007140, '', 10),
(11, 1, 1180003974, 'Send Date: 2007-05-24', 10),
(20, 2, 1180007130, '', 10),
(22, 4, 1180007206, '', 10),
(23, 5, 1180009391, '', 10),
(24, 1, 1180013225, '2007-05-24', 11),
(25, 1, 1180013299, 'Test', 12),
(26, 6, 1180013536, '', 10),
(27, 1, 1180017037, '', 13),
(28, 2, 1180018130, '', 13),
(29, 3, 1180018277, '', 13),
(30, 4, 1180018395, '', 13),
(31, 5, 1180018556, '', 13),
(32, 1, 1180076469, '', 14),
(34, 1, 1191921281, 'Duy&#7879;t chi kô nè', 16),
(35, 1, 1191921433, 'Hello', 17),
(36, 1, 1191927508, '', 18);

-- --------------------------------------------------------

--
-- Table structure for table `cf_circulationprocess`
--

CREATE TABLE `cf_circulationprocess` (
  `nID` int(11) NOT NULL auto_increment,
  `nCirculationFormId` int(11) NOT NULL default '0',
  `nSlotId` int(11) NOT NULL default '0',
  `nUserId` int(11) NOT NULL default '0',
  `dateInProcessSince` int(15) NOT NULL default '0',
  `nDecissionState` tinyint(4) NOT NULL default '0',
  `dateDecission` int(15) NOT NULL default '0',
  `nIsSubstitiuteOf` int(11) NOT NULL default '0',
  `nCirculationHistoryId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=215 ;

--
-- Dumping data for table `cf_circulationprocess`
--

INSERT INTO `cf_circulationprocess` (`nID`, `nCirculationFormId`, `nSlotId`, `nUserId`, `dateInProcessSince`, `nDecissionState`, `dateDecission`, `nIsSubstitiuteOf`, `nCirculationHistoryId`) VALUES
(110, 10, 3, 25, 1180000130, 4, 1180000150, 0, 20),
(107, 10, 2, 27, 1179999980, 4, 1180000000, 0, 20),
(108, 10, 2, 2, 1180000030, 4, 1180000050, 0, 20),
(109, 10, 2, 1, 1180000080, 4, 1180000100, 0, 20),
(69, 10, 2, 1, 1180004063, 16, 0, 0, 11),
(68, 10, 2, 2, 1180004048, 1, 1180004063, 0, 11),
(67, 10, 2, 32, 1180004024, 1, 1180004048, 66, 11),
(66, 10, 2, 27, 1180003993, 8, 1180004024, 0, 11),
(65, 10, 2, 13, 1180003974, 1, 1180003993, 0, 11),
(111, 10, 3, 21, 1180007130, 16, 0, 0, 20),
(106, 10, 2, 13, 1179999930, 4, 1179999950, 0, 20),
(113, 10, 2, 27, 1179999990, 4, 1180000010, 0, 21),
(114, 10, 2, 2, 1180007140, 1, 1180007190, 0, 21),
(112, 10, 2, 13, 1179999940, 4, 1179999960, 0, 21),
(115, 10, 2, 1, 1180007190, 16, 0, 0, 21),
(116, 10, 2, 13, 1180000006, 4, 1180000026, 0, 22),
(117, 10, 2, 27, 1180000056, 4, 1180000076, 0, 22),
(118, 10, 2, 2, 1180000106, 4, 1180000126, 0, 22),
(119, 10, 2, 1, 1180000156, 4, 1180000176, 0, 22),
(120, 10, 3, 25, 1180000206, 4, 1180000226, 0, 22),
(121, 10, 3, 21, 1180000256, 4, 1180000276, 0, 22),
(122, 10, 4, 1, 1180000306, 4, 1180000326, 0, 22),
(123, 10, 4, 6, 1180000356, 4, 1180000376, 0, 22),
(124, 10, 4, 29, 1180007206, 16, 0, 0, 22),
(125, 10, 2, 13, 1180002191, 4, 1180002211, 0, 23),
(126, 10, 2, 27, 1180002241, 4, 1180002261, 0, 23),
(127, 10, 2, 2, 1180002291, 4, 1180002311, 0, 23),
(128, 10, 2, 1, 1180002341, 4, 1180002361, 0, 23),
(129, 10, 3, 25, 1180002391, 4, 1180002411, 0, 23),
(130, 10, 3, 21, 1180002441, 4, 1180002461, 0, 23),
(131, 10, 4, 1, 1180002491, 4, 1180002511, 0, 23),
(132, 10, 4, 6, 1180002541, 4, 1180002561, 0, 23),
(133, 10, 4, 29, 1180009391, 16, 0, 0, 23),
(134, 11, 2, 13, 1180013225, 4, 1180013179, 0, 24),
(135, 11, 2, 12, 1180013239, 4, 1180013241, 0, 24),
(136, 11, 2, -2, 1180013240, 4, 1180013242, 0, 24),
(137, 11, 3, 20, 1180013241, 0, 0, 0, 24),
(138, 12, 2, 13, 1180013299, 1, 1180013327, 0, 25),
(139, 12, 2, 12, 1180013327, 1, 1180013341, 0, 25),
(140, 12, 3, 20, 1180013341, 1, 1180016369, 0, 25),
(141, 10, 2, 13, 1180006336, 4, 1180006356, 0, 26),
(142, 10, 2, 27, 1180006386, 4, 1180006406, 0, 26),
(143, 10, 2, 2, 1180006436, 4, 1180006456, 0, 26),
(144, 10, 2, 1, 1180006486, 4, 1180006506, 0, 26),
(145, 10, 3, 25, 1180006536, 4, 1180006556, 0, 26),
(146, 10, 3, 21, 1180006586, 4, 1180006606, 0, 26),
(147, 10, 4, 1, 1180006636, 4, 1180006656, 0, 26),
(148, 10, 4, 6, 1180006686, 4, 1180006706, 0, 26),
(149, 10, 4, 29, 1180013536, 0, 0, 0, 26),
(150, 12, 3, 7, 1180016369, 0, 0, 0, 25),
(151, 13, 2, 13, 1180017037, 1, 1180017054, 0, 27),
(152, 13, 2, 12, 1180017054, 1, 1180017066, 0, 27),
(153, 13, 2, 1, 1180017066, 1, 1180017075, 0, 27),
(154, 13, 3, 20, 1180017075, 1, 1180017604, 0, 27),
(155, 13, 3, 7, 1180017604, 16, 0, 0, 27),
(156, 13, 2, 13, 1180018130, 4, 1180018084, 0, 28),
(157, 13, 2, 12, 1180018144, 4, 1180018146, 0, 28),
(158, 13, 2, -2, 1180018145, 1, 1180018151, 0, 28),
(159, 13, 3, 20, 1180018151, 1, 1180018167, 0, 28),
(160, 13, 3, 7, 1180018167, 16, 0, 0, 28),
(161, 13, 2, 13, 1180018277, 4, 1180018225, 0, 29),
(162, 13, 2, 12, 1180018285, 4, 1180018287, 0, 29),
(163, 13, 2, -2, 1180018286, 1, 1180018291, 0, 29),
(164, 13, 3, 20, 1180018291, 1, 1180018303, 0, 29),
(165, 13, 3, 7, 1180018303, 16, 0, 0, 29),
(166, 13, 2, 13, 1180018395, 4, 1180018345, 0, 30),
(167, 13, 2, 12, 1180018405, 4, 1180018407, 0, 30),
(168, 13, 2, -2, 1180018406, 1, 1180018412, 0, 30),
(169, 13, 3, 20, 1180018412, 1, 1180018425, 0, 30),
(170, 13, 3, 7, 1180018425, 1, 1180018435, 0, 30),
(171, 13, 3, 29, 1180018435, 1, 1180018444, 0, 30),
(172, 13, 4, 1, 1180018444, 1, 1180018464, 0, 30),
(173, 13, 5, 31, 1180018464, 1, 1180018472, 0, 30),
(174, 13, 5, 10, 1180018472, 1, 1180018480, 0, 30),
(175, 13, 5, 21, 1180018480, 1, 1180018522, 0, 30),
(176, 13, 5, 5, 1180018522, 2, 1180018537, 0, 30),
(177, 13, 2, 13, 1180011356, 4, 1180011376, 0, 31),
(178, 13, 2, 12, 1180011406, 4, 1180011426, 0, 31),
(179, 13, 2, 1, 1180011456, 4, 1180011476, 0, 31),
(180, 13, 3, 20, 1180011506, 4, 1180011526, 0, 31),
(181, 13, 3, 7, 1180011556, 4, 1180011576, 0, 31),
(182, 13, 3, 29, 1180011606, 4, 1180011626, 0, 31),
(183, 13, 4, 1, 1180011656, 4, 1180011676, 0, 31),
(184, 13, 5, 31, 1180011706, 4, 1180011726, 0, 31),
(185, 13, 5, 10, 1180011756, 4, 1180011776, 0, 31),
(186, 13, 5, 21, 1180011806, 4, 1180011826, 0, 31),
(188, 13, 5, 5, 1180018654, 1, 1180018669, 0, 31),
(189, 14, 6, 24, 1180076469, 1, 1180076528, 0, 32),
(193, 14, 6, 13, 1180076737, 8, 1180076800, 0, 32),
(195, 14, 6, 29, 1180077119, 1, 1180077152, 194, 32),
(194, 14, 6, 27, 1180076800, 8, 1180077119, 193, 32),
(196, 14, 6, 28, 1180077152, 1, 1180077165, 0, 32),
(197, 14, 6, 27, 1180077165, 1, 1180077178, 0, 32),
(198, 14, 7, 30, 1180077178, 0, 0, 0, 32),
(207, 16, 12, 35, 1191921281, 0, 0, 0, 34),
(210, 17, 12, 35, 1191921682, 1, 1191921958, 0, 35),
(211, 17, 10, 35, 1191921958, 1, 1191922063, 0, 35),
(212, 17, 10, 36, 1191922063, 0, 0, 0, 35),
(213, 18, 13, 35, 1191927507, 1, 1191927576, 0, 36),
(214, 18, 14, 36, 1191927576, 2, 1191927640, 0, 36);

-- --------------------------------------------------------

--
-- Table structure for table `cf_config`
--

CREATE TABLE `cf_config` (
  `strCF_Server` text collate latin1_general_ci NOT NULL,
  `strSMTP_use_auth` text collate latin1_general_ci NOT NULL,
  `strSMTP_server` text collate latin1_general_ci NOT NULL,
  `strSMTP_port` varchar(8) collate latin1_general_ci NOT NULL default '',
  `strSMTP_userid` text collate latin1_general_ci NOT NULL,
  `strSMTP_pwd` tinytext collate latin1_general_ci NOT NULL,
  `strSysReplyAddr` text collate latin1_general_ci NOT NULL,
  `strMailAddTextDef` text collate latin1_general_ci NOT NULL,
  `strDefLang` char(3) collate latin1_general_ci NOT NULL default 'en',
  `bDetailSeperateWindow` varchar(5) collate latin1_general_ci NOT NULL default 'true',
  `strDefSortCol` varchar(32) collate latin1_general_ci NOT NULL default 'COL_CIRCULATION_NAME',
  `bShowPosMail` varchar(5) collate latin1_general_ci NOT NULL default 'true',
  `bFilter_AR_Wordstart` varchar(5) collate latin1_general_ci NOT NULL default 'true',
  `strCirculation_cols` varchar(255) collate latin1_general_ci NOT NULL default '12345',
  `nDelay_norm` int(11) NOT NULL default '7',
  `nDelay_interm` int(11) NOT NULL default '10',
  `nDelay_late` int(11) NOT NULL default '12',
  `strEmail_Format` varchar(8) collate latin1_general_ci NOT NULL default 'HTML',
  `strEmail_Values` varchar(8) collate latin1_general_ci NOT NULL default 'IFRAME',
  `nSubstitutePerson_Hours` int(11) NOT NULL default '96',
  `strSubstitutePerson_Unit` text collate latin1_general_ci NOT NULL,
  `nConfigID` int(11) NOT NULL default '0',
  `strSortDirection` text collate latin1_general_ci NOT NULL,
  `strVersion` text collate latin1_general_ci NOT NULL,
  `nShowRows` int(11) default NULL,
  `nAutoReload` int(11) NOT NULL default '0',
  `strUrlPassword` text collate latin1_general_ci NOT NULL,
  `tsLastUpdate` int(11) NOT NULL,
  `bAllowUnencryptedRequest` int(11) NOT NULL,
  `UserDefined1_Title` text collate latin1_general_ci NOT NULL,
  `UserDefined2_Title` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`nConfigID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cf_config`
--

INSERT INTO `cf_config` (`strCF_Server`, `strSMTP_use_auth`, `strSMTP_server`, `strSMTP_port`, `strSMTP_userid`, `strSMTP_pwd`, `strSysReplyAddr`, `strMailAddTextDef`, `strDefLang`, `bDetailSeperateWindow`, `strDefSortCol`, `bShowPosMail`, `bFilter_AR_Wordstart`, `strCirculation_cols`, `nDelay_norm`, `nDelay_interm`, `nDelay_late`, `strEmail_Format`, `strEmail_Values`, `nSubstitutePerson_Hours`, `strSubstitutePerson_Unit`, `nConfigID`, `strSortDirection`, `strVersion`, `nShowRows`, `nAutoReload`, `strUrlPassword`, `tsLastUpdate`, `bAllowUnencryptedRequest`, `UserDefined1_Title`, `UserDefined2_Title`) VALUES
('dev.cuteflow.com', 'y', 'localhost', '25', 'khanhtq@demand.vn', 'abc123', 'Tao lÃ  KhÃ¡nh', '', 'en', 'true', 'COL_CIRCULATION_PROCESS_DAYS', 'true', 'true', 'NAME---1---STATION---1---DAYS---1---START---1---SENDER---1---WHOLETIME---0---MAILLIST---0---TEMPLATE---0', 7, 10, 12, '', 'IFRAME', 1, 'DAYS', 1, 'ASC', '2.9.1', 50, 60, '0cf909545917b34e9778be0f83899088', 1191916176, 0, 'user-defined1', 'user-defined2');

-- --------------------------------------------------------

--
-- Table structure for table `cf_fieldvalue`
--

CREATE TABLE `cf_fieldvalue` (
  `nID` int(11) NOT NULL auto_increment,
  `nInputFieldId` int(11) NOT NULL default '0',
  `strFieldValue` text collate latin1_general_ci NOT NULL,
  `nSlotId` int(11) NOT NULL default '0',
  `nFormId` int(11) NOT NULL default '0',
  `nCirculationHistoryId` int(11) default NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=500 ;

--
-- Dumping data for table `cf_fieldvalue`
--

INSERT INTO `cf_fieldvalue` (`nID`, `nInputFieldId`, `strFieldValue`, `nSlotId`, `nFormId`, `nCirculationHistoryId`) VALUES
(369, 9, '', 4, 11, 24),
(370, 4, 'xx3xx2004-09-11', 5, 11, 24),
(365, 2, '0', 3, 11, 24),
(366, 8, '0---0---0---1---0---', 3, 11, 24),
(368, 7, '0---0---1---1---0---0---1---0---', 4, 11, 24),
(367, 9, '', 3, 11, 24),
(363, 2, '0', 2, 11, 24),
(364, 4, 'xx3xx2004-09-11', 2, 11, 24),
(362, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 11, 24),
(361, 6, '0---0---1---0---', 2, 11, 24),
(360, 2, '0', 5, 10, 23),
(359, 1, 'default value', 5, 10, 23),
(358, 4, 'xx3xx2004-09-11', 5, 10, 23),
(357, 9, '', 4, 10, 23),
(144, 2, '', 5, 10, 11),
(143, 1, 'default value', 5, 10, 11),
(142, 4, 'xx3xx2004-09-11', 5, 10, 11),
(141, 9, '', 4, 10, 11),
(140, 7, '0---0---1---1---0---0---1---0---', 4, 10, 11),
(138, 8, '0---0---0---1---0---', 3, 10, 11),
(139, 9, '', 3, 10, 11),
(137, 2, '', 3, 10, 11),
(136, 4, 'xx3xx2004-09-22', 2, 10, 11),
(135, 2, '', 2, 10, 11),
(355, 9, '', 3, 10, 23),
(356, 7, '0---0---1---1---0---0---1---0---', 4, 10, 23),
(134, 5, 'ZwO', 2, 10, 11),
(133, 6, '0---1---0---0---', 2, 10, 11),
(353, 2, '0', 3, 10, 23),
(354, 8, '0---0---0---1---0---', 3, 10, 23),
(352, 4, 'xx3xx2004-09-11', 2, 10, 23),
(351, 2, '0', 2, 10, 23),
(350, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 10, 23),
(349, 6, '0---0---1---0---', 2, 10, 23),
(348, 6, '0---0---0---1---', 2, 10, 22),
(347, 2, 'on', 2, 10, 22),
(346, 4, 'xx3xx2004-09-24', 2, 10, 22),
(345, 5, 'ZwO Drei', 2, 10, 22),
(344, 2, '', 3, 10, 22),
(342, 9, '', 3, 10, 22),
(343, 8, '0---0---0---1---0---', 3, 10, 22),
(341, 9, '', 4, 10, 22),
(340, 7, '0---0---1---1---0---0---1---0---', 4, 10, 22),
(339, 4, 'xx3xx2004-09-11', 5, 10, 22),
(338, 1, 'default value', 5, 10, 22),
(336, 2, '', 5, 10, 21),
(337, 2, '', 5, 10, 22),
(335, 1, 'default value', 5, 10, 21),
(334, 4, 'xx3xx2004-09-11', 5, 10, 21),
(332, 7, '0---0---1---1---0---0---1---0---', 4, 10, 21),
(333, 9, '', 4, 10, 21),
(330, 9, '', 3, 10, 21),
(331, 8, '0---0---0---1---0---', 3, 10, 21),
(329, 2, '', 3, 10, 21),
(326, 5, 'ZwO Drei', 2, 10, 21),
(327, 4, 'xx3xx2004-09-24', 2, 10, 21),
(328, 2, 'on', 2, 10, 21),
(325, 6, '0---0---0---1---', 2, 10, 21),
(324, 6, '0---1---0---0---', 2, 10, 20),
(323, 5, 'ZwO', 2, 10, 20),
(321, 4, 'xx3xx2004-09-22', 2, 10, 20),
(322, 2, '', 2, 10, 20),
(320, 2, '', 3, 10, 20),
(319, 9, '', 3, 10, 20),
(318, 8, '0---0---0---1---0---', 3, 10, 20),
(317, 7, '0---0---1---1---0---0---1---0---', 4, 10, 20),
(316, 9, '', 4, 10, 20),
(315, 4, 'xx3xx2004-09-11', 5, 10, 20),
(314, 1, 'default value', 5, 10, 20),
(313, 2, '', 5, 10, 20),
(371, 1, 'default value', 5, 11, 24),
(372, 2, '0', 5, 11, 24),
(373, 6, '0---0---1---0---', 2, 12, 25),
(374, 5, 'OnE11', 2, 12, 25),
(375, 2, '', 2, 12, 25),
(376, 4, 'xx3xx2004-01-11', 2, 12, 25),
(377, 2, 'on', 3, 12, 25),
(378, 8, '---5---Option No1---1---Option No2---0---Option No3---0---Option No4 (default)---0---Option No5---0', 3, 12, 25),
(379, 9, '---1---3_12_25---CuteFlow_bin_v250.ziprrrrr', 3, 12, 25),
(380, 7, '---8---Checkbox - No1---1---Checkbox - No2---0---Checkbox - No3 (default)---0---Checkbox - No4 (default)---0---Checkbox - No5---0---Checkbox - No6---0---Checkbox - No7 (default)---0---Checkbox - No8---0', 4, 12, 25),
(381, 9, '', 4, 12, 25),
(382, 4, 'xx3xx2004-09-01', 5, 12, 25),
(383, 1, 'default value one', 5, 12, 25),
(384, 2, '', 5, 12, 25),
(385, 2, '0', 5, 10, 26),
(386, 1, 'default value', 5, 10, 26),
(387, 4, 'xx3xx2004-09-11', 5, 10, 26),
(388, 9, '', 4, 10, 26),
(389, 9, '', 3, 10, 26),
(390, 7, '0---0---1---1---0---0---1---0---', 4, 10, 26),
(391, 2, '0', 3, 10, 26),
(392, 8, '0---0---0---1---0---', 3, 10, 26),
(393, 4, 'xx3xx2004-09-11', 2, 10, 26),
(394, 2, '0', 2, 10, 26),
(395, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 10, 26),
(396, 6, '0---0---1---0---', 2, 10, 26),
(397, 6, '0---0---1---0---', 2, 13, 27),
(398, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 13, 27),
(399, 2, '', 2, 13, 27),
(400, 4, 'xx3xx2004-09-11', 2, 13, 27),
(401, 2, 'on', 3, 13, 27),
(402, 8, '0---0---0---1---0---', 3, 13, 27),
(403, 9, '', 3, 13, 27),
(404, 7, '0---0---1---1---0---0---1---0---', 4, 13, 27),
(405, 9, '', 4, 13, 27),
(406, 4, 'xx3xx2004-09-11', 5, 13, 27),
(407, 1, 'default value', 5, 13, 27),
(408, 2, '', 5, 13, 27),
(409, 6, '0---0---1---0---', 2, 13, 28),
(410, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 13, 28),
(411, 2, '', 2, 13, 28),
(412, 4, 'xx3xx2004-09-11', 2, 13, 28),
(413, 2, '', 3, 13, 28),
(414, 8, '0---0---0---1---0---', 3, 13, 28),
(415, 9, '', 3, 13, 28),
(416, 7, '0---0---1---1---0---0---1---0---', 4, 13, 28),
(417, 9, '', 4, 13, 28),
(418, 4, 'xx3xx2004-09-11', 5, 13, 28),
(419, 1, 'default value', 5, 13, 28),
(420, 2, '', 5, 13, 28),
(421, 6, '0---0---1---0---', 2, 13, 29),
(422, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 13, 29),
(423, 2, '', 2, 13, 29),
(424, 4, 'xx3xx2004-09-11', 2, 13, 29),
(425, 2, '', 3, 13, 29),
(426, 8, '0---0---0---1---0---', 3, 13, 29),
(427, 9, '', 3, 13, 29),
(428, 7, '0---0---1---1---0---0---1---0---', 4, 13, 29),
(429, 9, '', 4, 13, 29),
(430, 4, 'xx3xx2004-09-11', 5, 13, 29),
(431, 1, 'default value', 5, 13, 29),
(432, 2, '', 5, 13, 29),
(433, 6, '0---0---1---0---', 2, 13, 30),
(434, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 13, 30),
(435, 2, 'on', 2, 13, 30),
(436, 4, 'xx3xx2004-09-11', 2, 13, 30),
(437, 2, '', 3, 13, 30),
(438, 8, '0---0---0---1---0---', 3, 13, 30),
(439, 9, '', 3, 13, 30),
(440, 7, '0---1---1---1---1---1---1---0---', 4, 13, 30),
(441, 9, '', 4, 13, 30),
(442, 4, 'xx3xx2004-09-11', 5, 13, 30),
(443, 1, 'default value', 5, 13, 30),
(444, 2, 'on', 5, 13, 30),
(445, 6, '0---0---1---0---', 2, 13, 31),
(446, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 2, 13, 31),
(447, 2, 'on', 2, 13, 31),
(448, 4, 'xx3xx2004-09-11', 2, 13, 31),
(449, 2, '', 3, 13, 31),
(450, 8, '0---0---0---1---0---', 3, 13, 31),
(451, 9, '', 3, 13, 31),
(452, 7, '0---1---1---1---1---1---1---0---', 4, 13, 31),
(453, 9, '', 4, 13, 31),
(454, 4, 'xx3xx2004-09-11', 5, 13, 31),
(455, 1, 'default value', 5, 13, 31),
(456, 2, '', 5, 13, 31),
(457, 8, '0---0---0---1---0---', 6, 14, 32),
(458, 7, '1---1---0---0---1---0---0---0---', 6, 14, 32),
(459, 2, 'on', 6, 14, 32),
(460, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 7, 14, 32),
(461, 1, 'default value', 7, 14, 32),
(462, 6, '0---0---1---0---', 7, 14, 32),
(463, 3, 'xx1xx1337', 7, 14, 32),
(464, 9, '', 7, 14, 32),
(465, 4, 'xx3xx2004-09-11', 7, 14, 32),
(466, 1, 'default value', 8, 14, 32),
(467, 2, '', 8, 14, 32),
(468, 6, '0---0---1---0---', 9, 14, 32),
(469, 1, 'default value', 9, 14, 32),
(470, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 9, 14, 32),
(483, 2, '0', 10, 16, 34),
(484, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 10, 16, 34),
(482, 3, 'xx1xx1337', 12, 16, 34),
(481, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 12, 16, 34),
(479, 9, '', 12, 16, 34),
(480, 1, 'default value', 12, 16, 34),
(485, 2, '0', 11, 16, 34),
(486, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 11, 16, 34),
(487, 9, '---1---12_17_35---System scenario (V5).pdfrrrrr', 12, 17, 35),
(488, 1, '&#272;&#7873; ngh&#7883; duy&#7879;t chi cho ngân sách', 12, 17, 35),
(489, 5, 'Th&#7871; s&#7921; du du n&#7841;i lão hà\r\nVô cùng thiên &#273;&#7883;a nh&#7853;p hàm ca', 12, 17, 35),
(490, 3, 'xx1xx10000', 12, 17, 35),
(491, 2, 'on', 10, 17, 35),
(492, 5, 'Duy&#7879;t.', 10, 17, 35),
(495, 10, 'Ngh&#7881; &#273;&#7875; c&#432;&#7899;i v&#7907;', 13, 18, 36),
(493, 2, '', 11, 17, 35),
(494, 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 11, 17, 35),
(496, 11, 'xx1xx10-12-2007', 13, 18, 36),
(497, 12, 'xx1xx01-01-2008', 13, 18, 36),
(498, 13, '', 14, 18, 36),
(499, 14, '1---1---', 15, 18, 36);

-- --------------------------------------------------------

--
-- Table structure for table `cf_filter`
--

CREATE TABLE `cf_filter` (
  `nID` int(11) NOT NULL auto_increment,
  `nUserID` int(11) NOT NULL default '0',
  `strLabel` text collate latin1_general_ci NOT NULL,
  `strName` text collate latin1_general_ci NOT NULL,
  `nStationID` int(11) NOT NULL default '0',
  `nDaysInProgress_Start` text collate latin1_general_ci NOT NULL,
  `nDaysInProgress_End` text collate latin1_general_ci NOT NULL,
  `strSendDate_Start` text collate latin1_general_ci NOT NULL,
  `strSendDate_End` text collate latin1_general_ci NOT NULL,
  `nMailinglistID` int(11) NOT NULL default '0',
  `nTemplateID` int(11) NOT NULL default '0',
  `strCustomFilter` text collate latin1_general_ci NOT NULL,
  `nSenderID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cf_filter`
--


-- --------------------------------------------------------

--
-- Table structure for table `cf_formslot`
--

CREATE TABLE `cf_formslot` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext collate latin1_general_ci NOT NULL,
  `nTemplateId` int(11) NOT NULL default '0',
  `nSlotNumber` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `cf_formslot`
--

INSERT INTO `cf_formslot` (`nID`, `strName`, `nTemplateId`, `nSlotNumber`) VALUES
(2, 'Slot No1', 3, 1),
(3, 'Slot No2', 3, 2),
(4, 'Slot No3', 3, 3),
(5, 'Slot No4', 3, 4),
(6, 'technology', 4, 1),
(7, 'purchasing', 4, 2),
(8, 'marketing', 4, 3),
(9, 'accounting', 4, 4),
(10, 'Xem xét', 5, 2),
(11, 'Duy&#7879;t chi', 5, 3),
(12, 'Init Request', 5, 1),
(13, 'Làm &#273;&#417;n', 6, 1),
(14, 'Tr&#432;&#7903;ng phòng xác nh&#7853;n', 6, 2),
(15, 'X&#7871;p duy&#7879;t', 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cf_formtemplate`
--

CREATE TABLE `cf_formtemplate` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cf_formtemplate`
--

INSERT INTO `cf_formtemplate` (`nID`, `strName`) VALUES
(4, 'Product 2000'),
(3, 'Template - Test No1'),
(5, 'Ngôi nhà m&#417; &#432;&#7899;c'),
(6, '&#272;&#417;n xin ngh&#7881; vi&#7879;c');

-- --------------------------------------------------------

--
-- Table structure for table `cf_inputfield`
--

CREATE TABLE `cf_inputfield` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext collate latin1_general_ci NOT NULL,
  `nType` int(11) NOT NULL default '0',
  `strStandardValue` text collate latin1_general_ci NOT NULL,
  `bReadOnly` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `cf_inputfield`
--

INSERT INTO `cf_inputfield` (`nID`, `strName`, `nType`, `strStandardValue`, `bReadOnly`) VALUES
(1, 'TESTFIELD - Text', 1, 'default value', 0),
(2, 'TESTFIELD - Checkbox', 2, '0', 0),
(3, 'TESTFIELD - Number', 3, 'xx1xx1337', 0),
(4, 'TESTFIELD - Date', 4, 'xx3xx2004-09-11', 0),
(5, 'TESTFIELD - Textfield', 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 0),
(6, 'TESTFIELD - Radiogroup', 6, '---4---Radiobutton - No1---0---Radiobutton - No2---0---Radiobutton - No3 (default)---1---Radiobutton - No4---0', 0),
(7, 'TESTFIELD - Checkboxgroup', 7, '---8---Checkbox - No1---0---Checkbox - No2---0---Checkbox - No3 (default)---1---Checkbox - No4 (default)---1---Checkbox - No5---0---Checkbox - No6---0---Checkbox - No7 (default)---1---Checkbox - No8---0', 0),
(8, 'TESTFIELD - Combobox', 8, '---5---Option No1---0---Option No2---0---Option No3---0---Option No4 (default)---1---Option No5---0', 0),
(9, 'TESTFIELD - File', 9, '', 0),
(10, 'Lý do', 5, '', 0),
(11, 'T&#7915; ngày', 4, 'xx1xx', 0),
(12, '&#272;&#7871;n ngày', 4, 'xx1xx', 0),
(13, 'Tr&#432;&#7903;ng phòng xác nh&#7853;n', 5, '', 0),
(14, 'Xác nh&#7853;n', 7, '---2---1---1---2---1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_mailinglist`
--

CREATE TABLE `cf_mailinglist` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` text collate latin1_general_ci NOT NULL,
  `nTemplateId` int(11) NOT NULL default '0',
  `bIsEdited` int(11) default NULL,
  `bIsDefault` int(11) NOT NULL default '0',
  `bDeleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cf_mailinglist`
--

INSERT INTO `cf_mailinglist` (`nID`, `strName`, `nTemplateId`, `bIsEdited`, `bIsDefault`, `bDeleted`) VALUES
(1, 'Mailinglist - Test No1', 3, 0, 0, 0),
(2, 'Mailinglist - Test No2', 3, 0, 0, 0),
(3, 'Mailinglist - Test No2', 3, 1, 0, 0),
(4, 'General Mailinglist 2000', 4, 0, 0, 0),
(5, 'Ngôi nhà m&#417; &#432;&#7899;c', 5, 0, 1, 0),
(6, '&#272;&#417;n xin ngh&#7881; vi&#7879;c', 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_slottofield`
--

CREATE TABLE `cf_slottofield` (
  `nID` int(11) NOT NULL auto_increment,
  `nSlotId` int(11) NOT NULL default '0',
  `nFieldId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=55 ;

--
-- Dumping data for table `cf_slottofield`
--

INSERT INTO `cf_slottofield` (`nID`, `nSlotId`, `nFieldId`) VALUES
(2, 2, 6),
(3, 2, 5),
(4, 2, 2),
(5, 2, 4),
(6, 3, 2),
(7, 3, 8),
(8, 3, 9),
(9, 4, 7),
(10, 4, 9),
(11, 5, 4),
(12, 5, 1),
(13, 5, 2),
(30, 6, 8),
(29, 6, 7),
(28, 6, 2),
(36, 7, 5),
(35, 7, 1),
(34, 7, 6),
(33, 7, 3),
(32, 7, 9),
(31, 7, 4),
(38, 8, 1),
(37, 8, 2),
(41, 9, 6),
(40, 9, 1),
(39, 9, 5),
(42, 12, 9),
(43, 12, 1),
(44, 12, 5),
(45, 12, 3),
(46, 10, 2),
(47, 10, 5),
(48, 11, 2),
(49, 11, 5),
(50, 13, 10),
(51, 13, 11),
(52, 13, 12),
(53, 14, 13),
(54, 15, 14);

-- --------------------------------------------------------

--
-- Table structure for table `cf_slottouser`
--

CREATE TABLE `cf_slottouser` (
  `nID` int(11) NOT NULL auto_increment,
  `nSlotId` int(11) NOT NULL default '0',
  `nMailingListId` int(11) NOT NULL default '0',
  `nUserId` int(11) NOT NULL default '0',
  `nPosition` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=106 ;

--
-- Dumping data for table `cf_slottouser`
--

INSERT INTO `cf_slottouser` (`nID`, `nSlotId`, `nMailingListId`, `nUserId`, `nPosition`) VALUES
(62, 4, 1, 29, 3),
(57, 2, 1, -2, 4),
(56, 2, 1, 2, 3),
(55, 2, 1, 27, 2),
(65, 2, 2, 13, 1),
(59, 3, 1, 21, 2),
(58, 3, 1, 25, 1),
(61, 4, 1, 6, 2),
(60, 4, 1, -2, 1),
(54, 2, 1, 13, 1),
(64, 5, 1, 17, 2),
(63, 5, 1, 22, 1),
(66, 2, 2, 12, 2),
(67, 2, 2, -2, 3),
(68, 3, 2, 20, 1),
(69, 3, 2, 7, 2),
(70, 3, 2, 29, 3),
(71, 4, 2, -2, 1),
(72, 5, 2, 31, 1),
(73, 5, 2, 10, 2),
(74, 5, 2, 21, 3),
(75, 5, 2, 5, 4),
(76, 2, 3, 13, 1),
(77, 2, 3, 12, 2),
(78, 3, 3, 20, 1),
(79, 3, 3, 7, 2),
(80, 4, 3, -2, 1),
(81, 4, 3, 3, 2),
(82, 5, 3, 31, 1),
(83, 5, 3, 10, 2),
(84, 6, 4, 24, 1),
(85, 6, 4, 13, 2),
(86, 6, 4, 28, 3),
(87, 6, 4, 27, 4),
(88, 7, 4, 30, 1),
(89, 7, 4, 3, 2),
(90, 8, 4, 4, 1),
(91, 8, 4, 34, 2),
(92, 9, 4, 21, 1),
(93, 9, 4, 29, 2),
(94, 9, 4, 5, 3),
(99, 12, 5, 35, 1),
(101, 10, 5, 36, 2),
(100, 10, 5, 35, 1),
(102, 11, 5, 37, 1),
(103, 13, 6, 35, 1),
(104, 14, 6, 36, 1),
(105, 15, 6, 37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cf_substitute`
--

CREATE TABLE `cf_substitute` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `substitute_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=69 ;

--
-- Dumping data for table `cf_substitute`
--

INSERT INTO `cf_substitute` (`id`, `user_id`, `substitute_id`, `position`) VALUES
(66, 13, 22, 2),
(65, 13, 29, 1),
(64, 13, 27, 0),
(63, 27, 30, 1),
(62, 27, 3, 0),
(51, 25, 8, 0),
(55, 4, 2, 3),
(54, 4, 8, 2),
(53, 4, 7, 1),
(52, 4, 10, 0),
(56, 19, 1, 0),
(68, 1, 5, 1),
(67, 1, 28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_user`
--

CREATE TABLE `cf_user` (
  `nID` int(11) NOT NULL auto_increment,
  `strLastName` tinytext collate latin1_general_ci NOT NULL,
  `strFirstName` tinytext collate latin1_general_ci NOT NULL,
  `strEMail` tinytext collate latin1_general_ci NOT NULL,
  `nAccessLevel` int(11) NOT NULL default '0',
  `strUserId` tinytext collate latin1_general_ci NOT NULL,
  `strPassword` tinytext collate latin1_general_ci NOT NULL,
  `strEmail_Format` varchar(8) collate latin1_general_ci NOT NULL default 'HTML',
  `strEmail_Values` varchar(8) collate latin1_general_ci NOT NULL default 'IFRAME',
  `nSubstitudeId` int(11) NOT NULL default '0',
  `tsLastAction` int(11) NOT NULL,
  `bDeleted` int(11) NOT NULL,
  `strStreet` text collate latin1_general_ci NOT NULL,
  `strCountry` text collate latin1_general_ci NOT NULL,
  `strZipcode` text collate latin1_general_ci NOT NULL,
  `strCity` text collate latin1_general_ci NOT NULL,
  `strPhone_Main1` text collate latin1_general_ci NOT NULL,
  `strPhone_Main2` text collate latin1_general_ci NOT NULL,
  `strPhone_Mobile` text collate latin1_general_ci NOT NULL,
  `strFax` text collate latin1_general_ci NOT NULL,
  `strOrganisation` text collate latin1_general_ci NOT NULL,
  `strDepartment` text collate latin1_general_ci NOT NULL,
  `strCostCenter` text collate latin1_general_ci NOT NULL,
  `UserDefined1_Value` text collate latin1_general_ci NOT NULL,
  `UserDefined2_Value` text collate latin1_general_ci NOT NULL,
  `nSubstituteTimeValue` int(11) NOT NULL,
  `strSubstituteTimeUnit` text collate latin1_general_ci NOT NULL,
  `bUseGeneralSubstituteConfig` int(11) NOT NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `cf_user`
--

INSERT INTO `cf_user` (`nID`, `strLastName`, `strFirstName`, `strEMail`, `nAccessLevel`, `strUserId`, `strPassword`, `strEmail_Format`, `strEmail_Values`, `nSubstitudeId`, `tsLastAction`, `bDeleted`, `strStreet`, `strCountry`, `strZipcode`, `strCity`, `strPhone_Main1`, `strPhone_Main2`, `strPhone_Mobile`, `strFax`, `strOrganisation`, `strDepartment`, `strCostCenter`, `UserDefined1_Value`, `UserDefined2_Value`, `nSubstituteTimeValue`, `strSubstituteTimeUnit`, `bUseGeneralSubstituteConfig`) VALUES
(1, 'None', 'Administrator', 'khanhtq@demand.vn', 2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1191921321, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(2, 'Habercore', 'Timo', 'khanhtq@demand.vn', 2, 'thabercore', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1178715596, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(12, 'Brew', 'Steven', 'khanhtq@demand.vn', 1, 'sbrew', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '07135 - 103255', '07135-8794515', '0170/5598798', '', '', '', '', 'test 1-2-3', 'test-test', 5, 'MINUTES', 1),
(13, 'Cash', 'Friedel', 'khanhtq@demand.vn', 2, 'fcash', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', -2, 0, 0, 'Livingstreet 88', 'Germany', '74074', 'HeilbronX', '07131 5555584', '', '0162 444777888', '07131 - 22010987', 'none', 'nothing', 'test value 2000', 'empty', 'empty2', 1, 'MINUTES', 1),
(31, 'Kevlar', 'Jennifer', 'khanhtq@demand.vn', 2, 'jkevlar', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(17, 'Sturner', 'Tina', 'khanhtq@demand.vn', 4, 'tsturner', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(18, 'Lay', 'Marcus', 'khanhtq@demand.vn', 4, 'mlay', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(19, 'Munich', 'Claudia', 'khanhtq@demand.vn', 1, 'cmunich', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', -2, 0, 0, '', 'France', '40048', 'ilElle', '08009 852741', '08009 337944', '', '', '', '', '', '', '', 1, 'HOURS', 1),
(20, 'Focker', 'Jonathan', 'khanhtq@demand.vn', 1, 'jfocker', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1180016376, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(21, 'Schlemmer', 'Horst', 'khanhtq@demand.vn', 8, 'hschlemmer', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1179989496, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(22, 'Summer', 'Ursula', 'khanhtq@demand.vn', 4, 'usummer', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(23, 'Fighthint', 'Ulu', 'khanhtq@demand.vn', 1, 'ufighthint', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 5500, 'MINUTES', 1),
(24, 'Beck', 'Steven', 'khanhtq@demand.vn', 8, 'sbeck', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1179835725, 0, 'Forest 135', 'Germany', '20048', 'Goblinhausen', '03114 500407', '', '', '', '', '', '', 'foo is more senseless than bar', '', 1, 'DAYS', 1),
(25, 'Free', 'Warner', 'khanhtq@demand.vn', 1, 'wfree', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', -2, 0, 0, 'Ringstr. 16', 'Germany', '74248', 'Ellhofen', '07134/ 6616', '07134/ 458798', '0176 - 5594879504', '07134-661605', 'Fabrik', 'Technik', 'Technik', 'sinnfrei', '', 1, 'DAYS', 1),
(26, 'Meastro', 'George', 'khanhtq@demand.vn', 1, 'gmeastro', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(27, 'Davinci', 'Anabela', 'khanhtq@demand.vn', 1, 'adavinci', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', -2, 0, 0, 'Cruzingway 4', 'France', '887799', 'Paris', '01234/ 123456', '01234/ 987654', '', '', '', '', '', '', '', 1, 'MINUTES', 1),
(28, 'Cook', 'Joseph', 'khanhtq@demand.vn', 1, 'jcook', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(29, 'Schulz', 'Jeffry', 'khanhtq@demand.vn', 1, 'jschulz', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(30, 'Ghost', 'Andrew', 'khanhtq@demand.vn', 1, 'aghost', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(32, 'Edwinson', 'Beatrix', 'khanhtq@demand.vn', 4, 'bedwinson', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(34, 'Miller', 'Marc', 'khanhtq@demand.vn', 4, 'mmiller', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1179836745, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'MINUTES', 1),
(16, 'Woodwait', 'Jürgen', 'khanhtq@demand.vn', 1, 'jwoodwait', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(5, 'Sindecade', 'Marc', 'khanhtq@demand.vn', 1, 'msindecade', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(11, 'Minz', 'Margreta', 'khanhtq@demand.vn', 4, 'mminz', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(3, 'Haaik', 'Volkman', 'khanhtq@demand.vn', 4, 'vhaaik', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', 'blub', '', '', 'hui', '', 1, 'DAYS', 1),
(4, 'Link', 'Thomas', 'khanhtq@demand.vn', 4, 'tlink', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', -2, 0, 0, 'Witzelweg 46', 'Austria', '111222', 'Wien', '07133 54046', '', '', '', '', '', '', '', '', 20, 'MINUTES', 1),
(6, 'Freeliving', 'Anna', 'khanhtq@demand.vn', 2, 'afreeliving', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1178722412, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'MINUTES', 1),
(7, 'Rich', 'Martin', 'khanhtq@demand.vn', 2, 'mrich', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 90, 'HOURS', 1),
(8, 'Cherry', 'Tom', 'khanhtq@demand.vn', 2, 'tcherry', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, 'Street Of London 85', 'England', '77777', 'City', '0544 4445444', '', '', '', 'xyz', '', '', '', '', 1, 'DAYS', 1),
(10, 'Prinsk', 'Frank', 'khanhtq@demand.vn', 4, 'fprinsk', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 1),
(35, 'Quang Khánh', 'Tr&#7847;n', 'khanhtq@demand.vn', 2, 'khanhtq', 'e99a18c428cb38d5f260853678922e03', 'HTML', 'IFRAME', 0, 1191927599, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 0),
(36, 'Th&#7871; Th&#7883;nh', 'Nguy&#7877;n', 'thinhnt@demand.vn', 1, 'thinhnt', 'e99a18c428cb38d5f260853678922e03', 'HTML', 'IFRAME', 0, 1191927669, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 0),
(37, 'Minh Tu&#7845;n', 'Ngô', 'tuannm@demand.vn', 1, 'tuannm', 'e99a18c428cb38d5f260853678922e03', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_user_index`
--

CREATE TABLE `cf_user_index` (
  `user_id` int(11) NOT NULL,
  `index` text collate latin1_general_ci NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cf_user_index`
--

INSERT INTO `cf_user_index` (`user_id`, `index`) VALUES
(2, 'Habercore Timo khanhtq@demand.vn thabercore             '),
(12, 'Brew Steven khanhtq@demand.vn sbrew     07135 - 103255 07135-8794515 0170/5598798     test 1-2-3 test-test'),
(13, 'Bert Heinz khanhtq@demand.vn hbert Livingstreet 88 Germany 74074 HeilbronX 07131 5555584  0162 444777888 07131 - 22010987 none nothing test value 2000 empty empty2'),
(17, 'Sturner Tina khanhtq@demand.vn tsturner             '),
(18, 'Lay Marcus khanhtq@demand.vn mlay             '),
(19, 'Munich Claudia khanhtq@demand.vn cmunich  France 40048 ilElle 08009 852741 08009 337944       '),
(20, 'Focker Jonathan khanhtq@demand.vn jfocker             '),
(21, 'Schlemmer Horst khanhtq@demand.vn hschlemmer             '),
(22, 'Summer Ursula khanhtq@demand.vn usummer             '),
(23, 'Fighthint Ulu khanhtq@demand.vn ufighthint             '),
(24, 'Beck Steven khanhtq@demand.vn sbeck Forest 135 Germany 20048 Goblinhausen 03114 500407       foo is more senseless than bar '),
(25, 'Free Warner khanhtq@demand.vn wfree Ringstr. 16 Germany 74248 Ellhofen 07134/ 6616 07134/ 458798 0176 - 5594879504 07134-661605 Fabrik Technik Technik sinnfrei '),
(26, 'Meastro George khanhtq@demand.vn gmeastro             '),
(27, 'Davinci Anabela khanhtq@demand.vn adavinci Cruzingway 4 France 887799 Paris 01234/ 123456 01234/ 987654       '),
(28, 'Cook Joseph khanhtq@demand.vn jcook             '),
(29, 'Schulz Jeffry khanhtq@demand.vn jschulz             '),
(30, 'Ghost Andrew khanhtq@demand.vn aghost             '),
(31, 'Kevlar Jennifer khanhtq@demand.vn jkevlar             '),
(32, 'Edwinson Beatrix khanhtq@demand.vn bedwinson             '),
(34, 'Miller Marc khanhtq@demand.vn mmiller             '),
(16, 'Woodwait Jürgen khanhtq@demand.vn jwoodwait             '),
(11, 'Minz Margreta khanhtq@demand.vn mminz             '),
(3, 'Haaik Volkman khanhtq@demand.vn vhaaik         blub   hui '),
(4, 'Link Thomas khanhtq@demand.vn tlink Witzelweg 46 Austria 111222 Wien 07133 54046        '),
(5, 'Sindecade Marc khanhtq@demand.vn msindecade             '),
(6, 'Freeliving Anna khanhtq@demand.vn afreeliving             '),
(7, 'Rich Martin khanhtq@demand.vn mrich             '),
(8, 'Cherry Tom khanhtq@demand.vn tcherry Street Of London 85 England 77777 City 0544 4445444    xyz    '),
(10, 'Prinsk Frank khanhtq@demand.vn fprinsk             '),
(1, 'None Administrator khanhtq@demand.vn admin           '),
(35, 'Quang Khánh Tr&#7847;n khanhtq@demand.vn khanhtq             '),
(36, 'Th&#7871; Th&#7883;nh Nguy&#7877;n thinhnt@demand.vn thinhnt             '),
(37, 'Minh Tu&#7845;n Ngô tuannm@demand.vn tuannm             ');
