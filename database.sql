CREATE DATABASE `studb`;
USE `studb`;

CREATE TABLE `tblStudents` (
    `stuId` int primary key auto_increment,
    `stuName` varchar(50),
    `gender` varchar(7),
    `dob` date,
    `pob` text,
    `phone` int,
    `email` varchar(100) unique,
    `address` text,
    `facId` int,
    `genId` int,
    `gId` int,
    `regDate` date,
    `ModifiedDate` date
);

CREATE TABLE `tblSemesters` (
    `semId` int primary key,
    `semester` int
);

CREATE TABLE `tblYears` (
    `yearId` int primary key,
    `YearsS` int
);

CREATE TABLE `tblFaculties` (
    `facId` int primary key,
    `facultyName` varchar(100)
);

CREATE TABLE `tblGenerations` (
    `genId` int primary key,
    `Generation` int,
    `facId` int,
    FOREIGN KEY (`facId`) REFERENCES `tblFaculties`(`facId`)
);

CREATE TABLE `tblStudyGroups` (
    `gId` int primary key,
    `StudyGroup` int,
    `genId` int,
    `facId` int,
    FOREIGN KEY (`genId`) REFERENCES `tblGenerations`(`genId`),
    FOREIGN KEY (`facId`) REFERENCES `tblFaculties`(`facId`)
);

CREATE TABLE `tblSubjects` (
    `subId` int primary key,
    `subjectName` varchar(100),
    `semId` int,
    `facId` int,
    `yearId` int,
    FOREIGN KEY (`semId`) REFERENCES `tblSemesters`(`semId`),
    FOREIGN KEY (`facId`) REFERENCES `tblFaculties`(`facId`),
    FOREIGN KEY (`yearId`) REFERENCES `tblYears`(`yearId`)
);

CREATE TABLE `tblRegistrations` (
    `regId` int primary key,
    `stuId` int,
    `semId` int, 
    `yearId` int,
    `regDate` date,
    `ModofiedDate` date,
    `startDate` date,
    `endDate` date,
    FOREIGN KEY (`stuId`) REFERENCES `tblStudents`(`stuId`),
    FOREIGN KEY (`semId`) REFERENCES `tblSemesters`(`semId`),
    FOREIGN KEY (`yearId`) REFERENCES `tblYears`(`yearId`)
);

CREATE TABLE `tblAttendance` (
    `attId` int primary key,
    `stuId` int,
    `regId` int,
    `regAtt` varchar(20),
    `regDate` date,
    `ModofiedDate` date,
    FOREIGN KEY (`stuId`) REFERENCES `tblStudents`(`stuId`),
    FOREIGN KEY (`regId`) REFERENCES `tblRegistrations`(`regId`)
);

CREATE TABLE `tblScores` (
    `scId` int primary key,
    `regId` int,
    `subId` int,
    `score` float,
    `regDate` date,
    `ModifiedDate` date,
    FOREIGN KEY (`regId`) REFERENCES `tblRegistrations`(`regId`),
    FOREIGN KEY (`subId`) REFERENCES `tblSubjects`(`subId`)
);

INSERT INTO `tblFaculties` (`facId`,`facultyName`) VALUES 
(1, 'Information Technology'),
(2, 'Computer Science'),
(3, 'Robotic'),
(4, 'Management'),
(5, 'Finance & Accounting'),
(6, 'Business Economics'),
(7, 'Tourism'),
(8, 'Law'),
(9, 'English'),
(10, 'Digital Economy'),
(11, 'International Law');