CREATE DATABASE IF NOT EXISTS `studb`;

USE `studb`;

CREATE TABLE
    IF NOT EXISTS `tblFaculties` (
        `facId` INT PRIMARY KEY AUTO_INCREMENT,
        `facultyName` VARCHAR(100)
    );

CREATE TABLE
    IF NOT EXISTS `tblGenerations` (
        `genId` INT PRIMARY KEY AUTO_INCREMENT,
        `Generation` INT,
        `facId` INT,
        FOREIGN KEY (`facId`) REFERENCES `tblFaculties` (`facId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblStudyGroups` (
        `gId` INT PRIMARY KEY AUTO_INCREMENT,
        `StudyGroup` INT,
        `genId` INT,
        `facId` INT,
        FOREIGN KEY (`genId`) REFERENCES `tblGenerations` (`genId`),
        FOREIGN KEY (`facId`) REFERENCES `tblFaculties` (`facId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblStudents` (
        `stuId` INT PRIMARY KEY AUTO_INCREMENT,
        `stuName` VARCHAR(50),
        `gender` VARCHAR(7),
        `dob` DATE,
        `pob` TEXT,
        `phone` VARCHAR(20),
        `email` VARCHAR(100) UNIQUE,
        `address` TEXT,
        `facId` INT,
        `genId` INT,
        `gId` INT,
        `regDate` DATE,
        `ModifiedDate` DATE,
        FOREIGN KEY (`facId`) REFERENCES `tblFaculties` (`facId`),
        FOREIGN KEY (`genId`) REFERENCES `tblGenerations` (`genId`),
        FOREIGN KEY (`gId`) REFERENCES `tblStudyGroups` (`gId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblSemesters` (
        `semId` INT PRIMARY KEY AUTO_INCREMENT,
        `semester` INT
    );

CREATE TABLE
    IF NOT EXISTS `tblYears` (
        `yearId` INT PRIMARY KEY AUTO_INCREMENT,
        `YearsS` INT
    );

CREATE TABLE
    IF NOT EXISTS `tblSubjects` (
        `subId` INT PRIMARY KEY AUTO_INCREMENT,
        `subjectName` VARCHAR(100),
        `semId` INT,
        `facId` INT,
        `yearId` INT,
        FOREIGN KEY (`semId`) REFERENCES `tblSemesters` (`semId`),
        FOREIGN KEY (`facId`) REFERENCES `tblFaculties` (`facId`),
        FOREIGN KEY (`yearId`) REFERENCES `tblYears` (`yearId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblRegistrations` (
        `regId` INT PRIMARY KEY AUTO_INCREMENT,
        `stuId` INT,
        `semId` INT,
        `yearId` INT,
        `regDate` DATE,
        `ModifiedDate` DATE,
        `startDate` DATE,
        `endDate` DATE,
        FOREIGN KEY (`stuId`) REFERENCES `tblStudents` (`stuId`),
        FOREIGN KEY (`semId`) REFERENCES `tblSemesters` (`semId`),
        FOREIGN KEY (`yearId`) REFERENCES `tblYears` (`yearId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblAttendance` (
        `attId` INT PRIMARY KEY AUTO_INCREMENT,
        `subId` int,
        `stuId` INT,
        `regId` INT,
        `regAtt` VARCHAR(20),
        `regDate` DATE,
        `ModofiedDate` DATE,
        FOREIGN KEY (`stuId`) REFERENCES `tblStudents` (`stuId`),
        FOREIGN KEY (`regId`) REFERENCES `tblRegistrations` (`regId`)
    );

CREATE TABLE
    IF NOT EXISTS `tblScores` (
        `scId` INT PRIMARY KEY AUTO_INCREMENT,
        `regId` INT,
        `subId` INT,
        `score` FLOAT,
        `regDate` DATE,
        `ModifiedDate` DATE,
        FOREIGN KEY (`regId`) REFERENCES `tblRegistrations` (`regId`),
        FOREIGN KEY (`subId`) REFERENCES `tblSubjects` (`subId`)
    );

-- Default Data Inserts
INSERT INTO
    `tblFaculties` (`facultyName`)
VALUES
    ('Information Technology'),
    ('Computer Science'),
    ('Robotic'),
    ('Management'),
    ('Finance & Accounting'),
    ('Business Economics'),
    ('Tourism'),
    ('Law'),
    ('English'),
    ('Digital Economy'),
    ('International Law');

INSERT INTO
    `tblSemesters` (`semester`)
VALUES
    (1),
    (2);

INSERT INTO
    `tblYears` (`YearsS`)
VALUES
    (1),
    (2),
    (3),
    (4);

INSERT INTO
    `tblGenerations` (`Generation`)
VALUES
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7),
    (8),
    (9),
    (10);

INSERT INTO
    `tblStudyGroups` (`StudyGroup`)
VALUES
    (1),
    (2),
    (3),
    (4),
    (5);

INSERT INTO
    `tblSubjects` (`subjectName`, `semId`, `facId`, `yearId`)
VALUES
    -- =================================================================================
    -- FACULTY OF INFORMATION TECHNOLOGY (facId = 1)
    -- =================================================================================
    -- Year 1
    ('Introduction to IT', 1, 1, 1),
    ('Math for IT', 1, 1, 1),
    ('English for IT I', 1, 1, 1),
    ('Critical Thinking', 1, 1, 1),
    ('Logic and Problem Solving', 1, 1, 1),
    ('Introduction to Programming (C++)', 2, 1, 1),
    ('Computer Architecture', 2, 1, 1),
    ('English for IT II', 2, 1, 1),
    ('Discrete Mathematics', 2, 1, 1),
    ('Web Fundamentals (HTML/CSS)', 2, 1, 1),
    -- Year 2
    ('Object-Oriented Programming (Java)', 1, 1, 2),
    ('Data Structures and Algorithms', 1, 1, 2),
    ('Database Systems I', 1, 1, 2),
    ('Networking I', 1, 1, 2),
    ('Operating Systems', 1, 1, 2),
    ('Web Programming (PHP)', 2, 1, 2),
    ('Software Engineering', 2, 1, 2),
    ('Database Systems II', 2, 1, 2),
    ('Networking II', 2, 1, 2),
    ('Human-Computer Interaction', 2, 1, 2),
    -- Year 3
    ('Advanced Web Development (ASP.NET)', 1, 1, 3),
    ('Mobile Application Development', 1, 1, 3),
    ('Information Security', 1, 1, 3),
    ('System Analysis and Design', 1, 1, 3),
    ('Cloud Computing', 1, 1, 3),
    ('IT Project Management', 2, 1, 3),
    ('Data Mining and Warehousing', 2, 1, 3),
    ('Network Security', 2, 1, 3),
    ('Artificial Intelligence', 2, 1, 3),
    ('E-Commerce Technology', 2, 1, 3),
    -- Year 4
    ('Advanced Mobile Development', 1, 1, 4),
    ('Ethical Hacking and Defense', 1, 1, 4),
    ('Internet of Things (IoT)', 1, 1, 4),
    ('Big Data Analytics', 1, 1, 4),
    ('Final Project I', 1, 1, 4),
    ('IT Governance and Ethics', 2, 1, 4),
    ('Digital Forensics', 2, 1, 4),
    ('Blockchain Technology', 2, 1, 4),
    ('Machine Learning', 2, 1, 4),
    ('Final Project II', 2, 1, 4),
    -- =================================================================================
    -- FACULTY OF COMPUTER SCIENCE (facId = 2)
    -- =================================================================================
    -- Year 1
    ('Calculus I for CS', 1, 2, 1),
    ('Physics I (Mechanics)', 1, 2, 1),
    ('Programming Fundamentals', 1, 2, 1),
    ('Intro to Computer Systems', 1, 2, 1),
    ('Academic English for CS', 1, 2, 1),
    ('Calculus II for CS', 2, 2, 1),
    ('Physics II (E&M)', 2, 2, 1),
    ('Object-Oriented Programming', 2, 2, 1),
    ('Discrete Structures', 2, 2, 1),
    ('Digital Logic and Design', 2, 2, 1),
    -- Year 2
    ('Advanced Algorithms', 1, 2, 2),
    ('Theory of Computation', 1, 2, 2),
    ('Database Theory and Design', 1, 2, 2),
    ('Linear Algebra for CS', 1, 2, 2),
    ('Advanced Programming with Python', 1, 2, 2),
    ('Compiler Design', 2, 2, 2),
    ('Software Design Patterns', 2, 2, 2),
    ('Computer Graphics', 2, 2, 2),
    ('Probability and Statistics for CS', 2, 2, 2),
    ('Unix/Linux System Programming', 2, 2, 2),
    -- Year 3
    ('Artificial Intelligence Principles', 1, 2, 3),
    ('Cryptography and Network Security', 1, 2, 3),
    ('Distributed Systems', 1, 2, 3),
    ('Parallel Computing', 1, 2, 3),
    ('User Interface Design', 1, 2, 3),
    ('Machine Learning Foundations', 2, 2, 3),
    ('Natural Language Processing', 2, 2, 3),
    ('Computer Vision', 2, 2, 3),
    ('Advanced Database Systems', 2, 2, 3),
    ('Formal Methods', 2, 2, 3),
    -- Year 4
    ('Robotics and Automation', 1, 2, 4),
    ('Quantum Computing', 1, 2, 4),
    ('Research Methodology', 1, 2, 4),
    ('CS Elective I', 1, 2, 4),
    ('Graduation Thesis I', 1, 2, 4),
    ('High-Performance Computing', 2, 2, 4),
    ('Computational Biology', 2, 2, 4),
    ('CS Elective II', 2, 2, 4),
    ('Professional Ethics in CS', 2, 2, 4),
    ('Graduation Thesis II', 2, 2, 4),
    -- =================================================================================
    -- FACULTY OF ROBOTICS (facId = 3)
    -- =================================================================================
    -- Year 1
    ('Introduction to Engineering', 1, 3, 1),
    ('Calculus I', 1, 3, 1),
    ('Physics for Engineers I', 1, 3, 1),
    ('Programming for Engineers (Python)', 1, 3, 1),
    ('Technical Drawing', 1, 3, 1),
    ('Introduction to Robotics', 2, 3, 1),
    ('Calculus II', 2, 3, 1),
    ('Physics for Engineers II', 2, 3, 1),
    ('Digital Logic Design', 2, 3, 1),
    ('Workshop Practice', 2, 3, 1),
    -- Year 2
    ('Linear Algebra and ODEs', 1, 3, 2),
    ('Electric Circuits I', 1, 3, 2),
    ('Statics and Dynamics', 1, 3, 2),
    ('Data Structures for Robotics', 1, 3, 2),
    ('Sensors and Actuators', 1, 3, 2),
    ('Control Systems I', 2, 3, 2),
    ('Electric Circuits II', 2, 3, 2),
    ('Robot Kinematics', 2, 3, 2),
    ('Microcontrollers and Embedded Systems', 2, 3, 2),
    ('Mechanics of Materials', 2, 3, 2),
    -- Year 3
    ('Control Systems II', 1, 3, 3),
    ('Robot Dynamics and Control', 1, 3, 3),
    ('Machine Vision', 1, 3, 3),
    ('AI for Robotics', 1, 3, 3),
    ('Fluid Mechanics', 1, 3, 3),
    ('Digital Signal Processing', 2, 3, 3),
    ('Mobile Robots', 2, 3, 3),
    ('Industrial Automation', 2, 3, 3),
    ('Robot Programming (ROS)', 2, 3, 3),
    ('Mechatronics', 2, 3, 3),
    -- Year 4
    ('Advanced Robotics', 1, 3, 4),
    ('FPGA and System on Chip', 1, 3, 4),
    ('Human-Robot Interaction', 1, 3, 4),
    ('Robotics Elective', 1, 3, 4),
    ('Robotics Project I', 1, 3, 4),
    ('Autonomous Systems', 2, 3, 4),
    ('Biomedical Robotics', 2, 3, 4),
    ('Professional Engineering Ethics', 2, 3, 4),
    ('Entrepreneurship for Engineers', 2, 3, 4),
    ('Robotics Project II', 2, 3, 4),
    -- =================================================================================
    -- FACULTY OF MANAGEMENT (facId = 4)
    -- =================================================================================
    -- Year 1
    ('Principles of Management', 1, 4, 1),
    ('Business Mathematics', 1, 4, 1),
    ('Microeconomics', 1, 4, 1),
    ('Business English I', 1, 4, 1),
    ('Introduction to Business', 1, 4, 1),
    ('Principles of Marketing', 2, 4, 1),
    ('Macroeconomics', 2, 4, 1),
    ('Business Statistics', 2, 4, 1),
    ('Business English II', 2, 4, 1),
    ('Introduction to Accounting', 2, 4, 1),
    -- Year 2
    ('Organizational Behavior', 1, 4, 2),
    ('Financial Accounting', 1, 4, 2),
    ('Business Communication', 1, 4, 2),
    ('Human Resource Management', 1, 4, 2),
    ('Management Information Systems', 1, 4, 2),
    ('Business Law', 2, 4, 2),
    ('Managerial Accounting', 2, 4, 2),
    ('Operations Management', 2, 4, 2),
    ('Consumer Behavior', 2, 4, 2),
    ('Introduction to Finance', 2, 4, 2),
    -- Year 3
    ('Strategic Management', 1, 4, 3),
    ('Marketing Management', 1, 4, 3),
    ('Corporate Finance', 1, 4, 3),
    ('Supply Chain Management', 1, 4, 3),
    ('E-Business', 1, 4, 3),
    ('International Business', 2, 4, 3),
    ('Entrepreneurship', 2, 4, 3),
    ('Project Management', 2, 4, 3),
    ('Sales Management', 2, 4, 3),
    ('Business Research Methods', 2, 4, 3),
    -- Year 4
    ('Leadership and Ethics', 1, 4, 4),
    ('International Marketing', 1, 4, 4),
    ('Risk Management', 1, 4, 4),
    ('Quality Management', 1, 4, 4),
    ('Internship I', 1, 4, 4),
    ('Change Management', 2, 4, 4),
    ('Small Business Management', 2, 4, 4),
    ('Business Negotiation', 2, 4, 4),
    ('Graduation Project', 2, 4, 4),
    ('Internship II', 2, 4, 4),
    -- =================================================================================
    -- FACULTY OF FINANCE & ACCOUNTING (facId = 5)
    -- =================================================================================
    -- Year 1
    ('Principles of Accounting I', 1, 5, 1),
    ('Business Mathematics', 1, 5, 1),
    ('Microeconomics', 1, 5, 1),
    ('English for Finance I', 1, 5, 1),
    ('Introduction to Financial Systems', 1, 5, 1),
    ('Principles of Accounting II', 2, 5, 1),
    ('Business Statistics', 2, 5, 1),
    ('Macroeconomics', 2, 5, 1),
    ('English for Finance II', 2, 5, 1),
    ('Principles of Management', 2, 5, 1),
    -- Year 2
    ('Intermediate Accounting I', 1, 5, 2),
    ('Introduction to Finance', 1, 5, 2),
    ('Business Law for Finance', 1, 5, 2),
    ('Financial Markets', 1, 5, 2),
    ('Cost Accounting', 1, 5, 2),
    ('Managerial Accounting', 2, 5, 2),
    ('Financial Management', 2, 5, 2),
    ('Intermediate Accounting II', 2, 5, 2),
    ('Taxation I', 2, 5, 2),
    ('Money and Banking', 2, 5, 2),
    -- Year 3
    ('Advanced Accounting I', 1, 5, 3),
    ('Corporate Finance', 1, 5, 3),
    ('Auditing Principles', 1, 5, 3),
    ('Investment Analysis', 1, 5, 3),
    ('Accounting Information Systems', 1, 5, 3),
    ('Advanced Accounting II', 2, 5, 3),
    ('Portfolio Management', 2, 5, 3),
    ('Internal Audit and Control', 2, 5, 3),
    ('Taxation II', 2, 5, 3),
    ('Financial Derivatives', 2, 5, 3),
    -- Year 4
    ('International Finance', 1, 5, 4),
    ('Financial Statement Analysis', 1, 5, 4),
    ('Governmental Accounting', 1, 5, 4),
    ('Finance Seminar', 1, 5, 4),
    ('Thesis Project I', 1, 5, 4),
    ('Risk Management & Insurance', 2, 5, 4),
    ('Commercial Bank Management', 2, 5, 4),
    ('Accounting Theory & Practice', 2, 5, 4),
    ('Ethics in Finance & Accounting', 2, 5, 4),
    ('Thesis Project II', 2, 5, 4),
    -- =================================================================================
    -- FACULTY OF BUSINESS ECONOMICS (facId = 6)
    -- =================================================================================
    -- Year 1
    ('Principles of Economics', 1, 6, 1),
    ('Calculus for Economists I', 1, 6, 1),
    ('Academic Writing', 1, 6, 1),
    ('Introduction to Sociology', 1, 6, 1),
    ('Computer Applications for Economics', 1, 6, 1),
    ('Economic History', 2, 6, 1),
    ('Calculus for Economists II', 2, 6, 1),
    ('Statistics for Economists I', 2, 6, 1),
    ('Principles of Politics', 2, 6, 1),
    ('Introduction to Accounting', 2, 6, 1),
    -- Year 2
    ('Intermediate Microeconomics', 1, 6, 2),
    ('Intermediate Macroeconomics', 1, 6, 2),
    ('Statistics for Economists II', 1, 6, 2),
    ('History of Economic Thought', 1, 6, 2),
    ('Cambodian Economy', 1, 6, 2),
    ('Econometrics I', 2, 6, 2),
    ('Public Finance', 2, 6, 2),
    ('Managerial Economics', 2, 6, 2),
    ('Money and Banking', 2, 6, 2),
    ('International Economics', 2, 6, 2),
    -- Year 3
    ('Econometrics II', 1, 6, 3),
    ('Labor Economics', 1, 6, 3),
    ('Industrial Organization', 1, 6, 3),
    ('Development Economics', 1, 6, 3),
    ('Behavioral Economics', 1, 6, 3),
    ('International Trade Theory', 2, 6, 3),
    ('Environmental Economics', 2, 6, 3),
    ('Health Economics', 2, 6, 3),
    ('Economic Forecasting', 2, 6, 3),
    ('Research Methods in Economics', 2, 6, 3),
    -- Year 4
    ('Advanced Microeconomics', 1, 6, 4),
    ('Advanced Macroeconomics', 1, 6, 4),
    ('Public Policy Analysis', 1, 6, 4),
    ('Economics Elective I', 1, 6, 4),
    ('Senior Thesis I', 1, 6, 4),
    ('International Finance', 2, 6, 4),
    ('Economics of Regulation', 2, 6, 4),
    ('Game Theory', 2, 6, 4),
    ('Economics Elective II', 2, 6, 4),
    ('Senior Thesis II', 2, 6, 4),
    -- =================================================================================
    -- FACULTY OF TOURISM (facId = 7)
    -- =================================================================================
    -- Year 1
    ('Introduction to Tourism & Hospitality', 1, 7, 1),
    ('Tourism Geography', 1, 7, 1),
    ('Business English for Tourism I', 1, 7, 1),
    ('Principles of Management', 1, 7, 1),
    ('Khmer Culture and Civilization', 1, 7, 1),
    ('Principles of Marketing for Tourism', 2, 7, 1),
    ('World History and Tourism', 2, 7, 1),
    ('Business English for Tourism II', 2, 7, 1),
    ('Introduction to Accounting', 2, 7, 1),
    ('First Aid and Safety Management', 2, 7, 1),
    -- Year 2
    ('Travel Agency Management', 1, 7, 2),
    ('Hotel and Lodging Operations', 1, 7, 2),
    ('Tourism Economics', 1, 7, 2),
    ('Food and Beverage Management', 1, 7, 2),
    ('Cultural Heritage Tourism', 1, 7, 2),
    ('Event Management (MICE)', 2, 7, 2),
    ('Front Office Operations', 2, 7, 2),
    ('Sustainable Tourism', 2, 7, 2),
    ('Tourism Policy and Planning', 2, 7, 2),
    ('Housekeeping Operations', 2, 7, 2),
    -- Year 3
    ('Ecotourism', 1, 7, 3),
    ('Tour Guiding Techniques', 1, 7, 3),
    ('Tourism Marketing and Promotion', 1, 7, 3),
    ('Airline Ticketing and Reservations', 1, 7, 3),
    ('Human Resource in Hospitality', 1, 7, 3),
    ('Digital Marketing for Tourism', 2, 7, 3),
    ('Tourism Product Development', 2, 7, 3),
    ('Financial Management in Hospitality', 2, 7, 3),
    ('Service Quality Management', 2, 7, 3),
    ('Research Methods for Tourism', 2, 7, 3),
    -- Year 4
    ('Strategic Management for Tourism', 1, 7, 4),
    ('Special Interest Tourism', 1, 7, 4),
    ('Crisis Management in Tourism', 1, 7, 4),
    ('Tourism Entrepreneurship', 1, 7, 4),
    ('Internship I', 1, 7, 4),
    ('Current Issues in Tourism', 2, 7, 4),
    ('Destination Management & Marketing', 2, 7, 4),
    (
        'Cross-Cultural Communication in Tourism',
        2,
        7,
        4
    ),
    ('Tourism Law and Ethics', 2, 7, 4),
    ('Graduation Thesis', 2, 7, 4),
    -- =================================================================================
    -- FACULTY OF LAW & INTERNATIONAL LAW (facId = 8, 11)
    -- =================================================================================
    -- Year 1
    ('Introduction to Law and Legal Systems', 1, 8, 1),
    ('Khmer State and Constitution', 1, 8, 1),
    ('Legal English I', 1, 8, 1),
    ('Logic for Law Students', 1, 8, 1),
    ('History of Cambodian Law', 1, 8, 1),
    ('Constitutional Law', 2, 8, 1),
    ('Introduction to Criminal Law', 2, 8, 1),
    ('Legal English II', 2, 8, 1),
    ('Philosophy of Law', 2, 8, 1),
    ('Sociology of Law', 2, 8, 1),
    -- Year 2
    ('Contract Law I', 1, 8, 2),
    ('Administrative Law I', 1, 8, 2),
    ('Property Law', 1, 8, 2),
    ('Criminal Law I (General)', 1, 8, 2),
    ('Legal Research and Writing', 1, 8, 2),
    ('Contract Law II', 2, 8, 2),
    ('Administrative Law II', 2, 8, 2),
    ('Torts', 2, 8, 2),
    ('Criminal Law II (Specific Offenses)', 2, 8, 2),
    ('Family Law', 2, 8, 2),
    -- Year 3
    ('Civil Procedure I', 1, 8, 3),
    ('Criminal Procedure I', 1, 8, 3),
    ('Company Law', 1, 8, 3),
    ('Labor and Social Security Law', 1, 8, 3),
    ('Public International Law', 1, 11, 3),
    ('Civil Procedure II', 2, 8, 3),
    ('Criminal Procedure II', 2, 8, 3),
    ('Intellectual Property Law', 2, 8, 3),
    ('Environmental Law', 2, 8, 3),
    ('International Human Rights Law', 2, 11, 3),
    -- Year 4
    ('Legal Ethics and Profession', 1, 8, 4),
    ('Law of Evidence', 1, 8, 4),
    ('Insolvency and Bankruptcy Law', 1, 8, 4),
    (
        'Information Technology and E-Commerce Law',
        1,
        11,
        4
    ),
    ('Moot Court I', 1, 8, 4),
    ('Private International Law', 2, 11, 4),
    ('Taxation Law', 2, 8, 4),
    ('Legal Thesis Writing', 2, 8, 4),
    ('International Trade Law', 2, 11, 4),
    ('Internship in Law Firm', 2, 8, 4),
    -- =================================================================================
    -- FACULTY OF ENGLISH (facId = 9)
    -- =================================================================================
    -- Year 1
    ('Listening and Speaking I', 1, 9, 1),
    ('Reading and Writing I', 1, 9, 1),
    ('English Grammar in Use I', 1, 9, 1),
    ('Introduction to Phonetics', 1, 9, 1),
    ('Introduction to Literature', 1, 9, 1),
    ('Listening and Speaking II', 2, 9, 1),
    ('Reading and Writing II', 2, 9, 1),
    ('English Grammar in Use II', 2, 9, 1),
    ('Introduction to Linguistics', 2, 9, 1),
    ('Public Speaking', 2, 9, 1),
    -- Year 2
    ('Advanced Listening and Note-taking', 1, 9, 2),
    ('Advanced Reading Comprehension', 1, 9, 2),
    ('Advanced Composition', 1, 9, 2),
    ('Sociolinguistics', 1, 9, 2),
    ('Survey of British Literature I', 1, 9, 2),
    ('English for Business Communication', 2, 9, 2),
    ('Discourse Analysis', 2, 9, 2),
    ('Essay Writing', 2, 9, 2),
    ('Psycholinguistics', 2, 9, 2),
    ('Survey of British Literature II', 2, 9, 2),
    -- Year 3
    ('Translation Theory and Practice (K-E)', 1, 9, 3),
    ('Interpreting Skills I', 1, 9, 3),
    ('American Literature', 1, 9, 3),
    ('Semantics and Pragmatics', 1, 9, 3),
    (
        'Teaching English as a Foreign Language (TEFL) I',
        1,
        9,
        3
    ),
    ('Translation Practice (E-K)', 2, 9, 3),
    ('Interpreting Skills II', 2, 9, 3),
    ('World Literature in English', 2, 9, 3),
    ('Morphology and Syntax', 2, 9, 3),
    ('TEFL II: Classroom Management', 2, 9, 3),
    -- Year 4
    ('Creative Writing', 1, 9, 4),
    ('Literary Criticism', 1, 9, 4),
    ('Language Testing and Assessment', 1, 9, 4),
    ('English for Specific Purposes', 1, 9, 4),
    ('Research Paper I', 1, 9, 4),
    ('Business and Professional Writing', 2, 9, 4),
    ('Language, Culture, and Society', 2, 9, 4),
    ('Stylistics', 2, 9, 4),
    ('Second Language Acquisition', 2, 9, 4),
    ('Research Paper II', 2, 9, 4),
    -- =================================================================================
    -- FACULTY OF DIGITAL ECONOMY (facId = 10)
    -- =================================================================================
    -- Year 1 (Shared foundation with Business/Econ)
    ('Principles of Economics', 1, 10, 1),
    ('Calculus for Economists', 1, 10, 1),
    ('Introduction to Digital Technology', 1, 10, 1),
    ('Critical Thinking and Communication', 1, 10, 1),
    ('Introduction to Business', 1, 10, 1),
    ('Macroeconomics', 2, 10, 1),
    ('Statistics for Data Science', 2, 10, 1),
    ('Web Fundamentals for Business', 2, 10, 1),
    ('Digital Society and Ethics', 2, 10, 1),
    ('Principles of Marketing', 2, 10, 1),
    -- Year 2
    ('Economics of Digital Platforms', 1, 10, 2),
    ('Data Management and SQL', 1, 10, 2),
    ('E-Commerce and Digital Markets', 1, 10, 2),
    ('Digital Marketing and SEO', 1, 10, 2),
    ('Managerial Economics', 1, 10, 2),
    ('FinTech and Financial Innovation', 2, 10, 2),
    ('Data Visualization and Storytelling', 2, 10, 2),
    ('Social Media Analytics', 2, 10, 2),
    ('Cybersecurity for Business', 2, 10, 2),
    ('Supply Chain and E-Logistics', 2, 10, 2),
    -- Year 3
    (
        'Blockchain and Cryptocurrency Economics',
        1,
        10,
        3
    ),
    ('Applied Data Analytics with Python', 1, 10, 3),
    ('Digital Product Management', 1, 10, 3),
    ('AI in Business', 1, 10, 3),
    ('Platform Strategy', 1, 10, 3),
    (
        'Regulatory Environment of Digital Economy',
        2,
        10,
        3
    ),
    ('Cloud Economics', 2, 10, 3),
    ('User Experience (UX) Economics', 2, 10, 3),
    ('Network Economy', 2, 10, 3),
    ('Research Methods for Digital Economy', 2, 10, 3),
    -- Year 4
    ('Big Data for Economic Policy', 1, 10, 4),
    ('Digital Transformation Strategy', 1, 10, 4),
    ('Sharing Economy and Gig Work', 1, 10, 4),
    ('Elective in Digital Economy', 1, 10, 4),
    ('Graduation Project I', 1, 10, 4),
    ('Smart Cities and Urban Economics', 2, 10, 4),
    ('The Future of Work', 2, 10, 4),
    ('Venture Capital and Digital Start-ups', 2, 10, 4),
    ('International Digital Policy', 2, 10, 4),
    ('Graduation Project II', 2, 10, 4);