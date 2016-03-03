-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2012 at 01:03 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `accounts`
--
USE `idtsvbt_db_faculty`;

-- --------------------------------------------------------

--
-- Table structure for table `acc_request`
--

CREATE TABLE IF NOT EXISTS `acc_request` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` text,
  `acc_type` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_request`
--

INSERT INTO `acc_request` (`id`, `username`, `acc_type`) VALUES
(1, 'anil', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'idts', 'vardhman');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `acc_id` text,
  `fname` text,
  `email` text,
  `desg` text,
  `address` text,
  `mobile` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `acc_id`, `fname`, `email`, `desg`, `address`, `mobile`) VALUES
(1, '3', 'mitesh mandaliya', 'mitesh@gmail.com', 'c.c.', 'ctids', '9876543210');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `acc_id` text,
  `username` text,
  `password` text,
  `acc_type` text,
  `status` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `acc_id`, `username`, `password`, `acc_type`, `status`) VALUES
(1, NULL, 'mmm', 'mmm', 'student', '0'),
(2, '1', 'iammegamohan', 'm', 'student', '1'),
(3, '1', 'mitesh', 'm', 'faculty', '1'),
(4, '1', 'ms', 'ms', 'parents', '1'),
(5, '2', 'anil', 'jalaram', 'student', '0');

-- --------------------------------------------------------

--
-- Table structure for table `onlineuser`
--

CREATE TABLE IF NOT EXISTS `onlineuser` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `loginid` text,
  `username` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `onlineuser`
--

INSERT INTO `onlineuser` (`id`, `loginid`, `username`) VALUES
(1, 'uq42kfe2fdc5qla1648l3536j1', 'idts'),
(2, 'l51nec2lojlhq3dsu1mgt67n85', 'idts'),
(3, 'kem5a5978doioj4u9926ioq3c1', 'idts'),
(4, '6f2i751g75g8t7vl8p0ajuoeb5', 'idts'),
(7, '8g184ihd7ttpgdvnca1mocojo0', 'iammegamohan'),
(9, 'poohadd19akvkcif7q8ion9ml2', 'mitesh'),
(12, 'b1j8f4cdsc0r93trk58q3uivu3', 'iammegamohan'),
(13, 'sdhqpvk56mntsqkkfvc7lelu74', 'idts'),
(15, 'ui671efdqpmgdnaj5oumi6gl20', 'idts'),
(17, 'btvqc09tn1ato3katl0qbv0ck2', 'ms'),
(18, '9o5a45s84ptms6bkgtbh6896l4', 'idts'),
(25, '3iioqkqq6ftvehvrjet0ius6u6', 'idts'),
(29, 'nmm7arc5c3818hdcce00nln367', 'idts'),
(30, '8iap5d1at162ilp3kf59v64ee4', 'idts');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE IF NOT EXISTS `parents` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `acc_id` text,
  `fname` text,
  `enrollno` text,
  `email` text,
  `branch` text,
  `sem` text,
  `qual` text,
  `occ` text,
  `address` text,
  `mobile` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `acc_id`, `fname`, `enrollno`, `email`, `branch`, `sem`, `qual`, `occ`, `address`, `mobile`) VALUES
(1, '4', 'ms', '096520307037', 'iammegamohan@gmail.com', 'computer engineering', '6', 'qual', 'occ', 'address', '989');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` text,
  `permission` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `username`, `permission`) VALUES
(1, 'miteshljdfg', '0010000000000000000000'),
(2, '3', '0001110000000000000000'),
(3, 'mitesh', '1000000000000000000000');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `acc_id` text,
  `fname` text,
  `enrollno` text,
  `email` text,
  `branch` text,
  `sem` text,
  `mobile` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `acc_id`, `fname`, `enrollno`, `email`, `branch`, `sem`, `mobile`) VALUES
(1, '2', 'mohan sharma', '096520307037', 'iammegamohan@gmail.com', 'computer engineering', '6', '9722505033'),
(2, '5', 'anil amlani', '096520307018', 'anil27927@gmail.com', 'computer engineering', '6', '9428727927');
--
-- Database: `clgmg`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `enrollno` text,
  `udate` text,
  `subjects` text,
  `percentages` text,
  `notice` text,
  `crit` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `fname`, `enrollno`, `udate`, `subjects`, `percentages`, `notice`, `crit`) VALUES
(1, 'mohan sharma', '096520307037', '07-05-2012 04:39:32 AM', 'subj1|subj2|subj3', '56.56|66.6', 'nothing', '75'),
(2, 'mohan sharma', '096520307037', '07-05-2012 05:42:37 AM', 'subj1|subj2|subj3', '56.56|66.6', 'nothing', '75'),
(3, 'mohan sharma', '096520307037', '07-05-2012 05:42:43 AM', 'subj1|subj2|subj3', '56.56|66.6', 'nothing', '75');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `bname` text,
  `sem` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `bname`, `sem`) VALUES
(1, 'Computer Engineering', 'c.e.'),
(2, 'Information Technology', 'i.t.'),
(4, 'electrical engineering', 'e.e.'),
(6, 'mechanical engineering', 'm.e'),
(7, 'electronic and communication ', 'e.c.');

-- --------------------------------------------------------

--
-- Table structure for table `circular`
--

CREATE TABLE IF NOT EXISTS `circular` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `cdate` text,
  `cdesc` text,
  `link` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `circular`
--

INSERT INTO `circular` (`id`, `cdate`, `cdesc`, `link`) VALUES
(1, '02-05-2012 06:17:09 AM', 'gtu circulars', 'http://gtu.ac.in/institute.asp');

-- --------------------------------------------------------

--
-- Table structure for table `clgprofile`
--

CREATE TABLE IF NOT EXISTS `clgprofile` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `descs` text,
  `phone` text,
  `fax` text,
  `email` text,
  `address` text,
  `welcomemsg` text,
  `img` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clgprofile`
--

INSERT INTO `clgprofile` (`id`, `descs`, `phone`, `fax`, `email`, `address`, `welcomemsg`, `img`) VALUES
(1, 'c. u. shah technical institute of diploma studies wadhwancity is a self finance polytechnic institute managed by wardhman bharti trust,\r\naffiliated to technical education board (teb) - gandhinagar and gujarat technological university (gtu), for new entrant of a.y. 2008-09.', '+91-2752-294140', '+91-2752-242712', 'idtsvbt@yahoo.co.in', 'ahmedabad - surendranagar state highway, near kotharia village, wadhwan city - 363 030, (gujarat) india.', 'welcome to c.u.shah campus''s homepage... please login to your account to manage your profile details or if you are student then you can check your results and share your results to other friends via emails and also you can check your attendance, time-tables etc..', 'pics/1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tname` text,
  `tsubj` text,
  `tmsg` text,
  `tdate` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tdate` text,
  `dtitle` text,
  `ddesc` text,
  `links` text,
  `adder` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `dob` text,
  `qual` text,
  `expe` text,
  `depa` text,
  `desg` text,
  `subj` text,
  `address` text,
  `contact` text,
  `email` text,
  `img` text,
  `gender` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `fname`, `dob`, `qual`, `expe`, `depa`, `desg`, `subj`, `address`, `contact`, `email`, `img`, `gender`) VALUES
(1, 'khimabhai m der', '1/9/1962', 'b.e. e.c.', 'teaching: 2 years, industry: 22 years', 'computer engineering', 'lecturer and h.o.d', 'microwave engg, tv engg, enl , de', 'plot no 578/2, sector 6-b, gandhinagar ', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_khimabhai m der.jpg', 'male'),
(2, 'virat c. gandhi', '17/11/1986', 'b.e. it', '1 year, 5 months', 'computer engineering', 'lecturer', 'wc, dsm, project.', '6, laxminagar society, 80 ft road, nr. ghughri park, surendranagar .', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_virat c. gandhi.jpg', 'male'),
(3, 'pratik b parmar', '10/5/1987', 'b.e. computer', 'teaching:- 2 years industry:- 0.5 years', 'computer engineering', 'lecturer and c.c.', 'os,dbms,oa,c,c++,java,dsm', '9,mayurnagar-1,near meghani baag,surendranagar-363001 ', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_pratik b parmar.jpg', 'male'),
(4, 'hiral r mehta', '28/09/1986', 'b.e. computer', '1 year, 5 months', 'computer engineering', 'lecturer and c.c.', 'dbms, java, c, cmp, se, sad', 'shrinathji, b/h 9 arun society, dalmill road, surendranagar 363001', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(5, 'ajay d maru', '28/05/1987', 'b.e. computer', '1 year, 5 months', 'computer engineering', 'lecturer and c.c.', 'c, c++, dbms, cg, java', '17/5,geeta society, behind ghughri park, 80 ft road, surendranagar 363002 ', '7600962007', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(6, 'jignesh g gothi', '6/12/1986', 'b.e. computer', '10 months', 'computer engineering', 'lecturer', 'sql, coa, mppc, c, oa, ca', 'at. jasapar, taluka- dhangadhra, dist. surendranagar 363310 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(7, 'konark t dave', '21/04/1988', 'b.e. it', '5 months', 'computer engineering', 'lecturer', 'dsm, dbms', 'saideep, bapunagar road, nr. alka society, surendranagar, 363001 ', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_konark t dave.jpg', 'male'),
(8, 'mitesh p mandaliya', '3/9/1986', 'b.e. computer', '1 year, 6 months', 'computer engineering', 'lecturer', 'c++, dbms, c', 'vagheshwari krupa, behind mistri garage, opp. church, surendranagar- 363001 ', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_mitesh p mandaliya.jpg', 'male'),
(9, 'beena d chudasama', '14/02/1989', 'b.e. computer', '5 months', 'computer engineering', 'lecturer', 'c, oa, ca', 'jamka road, ramesh bakery, bagasara, dist. amreli 365440 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(10, 'ajaz i naimi', '4/11/1988', 'b.e. computer', '5 months', 'computer engineering', 'lecturer and c.c.', 'c, oa, maths', 'nr. seeta gate in jumma masjid, dhrangadhra 363310', '--', 'idtsvbt@yahoo.co.in', './faculty/faculty_ajaz i naimi.jpg', 'male'),
(11, 'dipesh n sompura', '17/07/1988', 'b.e. computer', '5 months', 'computer engineering', 'lecturer', 'c, oa', 'society, nr. g.e.b. office, wadhwan, dist. surendranagar ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(12, 'priya c patel', '9/7/1989', 'b.e. computer', '5 months', 'computer engineering', 'lecturer and c.c.', 'dwd', '37-b navrang society, street no 2, 80 ft road, surendranagar 363035 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(13, 'parag d patel', '3/10/1986', 'b.e. it', '2 year, 3 months', 'information technology', 'lecturer and c.c.', 'c, c++, sad, oa, iap, ca, dsm, iia', '47, tatanagar society, meghaninagar road, ahmedabad, 380016 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(14, 'Bhupat M Degama', '15/01/1984', 'b.e. mechanical', 'Industrial:- 1 Year Teaching :- 3 Years 6 Months', 'mechanical engineering', 'lecturer', 'ED,MD,TOM,PMS,ECC,Thermal Engg, Thermodynamics', 'zinzuda Taluka:- Chotila , Dist:- Surendranagar-363520 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(15, 'J M Jamnapara', '30/01/1949', 'b.e. mechanical', 'Teaching:- 35 years', 'mechanical engineering', 'lecturer and c.c.', 'ED,MD,MP,MT,MTT,PMS,Tool Engg,FT,EME', 'Kirtan, 3- Bhakti Nagar-2,B/H Swaminarayan temple, Umiya Mandir road,80 feet road, surendranagar ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(16, 'Aruna G Motka', '10/2/1984', 'b.e. production', '6 Years 8 Months', 'mechanical engineering', 'g.t.u co-ordinator', 'MTT,DME,TOOL,ME,ED,IM,IE,ANS,CAD CAM', '7/8,Pratap park society,B/H water tank,80 feet road,surendranagar ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(17, 'Suresh B Bavaliya', '1/1/1982', 'B.E. Mech , M.E(Purshuing)', '5 years 2 months', 'mechanical engineering', 'lecturer and h.o.d.', 'ED,MD,DME,FMHM,Auto Engg, Auto Transmission,Thermodynamics', 'Gorasu, Taluka:- Dhandhuka, Dist:- Surendranagar- 382463 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(18, 'Prashant P Purohit', '9/11/1985', 'b.e. ec', 'Teaching:- 6 MONTHS Industry:- 2 Year', 'electronic and communication', 'lecturer', 'DE,EMC,EWS,HRM', '5566,Hariom Nagar,BharatNagar,Bhavanagar - 364001', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(19, 'Neha B Patel', '5/11/1986', 'b.e. ec', '2 year, 3 months', 'electronic and communication', 'lecturer', 'E.M. &C. EDC, DE, HRM, CE, TTA, FOC, IE', 'Umiya Krupa, Madhavnagar Society, Nr. Chhabila Hanuman, Surendranagar 363001 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(20, 'Mitul P Shah', '28/12/1988', 'b.e. ec', '6 months', 'electronic and communication', 'lecturer', 'EDC,DE', 'Subhash Society, Near Main Water Tank,Surendranagar', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(21, 'Darshit A Parmar', '3/5/1989', 'b.e. ec', '6 months', 'electronic and communication', 'lecturer', 'HRM, DE,EWS,EMC', 'Plot No:-122, Umiya Township, New 80feet Road,Nr. Shivam Park, Surendranagar ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(22, 'Riddhi V Shah', '14/09/1988', 'b.e. eee', '5 months', 'electrical engineering', 'lecturer', 'FOE,EESE,ECT,NCES,HRM', '33 Chamunda park, 80 Feet Road Surendranagar ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female'),
(23, 'Vinod V Chavada', '9/3/1981', 'M.E (Elect. Power Engg)', 'Teaching:- 4 Years 4 Months Industrial:- 1 Year 10 Months', 'electrical engineering', 'lecturer', 'PSE,GET,SGP,EWEC & C, EMC,EC,DE,ACD&U', 'Jasapar, Taluka:- Dhrangadhra , Dist:- Surendranagar-363310 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(24, 'Devendra R Parmar', '31/08/1985', 'b.e. eee', 'Teaching:- 3 years Industrial:- 6 Months', 'electrical engineering', 'lecturer', 'EESE,NCES,CA,BE,IE,EWCC,Auto Cad', '17,Krishna Nagar Society,Nr. Muncipal School no9,BehramPura,Ahmedabad-28 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(25, 'Anil B Chauhan', '29/04/1987', 'b.e. eee', '2 years 5 Months', 'electrical engineering', 'lecturer and h.o.d.', 'EM,SGP', '45-Anupam Society,Nr Meghani Bagg, Surendranagar-363001 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'male'),
(26, 'Bhumika N Vasoya', '22/03/1987', 'b.e. eee', '1 years 6 Months', 'electrical engineering', 'lecturer', 'Generation and Transmission, BE', 'Opp:- T.B. Hosp, D/150 Umiyapark, Surendranagar-363001 ', '--', 'idtsvbt@yahoo.co.in', NULL, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `fees_details`
--

CREATE TABLE IF NOT EXISTS `fees_details` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `enrollno` text,
  `branch` text,
  `sem` text,
  `fees` text,
  `submitted` text,
  `ldate` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `latest_news`
--

CREATE TABLE IF NOT EXISTS `latest_news` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` text,
  `link` text,
  `adder` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fr` text,
  `tto` text,
  `msg` text,
  `td` text,
  `readed` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mgntp`
--

CREATE TABLE IF NOT EXISTS `mgntp` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` text,
  `respect` text,
  `post` text,
  `img` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `mgntp`
--

INSERT INTO `mgntp` (`id`, `name`, `respect`, `post`, `img`) VALUES
(1, 'c. u. shah', 'hon.', ' ', './mgntp/1.jpg'),
(2, 'c. t. chudgar', 'late', ' ', './mgntp/DrCTChutgar.jpg'),
(3, 'c. c. dadbhawala', 'late hon.', ' ', './mgntp/CCDadbhawala.jpg'),
(4, 'j. v. shah', 'late hon.', ' ', './mgntp/JVShah.jpg'),
(5, 'm. u. sheth', 'late hon.', ' ', './mgntp/MUSheth.jpg'),
(6, 'n. k. shah', 'late hon.', ' ', './mgntp/NKShah.jpg'),
(7, 'r. t. doshi', 'late hon.', ' ', './mgntp/RTDoshi.jpg'),
(8, 't. m. doshi 	', 'late hon.', ' ', './mgntp/TMDoshi.jpg'),
(9, 'n. t. doshi', 'hon.', ' ', './mgntp/NTDoshi.jpg'),
(10, 'r. h. narichania', 'hon.', ' ', './mgntp/RHNarichaniya.jpg'),
(11, 'mahendrabhai p. vora', 'shri.', 'president', './mgntp/MPVora.jpg'),
(12, 'rshikbhai h. narechaniya', 'shri.', 'vice president', './mgntp/Rshikbhai H. Narechaniya.jpg'),
(13, 'rshikbhai a. maniyar', 'shri.', 'vice president', './mgntp/Rshikbhai A. Maniyar.jpg'),
(14, 'nandalal t. doshi', 'shri.', 'treasurer', './mgntp/Nandalal T. Doshi.jpg'),
(15, 'jitendrabhai g. sanghvi', 'dr.', 'secretary', './mgntp/Dr. J. G. Sanghvi.jpg'),
(16, 'kiranbhai v. mehta', 'shri.', 'secretary', './mgntp/Shri K. V. Mehta.jpg'),
(17, 'c. u. shah', 'shri.', 'trustee', './mgntp/C.U.Shah.jpg'),
(18, 'k. m. sheth', 'shri.', 'trustee', './mgntp/K. M. Sheth.jpg'),
(19, 'harendrabhai c. shah', 'shri.', 'trustee', './mgntp/Shri H. C. Shah.jpg'),
(20, 'hemantbhai m. shah', 'shri.', 'trustee', './mgntp/Shri H. M. Shah.jpg'),
(21, 'maheshbhai p. vora', 'shri.', 'trustee', './mgntp/Maheshbhai P. Vora.jpg'),
(22, 'bhupatbhai v. shah', 'shri.', 'trustee', './mgntp/Bhupatbhai V. Shah.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notice_board`
--

CREATE TABLE IF NOT EXISTS `notice_board` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ndate` text,
  `ndesc` text,
  `branch` text,
  `sem` text,
  `link` text,
  `adder` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` text,
  `body` text,
  `auth` text,
  `pdesc` text,
  `adder` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `principal`
--

CREATE TABLE IF NOT EXISTS `principal` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `dob` text,
  `qual` text,
  `expe` text,
  `depa` text,
  `subj` text,
  `address` text,
  `contact` text,
  `email` text,
  `img` text,
  `during` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `principal`
--

INSERT INTO `principal` (`id`, `fname`, `dob`, `qual`, `expe`, `depa`, `subj`, `address`, `contact`, `email`, `img`, `during`) VALUES
(1, 'prof. hitesh h wandra', '26-04-1976', 'beec, meec (cse)', '11 years', 'electronics & communication', 'all subjects related with electronics & communication branch.', '--', '--', 'anil27927@gmail.com', NULL, '---');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `enrollno` text,
  `dob` text,
  `gender` text,
  `email` text,
  `address` text,
  `contact` text,
  `img` text,
  `branch` text,
  `sem` text,
  `spi` text,
  `cpi` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `fname`, `enrollno`, `dob`, `gender`, `email`, `address`, `contact`, `img`, `branch`, `sem`, `spi`, `cpi`) VALUES
(1, 'mohan sharma', '096520307037', '03-04-1993', 'male', 'iammegamohan@gmail.com', '&#2709;&#2759;&#2736;&#2751;&#2735;&#2750;&#2736;&#2763;&#2721; &#2736;&#2712;&#2753;&#2730;&#2724;&#2751; &#2728;&#2711;&#2736; 66 &#2744;&#2753;&#2732;&#2765;&#2744;&#2765;&#2719;&#2759;&#2742;&#2728; &#2693;&#2734;&#2765;&#2736;&#2759;&#2738;&#2751;	', '9722505033', './students/096520307037.jpg', 'computer engineering', '1', '9', '9'),
(2, 'mohan sharma', '096520307037', '03-04-1993', 'male', 'iammegamohan@gmail.com', 'amreli', '9722505033', './students/096520307037.jpg', 'computer engineering', '6', '9', '9'),
(3, 'anil amlani', '096520307018', '11-07-1992', 'male', 'anil27927@gmail.com', 'ranavav, porbandar', '9428727927', './students/096520307018.jpg', 'computer engineering', '1', '9', '9');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `email` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`) VALUES
(1, 'iammegamohan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE IF NOT EXISTS `timetable` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `branch` text,
  `sem` text,
  `titles` text,
  `links` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `toppers`
--

CREATE TABLE IF NOT EXISTS `toppers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `enrollno` text,
  `rank` text,
  `spi` text,
  `sem` text,
  `branch` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `toppers`
--

INSERT INTO `toppers` (`id`, `fname`, `enrollno`, `rank`, `spi`, `sem`, `branch`) VALUES
(1, 'mohan sharma', '096520307037', '1', '9', '1', 'computer engineering');
--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `atitle` text,
  `adesc` text,
  `atype` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `atitle`, `adesc`, `atype`) VALUES
(1, 'diploma building', 'diploma main  building.', 'photos'),
(2, 'college images.', 'our college images....!!', 'photos');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ptitle` text,
  `pdesc` text,
  `album` text,
  `plink` text,
  `public` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `ptitle`, `pdesc`, `album`, `plink`, `public`) VALUES
(1, 'diploma building.', 'our diploma  main building.', 'diploma building', './gallery/diploma building_diploma building..jpg', 'y'),
(2, 'diploma building.', 'our diploma  main building.', 'diploma building', './gallery/diploma building_diploma building..jpg', 'y'),
(3, ' college fountain.', 'our  clg foutain.', 'college images.', './gallery/college images._ college fountain..jpg', 'y'),
(4, 'lighting  in fountain .', 'our clg  foutain  with lighting.', 'diploma building', './gallery/diploma building_lighting  in fountain ..jpg', 'y'),
(5, 'main building.', 'main building  of our college. ', 'college images.', './gallery/college images._main building..jpg', 'y'),
(6, 'main building image.', 'near view of main building', 'college images.', './gallery/college images._main building image..jpg', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `vtitle` text,
  `vdesc` text,
  `album` text,
  `vlink` text,
  `vimg` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Database: `results`
--

-- --------------------------------------------------------

--
-- Table structure for table `computerengineering1internal03041993_1336368752`
--

CREATE TABLE IF NOT EXISTS `computerengineering1internal03041993_1336368752` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `enrollno` text,
  `fname` text,
  `subjects` text,
  `marks` text,
  `outof` text,
  `fail` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `computerengineering1internal03041993_1336368752`
--

INSERT INTO `computerengineering1internal03041993_1336368752` (`id`, `enrollno`, `fname`, `subjects`, `marks`, `outof`, `fail`) VALUES
(1, '00000', 'administrator', 'java|cpp|dcc|cm', NULL, '30', '12'),
(2, '096520307037', 'mohan sharma', 'java|cpp|dcc|cm', '30|30|30|30', '30', '12');

-- --------------------------------------------------------

--
-- Table structure for table `result_id`
--

CREATE TABLE IF NOT EXISTS `result_id` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `enrollno` text,
  `fname` text,
  `subjects` text,
  `marks` text,
  `outof` text,
  `fail` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `result_table`
--

CREATE TABLE IF NOT EXISTS `result_table` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `branch` text,
  `sem` text,
  `exam_date` text,
  `type` text,
  `result_date` text,
  `result_id` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `result_table`
--

INSERT INTO `result_table` (`id`, `branch`, `sem`, `exam_date`, `type`, `result_date`, `result_id`) VALUES
(1, 'computer engineering', '1', '03-04-1993', 'internal', '07-05-2012 05:32:32 AM', 'computerengineering1internal03041993_1336368752');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
