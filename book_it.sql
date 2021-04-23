-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2021 at 05:02 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment_dropoff`
--

DROP TABLE IF EXISTS `assignment_dropoff`;
CREATE TABLE IF NOT EXISTS `assignment_dropoff` (
  `dropoff_id` int(11) NOT NULL AUTO_INCREMENT,
  `dropoff_name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`dropoff_id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_dropoff`
--

INSERT INTO `assignment_dropoff` (`dropoff_id`, `dropoff_name`, `course_id`, `user_id`, `deadline`) VALUES
(5, 'Dropoff Point 2021', 4, 3, '2021-01-26'),
(7, 'Work Point 1', 4, 3, '2021-03-12'),
(8, 'Coding Dropoff', 4, 3, '2021-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `chatid` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userid` int(11) NOT NULL,
  `reciever_userid` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  PRIMARY KEY (`chatid`),
  KEY `sender_userid` (`sender_userid`,`reciever_userid`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chatid`, `sender_userid`, `reciever_userid`, `message`, `timestamp`, `status`) VALUES
(19, 3, 1, 'hello', '2020-12-26 09:20:48', 1),
(21, 3, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2020-12-26 14:00:05', 1),
(31, 3, 1, 'gf', '2020-12-26 16:54:05', 1),
(37, 3, 1, 'ads', '2020-12-26 17:00:11', 1),
(47, 1, 3, 'oh hello', '2020-12-27 06:45:02', 1),
(48, 3, 1, 'sup', '2020-12-27 06:45:46', 1),
(49, 3, 1, 'asd', '2020-12-27 06:48:24', 1),
(50, 1, 3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2020-12-27 06:53:09', 1),
(51, 1, 3, 'ad', '2020-12-27 07:32:36', 1),
(52, 1, 3, 'asd', '2020-12-27 07:32:41', 1),
(53, 1, 3, 'asd', '2020-12-27 07:32:50', 1),
(54, 1, 3, 'asd', '2020-12-27 07:33:43', 1),
(55, 1, 3, 'test', '2020-12-27 07:33:51', 1),
(56, 3, 1, 'hello', '2020-12-29 14:36:24', 1),
(57, 3, 1, 'asd', '2021-01-24 11:32:03', 1),
(58, 3, 1, 'as', '2021-01-24 11:33:29', 1),
(60, 3, 1, 'as', '2021-02-01 15:12:46', 0),
(61, 3, 1, 'testing', '2021-02-01 15:12:57', 0),
(63, 3, 2, 'test\n', '2021-02-01 15:17:58', 0),
(64, 3, 4, 'hello', '2021-02-01 15:26:14', 0),
(65, 3, 2, 'hey\n', '2021-02-01 15:28:02', 0),
(66, 3, 2, 'wow', '2021-02-01 15:28:21', 0),
(67, 3, 2, 'oshi', '2021-02-01 15:30:16', 0),
(68, 3, 1, 'lol', '2021-02-02 11:21:14', 0),
(69, 3, 2, 'wow', '2021-02-02 11:22:54', 0),
(70, 2, 4, 'hello there', '2021-02-03 12:21:08', 0),
(71, 3, 1, 'Hello', '2021-02-05 07:50:03', 0),
(72, 2, 5, 'hi there', '2021-02-08 15:54:48', 0),
(74, 2, 3, 'Hi sir', '2021-02-17 15:09:27', 0),
(75, 7, 2, 'Hi student', '2021-02-17 15:49:02', 0),
(76, 3, 5, 'Hi Katrina', '2021-02-23 02:26:54', 0),
(77, 2, 3, 'hello student', '2021-02-27 08:48:09', 0),
(78, 3, 2, 'hi sir', '2021-02-27 08:48:41', 0),
(79, 3, 2, 'hi sir', '2021-02-27 08:48:56', 0),
(80, 2, 5, 'hey there katrina', '2021-03-01 07:20:03', 0),
(81, 3, 2, 'Hello smith', '2021-03-01 13:48:46', 0),
(82, 2, 3, 'hello sir', '2021-03-01 13:49:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_session`
--

DROP TABLE IF EXISTS `chat_session`;
CREATE TABLE IF NOT EXISTS `chat_session` (
  `user_id` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`session`),
  KEY `session` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_session`
--

INSERT INTO `chat_session` (`user_id`, `session`) VALUES
(1, 3),
(2, 3),
(3, 4),
(4, 0),
(5, 2),
(6, 0),
(7, 2),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

DROP TABLE IF EXISTS `chat_users`;
CREATE TABLE IF NOT EXISTS `chat_users` (
  `user_sender_id` int(11) NOT NULL,
  `user_receiver_id` int(11) NOT NULL,
  `last_message_sent` datetime NOT NULL,
  PRIMARY KEY (`user_sender_id`,`user_receiver_id`),
  KEY `user_receiver_id` (`user_receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`user_sender_id`, `user_receiver_id`, `last_message_sent`) VALUES
(1, 3, '2021-02-05 15:50:03'),
(2, 3, '2021-03-01 21:49:20'),
(2, 4, '2021-02-03 20:21:08'),
(2, 5, '2021-03-01 15:20:03'),
(2, 7, '2021-02-17 23:49:02'),
(3, 1, '2021-02-05 15:50:03'),
(3, 2, '2021-03-01 21:49:20'),
(3, 4, '2021-02-01 23:26:14'),
(3, 5, '2021-02-23 10:26:54'),
(4, 2, '2021-02-03 20:21:08'),
(5, 2, '2021-03-01 15:20:04'),
(5, 3, '2021-02-23 10:26:54'),
(7, 2, '2021-02-17 23:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE IF NOT EXISTS `consultation` (
  `consult_id` int(11) NOT NULL AUTO_INCREMENT,
  `consult_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booking_status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booked_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`consult_id`),
  KEY `user_id` (`user_id`,`booked_user`),
  KEY `booked_user` (`booked_user`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consult_id`, `consult_date`, `start_time`, `end_time`, `booking_status`, `user_id`, `booked_user`) VALUES
(56, '2021-01-28', '10:00:00', '11:00:00', 1, 3, 4),
(57, '2021-02-04', '10:00:00', '11:00:00', 0, 3, NULL),
(58, '2021-01-22', '11:30:00', '12:30:00', 1, 3, 6),
(59, '2021-01-29', '11:30:00', '12:30:00', 0, 3, NULL),
(60, '2021-02-05', '11:30:00', '12:30:00', 1, 3, 6),
(62, '2021-01-26', '11:30:00', '12:30:00', 0, 3, NULL),
(72, '2021-03-02', '12:00:00', '13:00:00', 0, 3, NULL),
(73, '2021-02-10', '10:00:00', '11:00:00', 0, 3, NULL),
(74, '2021-02-17', '10:00:00', '11:00:00', 1, 3, 2),
(76, '2021-03-03', '10:00:00', '11:00:00', 1, 3, 2),
(79, '2021-02-19', '11:30:00', '12:30:00', 0, 3, NULL),
(80, '2021-02-18', '10:00:00', '11:00:00', 1, 3, 2),
(81, '2021-02-18', '10:30:00', '11:30:00', 1, 3, 2),
(82, '2021-02-23', '12:00:00', '13:00:00', 0, 3, NULL),
(83, '2021-03-03', '12:00:00', '13:00:00', 0, 3, NULL),
(84, '2021-03-10', '12:00:00', '13:00:00', 0, 3, NULL),
(85, '2021-03-17', '12:00:00', '13:00:00', 0, 3, NULL),
(86, '2021-03-24', '12:00:00', '13:00:00', 0, 3, NULL),
(87, '2021-03-31', '12:00:00', '13:00:00', 0, 3, NULL),
(88, '2021-04-07', '12:00:00', '13:00:00', 0, 3, NULL),
(89, '2021-03-03', '10:00:00', '11:00:00', 1, 3, 2),
(90, '2021-03-03', '10:00:00', '11:00:00', 1, 3, 2),
(91, '2021-03-05', '11:30:00', '12:30:00', 0, 3, NULL),
(92, '2021-03-04', '13:00:00', '14:00:00', 0, 3, NULL),
(93, '2021-03-04', '13:30:00', '14:30:00', 0, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_warning`
--

DROP TABLE IF EXISTS `consultation_warning`;
CREATE TABLE IF NOT EXISTS `consultation_warning` (
  `warning_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`warning_id`),
  KEY `warning_id` (`warning_id`),
  KEY `session_id` (`session_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation_warning`
--

INSERT INTO `consultation_warning` (`warning_id`, `user_id`, `session_id`) VALUES
(15, 6, 60);

-- --------------------------------------------------------

--
-- Table structure for table `consult_ban`
--

DROP TABLE IF EXISTS `consult_ban`;
CREATE TABLE IF NOT EXISTS `consult_ban` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `datetime` date NOT NULL,
  PRIMARY KEY (`ban_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consult_ban`
--

INSERT INTO `consult_ban` (`ban_id`, `user_id`, `datetime`) VALUES
(10, 2, '2021-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`) VALUES
(1, 'Database Management'),
(2, 'Introduction to AI'),
(3, 'Web Development'),
(4, 'Concurrent Programming'),
(5, 'Mobile App Development'),
(6, 'Introduction to Business'),
(7, 'Introduction to Data Science'),
(8, 'Mobile Application MBA'),
(9, 'Investigation Report'),
(10, 'IOS Programming');

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

DROP TABLE IF EXISTS `file_upload`;
CREATE TABLE IF NOT EXISTS `file_upload` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_upload`
--

INSERT INTO `file_upload` (`file_id`, `material_name`, `file_size`) VALUES
(27, 'Expense Tracking.xlsx', 26788),
(28, 'Expense Tracking.xlsx', 26788),
(29, 'Tutorial 7 SQE.docx', 14813),
(30, 'Tutorial 6 SQE.docx', 14137);

-- --------------------------------------------------------

--
-- Table structure for table `grading`
--

DROP TABLE IF EXISTS `grading`;
CREATE TABLE IF NOT EXISTS `grading` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `comments` longtext NOT NULL,
  `course_id` int(11) NOT NULL,
  `dropoff_id` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `dropoff_id` (`dropoff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grading`
--

INSERT INTO `grading` (`grade_id`, `user_id`, `marks`, `comments`, `course_id`, `dropoff_id`) VALUES
(5, 2, 69, 'good explanation', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `material_dropoff`
--

DROP TABLE IF EXISTS `material_dropoff`;
CREATE TABLE IF NOT EXISTS `material_dropoff` (
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `material_type` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`file_id`,`course_id`),
  KEY `file_id` (`file_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_dropoff`
--

INSERT INTO `material_dropoff` (`user_id`, `file_id`, `course_id`, `material_type`) VALUES
(3, 27, 4, 1),
(3, 28, 4, 2),
(7, 29, 1, 2),
(3, 30, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notif_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notif_content` text NOT NULL,
  `from_user` int(11) NOT NULL,
  `notif_date` date NOT NULL,
  PRIMARY KEY (`notif_id`),
  KEY `user_id` (`user_id`),
  KEY `from` (`from_user`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `quiz_id` int(255) NOT NULL AUTO_INCREMENT,
  `quiz_name` varchar(100) NOT NULL,
  `user_id` int(255) NOT NULL,
  `course_id` int(255) NOT NULL,
  PRIMARY KEY (`quiz_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_name`, `user_id`, `course_id`) VALUES
(11, 'quiz demo 1', 3, 4),
(17, 'quiz demo 2', 1, 4),
(18, 'quiz demo 3', 3, 4),
(19, 'HTML Basics', 3, 3),
(20, 'quiz demo 5', 3, 4),
(21, 'quiz demo X', 3, 4),
(22, 'website quiz', 3, 4),
(23, 'AI Basics', 3, 2),
(24, 'Is HTML a coding language?', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answer`
--

DROP TABLE IF EXISTS `quiz_answer`;
CREATE TABLE IF NOT EXISTS `quiz_answer` (
  `quiz_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_answer` mediumtext NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  PRIMARY KEY (`quiz_answer_id`),
  KEY `quiz_question_id` (`quiz_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_answer`
--

INSERT INTO `quiz_answer` (`quiz_answer_id`, `quiz_answer`, `correct_answer`, `quiz_question_id`) VALUES
(37, 'apple', 0, 12),
(38, 'bees', 0, 12),
(39, 'cat', 0, 12),
(40, 'dad', 1, 12),
(41, 'qwe', 0, 13),
(42, 'rty', 0, 13),
(43, 'asd', 1, 13),
(44, 'fgh', 0, 13),
(53, '1', 1, 16),
(54, '2', 0, 16),
(55, '3', 0, 16),
(56, '4', 0, 16),
(57, 'check', 1, 17),
(58, 'check', 0, 17),
(59, 'check', 0, 17),
(60, 'check', 0, 17),
(61, 'paragraph', 1, 18),
(62, 'header', 0, 18),
(63, 'body', 0, 18),
(64, 'footer', 0, 18),
(65, 'Hyper Transformative Main Language', 0, 19),
(66, 'HyperText Markup Line', 0, 19),
(67, 'HyperText Markup Language', 1, 19),
(68, 'HomeTool Main Line', 0, 19),
(69, 'Mozilla', 0, 20),
(70, 'Microsoft', 0, 20),
(71, 'Google', 0, 20),
(72, 'The World Wide Web Consortium', 1, 20),
(73, 'HyperText Markup Language', 1, 21),
(74, 'HTML', 0, 21),
(75, 'Test 2', 0, 21),
(76, 'Test 3', 0, 21),
(77, 'Hard Disk Drive', 1, 22),
(78, 'Hyper Disk Drive', 0, 22),
(79, 'High Definition Drive', 0, 22),
(80, 'High Disk Drive', 0, 22),
(89, 'Artificial Igloo', 0, 25),
(90, 'Artificial Intelligence', 1, 25),
(91, 'Actual Intelligence', 0, 25),
(92, 'Ambiguous Intelligence', 0, 25),
(93, 'Moo', 1, 26),
(94, 'Bark', 0, 26),
(95, 'Meow', 0, 26),
(96, 'Gloop', 0, 26);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

DROP TABLE IF EXISTS `quiz_question`;
CREATE TABLE IF NOT EXISTS `quiz_question` (
  `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_question` longtext NOT NULL,
  `quiz_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`quiz_question_id`),
  KEY `quiz_id_fk` (`quiz_id_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_question_id`, `quiz_question`, `quiz_id_fk`) VALUES
(12, 'testing 1', 11),
(13, 'test 2', 11),
(16, 'no 1 is ?', 17),
(17, 'check check', 18),
(18, 'What does <p> tag represents?', 19),
(19, 'What does HTML stand for?', 19),
(20, 'Who is making the Web standards?', 19),
(21, 'What does HTML stands for', 20),
(22, 'What is a HDD?', 22),
(25, 'What does AI stand for?', 23),
(26, 'Cow says', 24);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_score`
--

DROP TABLE IF EXISTS `quiz_score`;
CREATE TABLE IF NOT EXISTS `quiz_score` (
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `quiz_date` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_score`
--

INSERT INTO `quiz_score` (`user_id`, `quiz_id`, `score`, `quiz_date`) VALUES
(4, 11, 2, '2021-02-11 03:44:13'),
(5, 11, 1, '2021-02-11 03:44:27'),
(2, 18, 0, '2021-02-11 17:53:46'),
(2, 17, 1, '2021-02-17 23:11:23'),
(2, 11, 1, '2021-02-17 23:50:56'),
(2, 20, 1, '2021-02-23 10:34:53'),
(2, 17, 0, '2021-02-28 18:14:54'),
(2, 23, 1, '2021-03-01 16:13:48'),
(2, 22, 0, '2021-03-01 21:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

DROP TABLE IF EXISTS `submission`;
CREATE TABLE IF NOT EXISTS `submission` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dropoff_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`submission_id`),
  KEY `user_id` (`user_id`),
  KEY `dropoff_id` (`dropoff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`submission_id`, `user_id`, `dropoff_id`, `file_name`) VALUES
(4, 2, 5, 'Tutorial 6 SQE.docx'),
(5, 2, 7, 'AAPLTest.csv'),
(6, 5, 7, 'Mock Exam IMNPD.docx'),
(7, 2, 8, 'CT118-3-3 ODL Optimisation and Deep Learning (VD1) 6 January 2020.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role` int(11) NOT NULL,
  `intake` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_role`, `intake`) VALUES
(1, 'Rose', '$2y$10$QIwZ1kybM9ZFud8qDsqKHO6LQb3AmXE849FYfhzVZI43kGa2zZFJC', 1, 'Senior Lecturer'),
(2, 'Smith', '$2y$10$CNWifiFgV7BmQdnYxcm/9ODkXCP5eTI52VCt983pMXSXhLLY1iloe', 0, 'AC2021SE'),
(3, 'Adam', '$2y$10$9VaTb/owSqw8UprbqQjZS.ImFkHerQo6yJp5NdAUzAUriyMEeX9Da', 1, 'Lecturer'),
(4, 'Merry', '$2y$10$f07bHZXKDkuL2PWuq9ZotOvtOXbvY1nN5BCLPPrDmyrTuUCjD.79y', 1, 'Lecturer'),
(5, 'Katrina', '$2y$10$R4q2F9UYxRLVhVfPk6X96.ac86jvjipUJT2m8fGO8ig.F/r2rrs.2', 0, 'AC2021SD'),
(6, 'Rhodes', '$2y$10$ixQ4gxNtp66vOqgi2kF33OVDJY97EFJFM1S/CAr9wdlUSaSFiYkwe', 1, 'Web Lecturer'),
(7, 'admin', '$2y$10$GXZu5111gG7R3vE69WDhr.jjuCEpKpgtguZhs2keEQwOSu7gZ6Xaq', 2, 'admin'),
(8, 'David', '$2y$10$tZJPRJlQr8bluqp2hfCJ5.mIJ9NgvpdTVIHPnrgENMhkQGm1gOhq.', 0, 'UC3F2020SE'),
(9, 'Rachel', '$2y$10$s.zHNRaOS2RjvQw9vCJwEeYg6.3Nr8DFES8RMnPlpUGHGRIGsA5Cu', 0, 'UCDF1079AU'),
(10, 'Ken', '$2y$10$YPQ2JifZs.4SEIqBYBa3UOI50aOmKlOTsqZFpMAKC3CYny7GV6CgG', 1, 'Web Designer Lecturer'),
(11, 'Eren', '$2y$10$S.4MAjQPHismwVllIKBCYultD7n7s8KdXHop0K.OXTgSlmI57jSw2', 0, 'UC3F2009SE'),
(12, 'QX', '$2y$10$KmCp.96Kx3w8M2vgyBk6Ue9YZ1OZH1ISJTRV16t1YSXLK0Oe2BFXi', 1, 'Senior Developer');

-- --------------------------------------------------------

--
-- Table structure for table `user_course`
--

DROP TABLE IF EXISTS `user_course`;
CREATE TABLE IF NOT EXISTS `user_course` (
  `ledger_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `datetimestamp` datetime NOT NULL,
  `previous_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`ledger_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_course`
--

INSERT INTO `user_course` (`ledger_id`, `user_id`, `course_id`, `datetimestamp`, `previous_hash`) VALUES
(1, 1, 2, '2021-02-16 22:50:14', '0'),
(2, 1, 3, '2021-02-16 22:50:56', '$2y$10$VyEiyZf9LhplzFCJQqvP7u7Gduf/BxQm3pYZ9utxZ9wlEoQwb9U5K'),
(3, 1, 4, '2021-02-16 22:53:51', '$2y$10$5z1KBm3gbTy8hkiNvFXfRuMcRKRUpOZQq5pPEglkqetucZ5J7WhOO'),
(4, 1, 5, '2021-02-16 22:54:53', '$2y$10$JdUFI2rD5j7ILmgIfvmoeuKOsXyjOhiaO0CO6ahF7.9hYMJUzs5ny'),
(5, 2, 1, '2021-02-16 22:55:37', '$2y$10$ingOoQPOHeNJDvnLIUu/2ubNOkHWko1.qCyVhrUL1hhlPrfaagf6q'),
(6, 2, 2, '2021-02-16 23:48:03', '$2y$10$5r3tu2oTHOEZ8VCpI.5SQOt/JnrB3RdFXVaYl.siHKD.wYPxFW7pK'),
(7, 2, 4, '2021-02-16 23:48:35', '$2y$10$CDEwPO5kc6dH4Ns0JCNLvO7Csey0c.bSsWHFuuEI8BGkRU9r3.UL.'),
(8, 3, 2, '2021-02-16 23:49:10', '$2y$10$eJ.iV8cwWKLxDYSFdEm12OWcgqji5bvBz9Nx/b3rlPxW2RLwLrZPu'),
(9, 3, 3, '2021-02-16 23:50:20', '$2y$10$5Wa8bFbTbyIpMlYrP8aq1OVjHm284DrrljgYpMNlsa0npHWUwxaR2'),
(10, 3, 4, '2021-02-16 23:51:03', '$2y$10$JIrmLwnpbjSjnmm.kw5/Aea2yXdcHXyfDalMhDZosff/jz0w8Dw2i'),
(11, 5, 1, '2021-02-16 23:52:02', '$2y$10$zIEKychUpGbTAio5HgHqdeGgZfVBhap7nwYHiNUSKSbwTbP1bmOs2'),
(12, 5, 3, '2021-02-16 23:52:33', '$2y$10$rnzXFHcULHnoJT6zKDi8WuYYhhDT0lmeqAzp32Kxhv8yr71cvuNQa'),
(16, 5, 4, '2021-02-17 00:33:59', '$2y$10$PkPuMAakzTCUmwfIF/Dp9eTL/SPyCuNKbHa4RjqKLYLk3QfTCGxYS'),
(17, 10, 7, '2021-02-26 17:43:53', '$2y$10$oiEJL5dL5LMqboXOzaIvL.zGjGcinYZOefV4m9QYlnbCSGwbdSDau'),
(18, 11, 9, '2021-03-01 16:46:45', '$2y$10$HbidQItvRB9v6anCTDwYxud8iaJQ96RKZuucN3RumzD/OSW82876q'),
(19, 12, 2, '2021-03-01 22:01:02', '$2y$10$yvJXBibvctwFX//QQlea4emubXHmM1E0F5sXUdT7SMLDgifSjNijS');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `chat_users_ibfk_1` FOREIGN KEY (`user_sender_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `chat_users_ibfk_2` FOREIGN KEY (`user_receiver_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`booked_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `consultation_warning`
--
ALTER TABLE `consultation_warning`
  ADD CONSTRAINT `consultation_warning_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `consultation_warning_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `consultation` (`consult_id`);

--
-- Constraints for table `consult_ban`
--
ALTER TABLE `consult_ban`
  ADD CONSTRAINT `consult_ban_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `grading`
--
ALTER TABLE `grading`
  ADD CONSTRAINT `grading_ibfk_1` FOREIGN KEY (`dropoff_id`) REFERENCES `assignment_dropoff` (`dropoff_id`);

--
-- Constraints for table `material_dropoff`
--
ALTER TABLE `material_dropoff`
  ADD CONSTRAINT `material_dropoff_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`),
  ADD CONSTRAINT `material_dropoff_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `material_dropoff_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`from_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `quiz_answer`
--
ALTER TABLE `quiz_answer`
  ADD CONSTRAINT `quiz_answer_ibfk_1` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_question` (`quiz_question_id`);

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quiz_id_fk`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz_score`
--
ALTER TABLE `quiz_score`
  ADD CONSTRAINT `quiz_score_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `quiz_score_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `submission_ibfk_2` FOREIGN KEY (`dropoff_id`) REFERENCES `assignment_dropoff` (`dropoff_id`);

--
-- Constraints for table `user_course`
--
ALTER TABLE `user_course`
  ADD CONSTRAINT `user_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
