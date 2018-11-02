-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2017 at 05:47 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workforce`
--
CREATE DATABASE IF NOT EXISTS `workforce` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `workforce`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` mediumint(8) unsigned NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `fname`, `lname`, `email`, `phone`, `company`) VALUES
(1, 'Sonya', 'Bergs', 'dolor.Donec.fringilla@interdumNunc.net', '1-446-463-3154', 'Tellus Consulting'),
(2, 'Nathaniel', 'Mcdaniel', 'Curabitur.dictum@magnaDuis.net', '909-0353', 'Mus Company'),
(3, 'Tarik', 'Stevens', 'nibh.lacinia@mienimcondimentum.net', '1-529-460-1982', 'Tellus Non Magna Inc.'),
(4, 'Olga', 'Williamson', 'orci.luctus.et@vehiculaPellentesquetincidunt.edu', '970-7369', 'Ipsum PC'),
(5, 'Drake', 'Rivers', 'ad.litora@Ut.co.uk', '443-5227', 'At Inc.'),
(6, 'Drake', 'Hintons', 'sit@necorci.co.uk', '1-365-350-7629', 'Pede Praesent Eu Institute'),
(7, 'Quynn', 'Douglas', 'a@ligulaDonecluctus.com', '790-4680', 'Dictum Mi Industries'),
(8, 'Cyrus', 'Stanley', 'Nulla.dignissim@lectus.net', '1-618-702-8869', 'Integer Aliquam Associates'),
(9, 'Dalton', 'Greene', 'ac.feugiat.non@pedesagittis.org', '739-5404', 'Hendrerit Industries'),
(10, 'Aladdin', 'Levy', 'gravida@acfacilisis.org', '965-4829', 'Nibh Sit Amet Corporation'),
(11, 'Leigh', 'Delacruz', 'vitae.aliquet.nec@velitjustonec.net', '1-994-150-7721', 'Donec PC'),
(12, 'Candace', 'Talley', 'Phasellus@ategestas.co.uk', '1-285-686-9987', 'Arcu Sed Et LLC'),
(13, 'Ainsley', 'Rivera', 'elementum@pharetrafelis.edu', '314-2837', 'Tempus LLP'),
(14, 'Lunea', 'Woodard', 'ligula@bibendumDonecfelis.org', '830-3896', 'Ligula Nullam Enim LLP'),
(15, 'Ingrid', 'Chambers', 'Aliquam.rutrum.lorem@hendrerita.net', '1-927-917-8442', 'Rhoncus Incorporated'),
(16, 'Danielle', 'Park', 'nisi.Mauris.nulla@feugiat.ca', '1-582-458-3481', 'Phasellus In Institute'),
(17, 'Tamekah', 'Melendez', 'Aenean.euismod.mauris@nonnisi.co.uk', '1-393-705-7896', 'Aliquet Lobortis Nisi Ltd'),
(18, 'Lynn', 'Stewart', 'consectetuer.adipiscing@Cras.co.uk', '1-606-764-7813', 'Risus Donec Industries'),
(19, 'Maite', 'Armstrong', 'Nunc@est.com', '1-485-796-3595', 'Mi Limited'),
(20, 'Elaine', 'Moon', 'Quisque@erosProinultrices.com', '1-552-346-6046', 'Sociis Natoque Penatibus Industries'),
(21, 'Alexis', 'Cohen', 'scelerisque.scelerisque.dui@mollis.com', '894-9641', 'Lacus Cras Interdum Corporation'),
(22, 'Yvonne', 'Rojas', 'in.aliquet@Nullam.edu', '503-8167', 'Sem Ut Company'),
(23, 'Dylan', 'Berry', 'fermentum.convallis.ligula@Aliquam.com', '1-176-926-3737', 'Ante Lectus Convallis Institute'),
(24, 'Miranda', 'Meyers', 'luctus.vulputate.nisi@lacusQuisque.org', '882-0928', 'Nostra Per Corporation'),
(25, 'Elliott', 'Vaughan', 'adipiscing.elit.Etiam@dis.org', '1-713-992-9872', 'Quam Foundation'),
(26, 'Zane', 'Craft', 'augue.ac@mus.com', '1-485-920-0877', 'Aenean Eget Metus Industries'),
(27, 'Ainsley', 'Woods', 'nunc@mattisInteger.ca', '1-313-939-6087', 'Lorem Lorem Inc.'),
(28, 'Ina', 'Harper', 'ipsum@lectusconvallis.ca', '568-4246', 'Id Ante Ltd'),
(29, 'Erin', 'Sutton', 'eget@libero.com', '1-662-310-5478', 'Aenean Sed Pede LLC'),
(30, 'Len', 'Massey', 'Suspendisse.aliquet@dolornonummy.ca', '536-0737', 'Quam Curabitur Institute'),
(31, 'Rooney', 'Weber', 'per.conubia.nostra@eu.edu', '1-354-776-4595', 'Ligula Aenean Foundation'),
(32, 'Honorato', 'Wise', 'ut@atlacus.com', '974-0937', 'Rhoncus Donec PC'),
(33, 'Halee', 'Strong', 'odio@euismod.net', '1-655-458-9692', 'Dolor Ltd'),
(34, 'Victoria', 'Bartlett', 'orci.Ut.semper@consequat.com', '624-3270', 'Consequat Nec Mollis PC'),
(35, 'Carol', 'Mckenzie', 'quis@Sed.com', '713-4404', 'Arcu Vestibulum Foundation'),
(36, 'Eugenia', 'Ellis', 'et@enim.net', '1-398-167-4786', 'Adipiscing Institute'),
(37, 'Sydnee', 'Carver', 'arcu@portaelita.co.uk', '1-845-299-7718', 'Duis Risus Odio Industries'),
(38, 'Claire', 'Harrell', 'sed.turpis@Namligulaelit.net', '1-974-721-2294', 'Odio Vel LLP'),
(39, 'Cullen', 'Blackwell', 'Donec.egestas.Duis@temporestac.ca', '618-3306', 'Porttitor Corp.'),
(40, 'Tyler', 'Tran', 'Pellentesque@MaurisnullaInteger.org', '682-6001', 'Semper Ltd'),
(41, 'Felicia', 'Stuart', 'sit@pedeetrisus.ca', '1-522-133-6306', 'Nisi Sem Semper Inc.'),
(42, 'Odessa', 'Cooke', 'pede.Suspendisse@elementum.edu', '565-3912', 'Ut Pellentesque Eget Foundation'),
(43, 'Ruth', 'Hart', 'scelerisque@SedmolestieSed.net', '824-7252', 'Rutrum Corp.'),
(44, 'Blossom', 'Guerrero', 'libero.Donec@arcuCurabiturut.edu', '1-146-821-2796', 'Pulvinar Limited'),
(45, 'Carly', 'Cantrell', 'parturient.montes.nascetur@nibhvulputatemauris.net', '490-9875', 'Massa Consulting'),
(46, 'Jasmine', 'Christensen', 'nostra@rutrummagna.co.uk', '1-787-885-5870', 'Massa Foundation'),
(47, 'Hayley', 'Hill', 'Suspendisse.commodo@lacus.co.uk', '1-808-775-8488', 'Quam Pellentesque Associates'),
(48, 'Wang', 'Curtis', 'lectus.pede@metusInlorem.org', '148-7811', 'Sed Tortor Consulting'),
(49, 'Travis', 'Keller', 'bibendum@Sed.ca', '759-7875', 'Id Libero Donec Ltd'),
(50, 'Dylan', 'Wolfe', 'bibendum.fermentum@Proinvel.com', '1-987-760-3514', 'Velit Justo Industries'),
(51, 'Chancellor', 'Lopez', 'in@enimnectempus.co.uk', '1-435-958-1071', 'Lorem Company'),
(52, 'Madison', 'Sloan', 'eu.augue.porttitor@dapibusgravidaAliquam.edu', '1-991-777-6357', 'Interdum Enim LLC'),
(53, 'Jack', 'Carey', 'Proin.nisl@NullaaliquetProin.co.uk', '1-109-595-8606', 'Placerat Company'),
(54, 'Ocean', 'Walters', 'posuere@necenim.edu', '1-859-955-7141', 'Semper Cursus Integer Industries'),
(55, 'Quin', 'Bartlett', 'nec.urna@sollicitudin.org', '428-6961', 'Enim Nunc Ut LLP'),
(56, 'Felicia', 'Juarez', 'Donec@nondapibusrutrum.com', '1-676-356-7161', 'Facilisis Suspendisse Commodo Ltd'),
(57, 'Ciara', 'Powers', 'Maecenas.libero.est@augueid.edu', '1-256-644-1070', 'Integer LLC'),
(58, 'Warren', 'Kidd', 'dui.Cras@nuncsedpede.net', '1-986-367-9379', 'Semper PC'),
(59, 'Abra', 'Dunn', 'libero.Donec@sociis.net', '265-4068', 'Pede Nec Corp.'),
(60, 'Vivian', 'Jimenez', 'cubilia@Vivamusnibh.ca', '1-499-444-3348', 'Vivamus PC'),
(61, 'Clinton', 'Carney', 'Vestibulum.ante.ipsum@risusaultricies.net', '568-1824', 'Interdum LLC'),
(62, 'Lars', 'Mosley', 'ornare.sagittis@malesuada.net', '1-625-344-0248', 'Massa LLP'),
(63, 'Alfreda', 'Jackson', 'Sed.congue@Phasellus.co.uk', '1-626-983-7708', 'Auctor Vitae Aliquet Ltd'),
(64, 'Caesar', 'Morrison', 'et.magna@etrisusQuisque.edu', '676-4536', 'Sem Elit Pharetra Industries'),
(65, 'Gareth', 'Camacho', 'consequat@DonecfringillaDonec.org', '1-755-375-2335', 'Sit Amet Corp.'),
(66, 'Beverly', 'Blanchard', 'adipiscing.Mauris.molestie@arcuVestibulumut.net', '1-248-427-5730', 'Tortor Integer Aliquam Consulting'),
(67, 'Rhona', 'Tanner', 'orci@Nulladignissim.co.uk', '1-762-417-0520', 'Cras Sed Leo Incorporated'),
(68, 'Echo', 'Larsen', 'elit.pede.malesuada@vitaepurus.edu', '1-411-279-6808', 'Mauris Vestibulum Associates'),
(69, 'Paul', 'Wilkerson', 'in@molestie.edu', '1-792-742-8226', 'Erat In Consectetuer Industries'),
(70, 'Arthur', 'Garrison', 'feugiat.placerat.velit@fringillaDonec.net', '547-0666', 'Magnis LLP'),
(71, 'Olga', 'Irwin', 'luctus.aliquet@posuerecubiliaCurae.edu', '470-1708', 'Donec Elementum Associates'),
(72, 'Hannah', 'Dejesus', 'in.consectetuer@hendreritconsectetuer.edu', '566-2135', 'Eu Lacus Quisque Foundation'),
(73, 'Alfonso', 'Workman', 'Nunc.mauris.sapien@vitaeerat.net', '891-5063', 'Sagittis LLP'),
(74, 'Graham', 'Cruz', 'bibendum@Nuncmauris.co.uk', '1-835-329-8382', 'Libero LLP'),
(75, 'Gisela', 'Rowe', 'Suspendisse.tristique.neque@iaculis.org', '314-9076', 'Vitae Dolor PC'),
(76, 'Melvin', 'Roberson', 'augue.id.ante@Suspendisseac.co.uk', '389-6174', 'Lectus Consulting'),
(77, 'Suki', 'Sexton', 'purus.Duis@euismodet.net', '1-342-205-9109', 'Ultricies Dignissim Ltd'),
(78, 'Julie', 'Oliver', 'Sed@Duis.co.uk', '1-905-926-4593', 'Venenatis Lacus LLC'),
(79, 'Patricia', 'Patel', 'pede.ultrices@tristiquealiquet.edu', '353-1655', 'Tellus Aenean Egestas LLC'),
(80, 'Britanni', 'Huff', 'ac.mi@egestasFuscealiquet.com', '182-5159', 'Vel Ltd'),
(81, 'Libby', 'Lynn', 'lorem.vehicula@atarcuVestibulum.edu', '853-7366', 'Egestas Ltd'),
(82, 'Kimberly', 'Sutton', 'pellentesque.Sed.dictum@tempor.org', '1-323-689-1379', 'Fringilla Limited'),
(83, 'Shellie', 'Bowen', 'rhoncus@metus.com', '1-390-708-0345', 'Vestibulum Ante Consulting'),
(84, 'Coby', 'Parks', 'vulputate.ullamcorper.magna@ligulaNullamenim.com', '1-560-652-3159', 'Molestie In Tempus Consulting'),
(85, 'Linus', 'Hopkins', 'vitae.erat.Vivamus@neceuismodin.co.uk', '1-900-245-8514', 'Nisl Industries'),
(86, 'Alexis', 'Carr', 'Aliquam@aliquameros.net', '1-571-667-8605', 'Id Libero Industries'),
(87, 'Solomon', 'Cain', 'sed.libero.Proin@loremsit.net', '1-345-200-3980', 'Ultricies Ligula Ltd'),
(88, 'Suki', 'Nicholson', 'tristique@nunc.org', '777-5509', 'Sit LLC'),
(89, 'Winter', 'Sparks', 'amet@sem.edu', '1-794-674-9578', 'Netus Industries'),
(90, 'Maya', 'Foster', 'sapien.imperdiet@infaucibusorci.com', '634-8067', 'Pede Inc.'),
(91, 'Knox', 'Tillman', 'eu@imperdietnec.co.uk', '896-1956', 'Dolor Fusce Company'),
(92, 'Leah', 'Pope', 'ac@consectetuermaurisid.ca', '1-704-401-7658', 'Pellentesque Corporation'),
(93, 'Sydney', 'Dixon', 'ultrices.Duis.volutpat@Duis.ca', '1-693-726-6164', 'Laoreet Ipsum Curabitur PC'),
(94, 'Logan', 'Alford', 'eget.varius@Crasconvallis.org', '1-628-571-7716', 'In LLP'),
(95, 'Jenna', 'Oliver', 'elementum.purus@pedenec.org', '211-0482', 'In Magna Phasellus Inc.'),
(96, 'Mallory', 'Mccullough', 'Suspendisse.dui.Fusce@ligulaAeneaneuismod.ca', '872-6897', 'Phasellus Consulting'),
(97, 'Quentin', 'Dean', 'tristique@tellusSuspendissesed.org', '383-4238', 'Luctus Ut Associates'),
(98, 'Avye', 'Ross', 'libero.Proin@lectus.ca', '1-928-773-8230', 'Vitae Foundation'),
(99, 'Todd', 'Henderson', 'pellentesque.a.facilisis@lobortisrisus.net', '1-979-363-0613', 'Ornare LLC'),
(100, 'Maris', 'Patton', 'nec.tempus.scelerisque@tortor.co.uk', '1-559-152-4250', 'Ultrices Iaculis Odio LLP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
