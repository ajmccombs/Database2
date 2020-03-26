/*
 Navicat MySQL Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : db2

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 2/12/2020 22:55:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `enroll`;
DROP TABLE IF EXISTS `enroll2`;
DROP TABLE IF EXISTS `assign`;
DROP TABLE IF EXISTS `mentors`;
DROP TABLE IF EXISTS `mentees`;
DROP TABLE IF EXISTS `material`;
DROP TABLE IF EXISTS `meetings`;
DROP TABLE IF EXISTS `time_slot`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `parents`;
DROP TABLE IF EXISTS `users`;

-- ----------------------------
-- Table structure for users
-- ----------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `p` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for parents
-- ----------------------------

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`),
  CONSTRAINT `parent_user` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for students
-- ----------------------------

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `student_parent` (`parent_id`),
  CONSTRAINT `student_user` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for admins
-- ----------------------------

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`),
  CONSTRAINT `admins_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for groups
-- ----------------------------

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `mentor_grade_req` int(11) NOT NULL,
  `mentee_grade_req` int(11) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for time_slot
-- ----------------------------

CREATE TABLE `time_slot` (
  `time_slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_of_the_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`time_slot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for meetings
-- ----------------------------

CREATE TABLE `meetings` (
  `meet_id` int(11) NOT NULL AUTO_INCREMENT,
  `meet_name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time_slot_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `announcement` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`meet_id`),
  KEY `meeting_group` (`group_id`),
  KEY `meeting_time_slot` (`time_slot_id`),
  CONSTRAINT `meeting_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_time_slot` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for material
-- ----------------------------

CREATE TABLE `material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `notes` text,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mentees
-- ----------------------------

CREATE TABLE `mentees` (
  `mentee_id` int(11) NOT NULL,
  PRIMARY KEY (`mentee_id`),
  CONSTRAINT `mentee_student` FOREIGN KEY (`mentee_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mentors
-- ----------------------------

CREATE TABLE `mentors` (
  `mentor_id` int(11) NOT NULL,
  PRIMARY KEY (`mentor_id`),
  CONSTRAINT `mentor_student` FOREIGN KEY (`mentor_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for enroll
-- ----------------------------

CREATE TABLE `enroll` (
  `meet_id` int(11) NOT NULL,
  `mentee_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`mentee_id`),
  KEY `enroll_mentee` (`mentee_id`),
  CONSTRAINT `enroll_mentee` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`mentee_id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for enroll2
-- ----------------------------

CREATE TABLE `enroll2` (
  `meet_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`mentor_id`),
  KEY `enroll2_mentor` (`mentor_id`),
  CONSTRAINT `enroll2_mentor` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`) ON DELETE CASCADE,
  CONSTRAINT `enroll2_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for assign
-- ----------------------------

CREATE TABLE `assign` (
  `meet_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`material_id`),
  KEY `assign_material` (`material_id`),
  KEY `assign_meetings` (`meet_id`),
  CONSTRAINT `assign_material` FOREIGN KEY (`material_id`) REFERENCES `material` (`material_id`) ON DELETE CASCADE,
  CONSTRAINT `assign_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;

---- mysql -u root db2 < [file name]

INSERT INTO users 
VALUES
(11, 'admin@gmail.com', 'admin', 'Admin', '781-555-0001'),
(01642069, 'SBarber@yahoo.com','p','Simon Barber','781-555-1234'),
(01642070, 'AMcCombs@gmail.com', 'p', 'Allan McCombs', '781-555-0001'),
(01642071, 'WillSmith@gmail.com', 'p', 'Will Smith', '781-555-0001'),
(01642072, 'JCena@gmail.com', 'p', 'John Cena', '781-555-0001'),
(01642073, 'SammySweetheart@gmail.com', 'p', 'Sammy Sweetheart', '781-555-0001'),
(01642074, 'SallySweetheart@gmail.com', 'p', 'Sally Sweetheart', '781-555-0001'),
(01642075, 'JohnSmith@gmail.com', 'p', 'John Smith', '781-555-0001'),
(01642082, 'KevinCelery@gmail.com', 'p', 'Kevin Celery', '781-555-0001'),
(01642083, 'CalvinCelery@gmail.com', 'p', 'Calvin Celery', '781-555-0001'),
(01642084, 'AdmaWest@gmail.com', 'p', 'Adman West', '781-555-0001'),
(01642085, 'Batman@gmail.com', 'p', 'Batman', '781-555-0001'),
(01642086, 'Mr.White@gmail.com', 'p', 'Walter White', '781-555-0001'),
(01642087, 'WalterJr@gmail.com', 'p', 'Walter White Jr', '781-555-0001');

INSERT INTO admins 
VALUES 
(11);

INSERT INTO parents
VALUES
(01642072),
(01642073),
(01642082), 
(01642086),
(01642085);

INSERT INTO students 
VALUES
(01642069, 12, 01642072),
(01642070, 11, 01642085),
(01642074, 10, 01642073),
(01642083, 4, 01642082),
(01642084, 6, 01642085),
(01642087, 3, 01642086);



INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 6', 6, 9, 6);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 7', 7, 10, 7);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 8', 8, 11, 8);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 9', 9, 12, 9);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 10', 10, 12, 10);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 11', 11, 12, 11);
INSERT INTO `groups` (`name`, `description`, `mentor_grade_req`, `mentee_grade_req`) VALUES ('Group 12', 12, 12, 12);


INSERT INTO time_slot
VALUES
(1, 'Saturday', '5:00', '6:00'),
(2, 'Saturday', '7:00', '8:00'),
(3, 'Saturday', '8:00', '9:00'),
(4, 'Saturday', '9:00', '10:00'),
(5, 'Saturday', '10:00', '11:00'),
(6, 'Sunday', '6:00', '7:00'),
(7, 'Sunday', '7:00', '8:00'),
(8, 'Sunday', '8:00', '9:00'),
(9, 'Sunday', '9:00', '10:00'),
(10, 'Sunday', '10:00', '11:00');

INSERT INTO meetings (meet_id, meet_name, date, time_slot_id, capacity, announcement, group_id)
VALUES
(1, 'Calculus 8.5', '2020-06-05', 1, 9, 'Chicken Pot Pie', 1),
(2, 'Russian', '2020-06-12', 1, 9, 'Chicken Pot Pie', 1),
(3, 'Scientology', '2020-06-19', 1, 9, 'Chicken Pot Pie', 1),
(4, 'Calculus 8.5', '2020-06-26', 3, 9, 'Chicken Pot Pie', 1),
(5, 'Russian', '2020-06-23', 4, 9, 'Chicken Pot Pie', 1),

(6, 'Scientology', '2020-06-05', 1, 9, 'Chicken Pot Pie', 2),
(7, 'Calculus 8.5',  '2020-06-12', 1, 9, 'Chicken Pot Pie', 2),
(8, 'Calculus 8.5', '2020-06-19', 1, 9, 'Chicken Pot Pie', 2),
(9, 'Russian', '2020-06-26', 1, 9, 'Chicken Pot Pie', 2),
(10, 'Russian', '2020-06-23', 1, 9, 'Chicken Pot Pie', 2),

(11, 'Calculus 8.5', '2020-06-05', 5, 9, 'Chicken Pot Pie', 3),
(12, 'Russian', '2020-06-12', 5, 9, 'Chicken Pot Pie', 3),
(13, 'Russian', '2020-06-19', 5, 9, 'Chicken Pot Pie', 3),
(14, 'Russian', '2020-06-26', 5, 9, 'Chicken Pot Pie', 3),
(15, 'Scientology', '2020-06-23', 5, 9, 'Chicken Pot Pie', 3),

(16, 'Calculus 8.5', '2020-06-05', 5, 9, 'Chicken Pot Pie', 3),
(17, 'Russian', '2020-06-12', 5, 9, 'Chicken Pot Pie', 3),
(18, 'Russian', '2020-06-19', 5, 9, 'Chicken Pot Pie', 3),
(19, 'Russian', '2020-06-26', 5, 9, 'Chicken Pot Pie', 3),
(22, 'Scientology', '2020-06-23', 5, 9, 'Chicken Pot Pie', 3);

INSERT INTO material (material_id, title, author, type, url, assigned_date, notes)
VALUES
(1, 'Conspiracy Theorist Alex Jones Arrested on DWI Charge', 'Will Sommer', 'article', 'https://www.thedailybeast.com/conspiracy-theorist-alex-jones-arrested-on-dwi-charge', '2020-03-26', 'none'),
(2, 'Conspiracy Theorist Alex Jones Arrested on DWI Charge', 'Will Sommer', 'article', 'https://www.thedailybeast.com/conspiracy-theorist-alex-jones-arrested-on-dwi-charge', '2020-03-26', 'none'),
(3, 'Conspiracy Theorist Alex Jones Arrested on DWI Charge', 'Will Sommer', 'article', 'https://www.thedailybeast.com/conspiracy-theorist-alex-jones-arrested-on-dwi-charge', '2020-03-26', 'none'),
(4, 'Conspiracy Theorist Alex Jones Arrested on DWI Charge', 'Will Sommer', 'article', 'https://www.thedailybeast.com/conspiracy-theorist-alex-jones-arrested-on-dwi-charge', '2020-03-26', 'none'),
(5, 'Conspiracy Theorist Alex Jones Arrested on DWI Charge', 'Will Sommer', 'article', 'https://www.thedailybeast.com/conspiracy-theorist-alex-jones-arrested-on-dwi-charge', '2020-03-26', 'none');

INSERT INTO mentees (mentee_id)
VALUES
(01642087),
(01642084),
(01642083);

INSERT INTO mentors (mentor_id)
VALUES
(01642069),
(01642070),
(01642074);

INSERT INTO enroll (meet_id, mentee_id)
VALUES
(1, 01642087),
(1, 01642084),
(1, 01642083),
(6, 01642083),
(6, 01642087),
(11, 01642084),
(11, 01642083),
(16, 01642087),
(16, 01642083),
(22, 01642084);

INSERT INTO enroll2 (meet_id, mentor_id)
VALUES
(1, 01642069),
(1, 01642070),
(6, 01642069),
(6, 01642070),
(11, 01642069),
(11, 01642070),
(11, 01642074),
(16, 01642069),
(16, 01642070),
(16, 01642074);

INSERT INTO assign (meet_id, material_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

