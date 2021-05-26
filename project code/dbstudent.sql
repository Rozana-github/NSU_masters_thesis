-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2012 at 01:14 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `dbstudent`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_offered`
--

CREATE TABLE IF NOT EXISTS `course_offered` (
  `course_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `course_fc_id` int(11) NOT NULL,
  `course_id_no` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_semester` varchar(20) NOT NULL,
  `course_year` int(11) NOT NULL,
  PRIMARY KEY (`course_id_no`),
  UNIQUE KEY `course_id` (`course_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `course_offered`
--

INSERT INTO `course_offered` (`course_id`, `date_time`, `course_fc_id`, `course_id_no`, `course_title`, `course_semester`, `course_year`) VALUES
(1, '2012-03-13 16:26:10', 1, 'CSE513', 'SA', 'Spring', 2012),
(2, '2012-03-13 16:50:24', 2, 'advanced architechtu', 'cse594', 'Spring', 2012),
(3, '2012-03-13 16:51:43', 3, 'cse502', 'telecommunication business management.', 'Spring', 2012),
(4, '2012-03-14 04:56:12', 4, '303', 'telecommunicaton', 'Summer', 2014),
(5, '2012-03-14 11:50:27', 5, '2', 'as', 'Spring', 2012),
(6, '2012-03-14 11:51:23', 5, '11', 'cse594', 'Spring', 2012),
(7, '2012-03-20 11:22:02', 5, 'aa', 'aa', 'Spring', 2012),
(8, '2012-03-20 11:22:10', 5, 'ss', 'ss', 'Spring', 2012);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_info`
--

CREATE TABLE IF NOT EXISTS `faculty_info` (
  `fac_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_id_no` varchar(20) NOT NULL,
  `fac_name` varchar(100) NOT NULL,
  `fac_desig` varchar(100) NOT NULL,
  `fac_join_date` date NOT NULL,
  PRIMARY KEY (`fac_id_no`),
  UNIQUE KEY `fac_id` (`fac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `faculty_info`
--

INSERT INTO `faculty_info` (`fac_id`, `date_time`, `fac_id_no`, `fac_name`, `fac_desig`, `fac_join_date`) VALUES
(1, '2012-03-13 16:25:37', '1', 'Shazzad', 'Asst. Pof', '2012-01-01'),
(2, '2012-03-13 16:48:05', '2', 'Dr. abul l haque', 'Professor', '0000-00-00'),
(3, '2012-03-13 16:48:55', '5', 'Dr. abdul awal', 'dr. professor', '0000-00-00'),
(4, '2012-03-14 04:55:28', '6', 'lutfunnar', 'professor', '0000-00-00'),
(5, '2012-03-14 11:49:55', '7', 'j', 'dr. professor', '2012-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `fac_course_details`
--

CREATE TABLE IF NOT EXISTS `fac_course_details` (
  `fc_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fc_fac_id` int(11) NOT NULL,
  `fc_course_id` int(11) NOT NULL,
  UNIQUE KEY `fc_id` (`fc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `fac_course_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `std_course_details`
--

CREATE TABLE IF NOT EXISTS `std_course_details` (
  `sc_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sc_std_id` int(11) NOT NULL,
  `sc_fac_id` int(11) NOT NULL,
  `sc_course_id` int(11) NOT NULL,
  `sc_grade` decimal(3,2) NOT NULL,
  UNIQUE KEY `sc_id` (`sc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `std_course_details`
--

INSERT INTO `std_course_details` (`sc_id`, `date_time`, `sc_std_id`, `sc_fac_id`, `sc_course_id`, `sc_grade`) VALUES
(1, '2012-03-13 16:26:47', 111402651, 1, 1, '3.50'),
(2, '2012-03-13 16:27:00', 111402651, 1, 1, '3.42'),
(3, '2012-03-13 16:27:13', 111402651, 1, 1, '3.80'),
(4, '2012-03-13 16:52:11', 1111111, 3, 2, '4.00'),
(5, '2012-03-13 16:52:43', 4200, 2, 2, '0.00'),
(6, '2012-03-13 16:53:31', 4200, 2, 2, '0.00'),
(7, '2012-03-14 04:58:19', 11, 4, 2, '0.00'),
(8, '2012-03-14 04:58:38', 1111111, 2, 2, '3.80'),
(9, '2012-03-14 11:54:13', 11, 5, 6, '3.80'),
(10, '2012-05-21 12:05:28', 930365050, 1, 6, '9.99');

-- --------------------------------------------------------

--
-- Table structure for table `std_info`
--

CREATE TABLE IF NOT EXISTS `std_info` (
  `std_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `std_id_no` varchar(20) NOT NULL,
  `std_name` varchar(100) NOT NULL,
  `std_address` text NOT NULL,
  PRIMARY KEY (`std_id_no`),
  UNIQUE KEY `std_id` (`std_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `std_info`
--

INSERT INTO `std_info` (`std_id`, `date_time`, `std_id_no`, `std_name`, `std_address`) VALUES
(1, '2012-03-13 16:23:11', '111402651', 'Rahim', 'Dhaka'),
(3, '2012-03-13 16:44:52', '0930365050', 'rozana alam', '23, radhika mohan bosakhlane, dhaka-1100'),
(4, '2012-03-13 16:45:45', '4200', 'anamul haque', 'concordia university, canada.'),
(6, '2012-03-14 04:53:33', '11', 'lota', 'motijhil'),
(7, '2012-03-14 11:48:01', '111', 'x', 'aa');