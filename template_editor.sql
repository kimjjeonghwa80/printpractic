-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2017 at 03:38 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `template_editor`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminelements`
--

CREATE TABLE `adminelements` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `element_path` varchar(255) NOT NULL,
  `element_json` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminelements`
--

INSERT INTO `adminelements` (`id`, `cat_id`, `element_name`, `element_path`, `element_json`) VALUES
(10, 21, 'bn', 'uploads/C:\\fakepath\\Cartoon-Owl-Clipart.svg', ''),
(11, 18, 'b', 'uploads/C:\\fakepath\\kiwi.svg', ''),
(16, 22, 'Test', 'uploads/bauble.svg', ''),
(21, 22, 'erwr', 'uploads/circle.svg', ''),
(31, 23, 'Test1', 'uploads/Test1.svg', '{\"type\":\"path-group\",\"originX\":\"center\",\"originY\":\"center\",\"left\":255.89,\"top\":255.89,\"width\":511.78,\"height\":511.78,\"fill\":\"#ffff00\",\"stroke\":\"#ffff00\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":null,\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"paths\":[{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":230.56,\"top\":0,\"width\":52.76,\"height\":91.42,\"fill\":\"#4c1130\",\"stroke\":\"#4c1130\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":256.9406320646408,\"y\":45.712125},\"path\":[[\"M\",265.48,84.471],[\"c\",-3.465,9.271,-15.717,9.271,-19.173,0],[\"l\",-15.744,-42.167],[\"C\",223.734,24,234.203,2.487,252.47,0.21],[\"c\",1.125,-0.137,2.267,-0.21,3.419,-0.21],[\"c\",1.161,0,2.304,0.073,3.429,0.21],[\"c\",18.267,2.277,28.727,23.79,21.897,42.094],[\"L\",265.48,84.471],[\"z\"]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":91.32,\"top\":194.44,\"width\":329.14,\"height\":317.34,\"fill\":\"#BE3A2B\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":255.8915,\"y\":353.11250000000007},\"path\":[[\"M\",316.865,194.443],[\"c\",-40.649,8.475,-81.298,8.475,-121.947,0],[\"C\",134.245,218.69,91.32,277.881,91.32,347.211],[\"c\",0,90.889,73.682,164.571,164.571,164.571],[\"S\",420.463,438.1,420.463,347.211],[\"C\",420.463,277.881,377.537,218.69,316.865,194.443]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":159.43,\"top\":223.34,\"width\":49,\"height\":39.61,\"fill\":\"#9C281F\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":183.93292008698893,\"y\":243.14906138209778},\"path\":[[\"M\",168.576,262.956],[\"c\",-2.441,0,-4.864,-0.969,-6.665,-2.88],[\"c\",-3.456,-3.685,-3.273,-9.472,0.402,-12.928],[\"c\",9.838,-9.225,20.919,-16.914,32.933,-22.848],[\"c\",4.526,-2.258,10.002,-0.384,12.242,4.151],[\"c\",2.231,4.526,0.375,10.002,-4.151,12.242],[\"c\",-10.395,5.129,-19.986,11.794,-28.498,19.785],[\"C\",173.065,262.133,170.825,262.956,168.576,262.956]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":182.75,\"top\":146.18,\"width\":146.29,\"height\":64,\"fill\":\"#9C281F\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":255.893,\"y\":178.17362500000002},\"path\":[[\"M\",182.75,201.032],[\"L\",182.75,201.032],[\"c\",48.759,12.187,97.527,12.187,146.286,0],[\"v\",-54.857],[\"H\",182.75],[\"V\",201.032],[\"z\"]]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":201.04,\"top\":118.75,\"width\":109.71,\"height\":27.43,\"fill\":\"#BE3A2B\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":201.036,\"y\":146.175},{\"x\":310.75,\"y\":146.175},{\"x\":310.75,\"y\":118.747},{\"x\":201.036,\"y\":118.747}]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":237.61,\"top\":82.17,\"width\":36.57,\"height\":36.57,\"fill\":\"#ffff00\",\"stroke\":\"#ffff00\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":237.607,\"y\":118.747},{\"x\":274.179,\"y\":118.747},{\"x\":274.179,\"y\":82.175},{\"x\":237.607,\"y\":82.175}]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":155.32,\"top\":255.89,\"width\":201.14,\"height\":182.86,\"fill\":\"#00ffff\",\"stroke\":\"#00ffff\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":255.893,\"y\":255.889},{\"x\":282.197,\"y\":319.889},{\"x\":356.464,\"y\":319.889},{\"x\":292.464,\"y\":365.604},{\"x\":319.893,\"y\":438.747},{\"x\":255.893,\"y\":393.032},{\"x\":191.893,\"y\":438.747},{\"x\":219.322,\"y\":365.604},{\"x\":155.322,\"y\":319.889},{\"x\":229.589,\"y\":319.889}]}]}'),
(33, 30, 'Sample', 'uploads/ISTestTag.svg', ''),
(35, 23, 'm', 'uploads/gingerbread-man.svg', ''),
(38, 22, 'FFF', 'uploads/dotted-barline.svg', ''),
(39, 21, 't2', 'uploads/confetti.svg', ''),
(40, 23, 'sample', 'uploads/sample.svg', '{\"type\":\"path-group\",\"originX\":\"center\",\"originY\":\"center\",\"left\":255.89,\"top\":255.89,\"width\":511.78,\"height\":511.78,\"fill\":\"#660000\",\"stroke\":\"#660000\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":null,\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"paths\":[{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":230.56,\"top\":0,\"width\":52.76,\"height\":91.42,\"fill\":\"#CFD2CF\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":256.9406320646408,\"y\":45.712125},\"path\":[[\"M\",265.48,84.471],[\"c\",-3.465,9.271,-15.717,9.271,-19.173,0],[\"l\",-15.744,-42.167],[\"C\",223.734,24,234.203,2.487,252.47,0.21],[\"c\",1.125,-0.137,2.267,-0.21,3.419,-0.21],[\"c\",1.161,0,2.304,0.073,3.429,0.21],[\"c\",18.267,2.277,28.727,23.79,21.897,42.094],[\"L\",265.48,84.471],[\"z\"]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":91.32,\"top\":194.44,\"width\":329.14,\"height\":317.34,\"fill\":\"#BE3A2B\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":255.8915,\"y\":353.11250000000007},\"path\":[[\"M\",316.865,194.443],[\"c\",-40.649,8.475,-81.298,8.475,-121.947,0],[\"C\",134.245,218.69,91.32,277.881,91.32,347.211],[\"c\",0,90.889,73.682,164.571,164.571,164.571],[\"S\",420.463,438.1,420.463,347.211],[\"C\",420.463,277.881,377.537,218.69,316.865,194.443]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":159.43,\"top\":223.34,\"width\":49,\"height\":39.61,\"fill\":\"#9C281F\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":183.93292008698893,\"y\":243.14906138209778},\"path\":[[\"M\",168.576,262.956],[\"c\",-2.441,0,-4.864,-0.969,-6.665,-2.88],[\"c\",-3.456,-3.685,-3.273,-9.472,0.402,-12.928],[\"c\",9.838,-9.225,20.919,-16.914,32.933,-22.848],[\"c\",4.526,-2.258,10.002,-0.384,12.242,4.151],[\"c\",2.231,4.526,0.375,10.002,-4.151,12.242],[\"c\",-10.395,5.129,-19.986,11.794,-28.498,19.785],[\"C\",173.065,262.133,170.825,262.956,168.576,262.956]]},{\"type\":\"path\",\"originX\":\"left\",\"originY\":\"top\",\"left\":182.75,\"top\":146.18,\"width\":146.29,\"height\":64,\"fill\":\"#9C281F\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"pathOffset\":{\"x\":255.893,\"y\":178.17362500000002},\"path\":[[\"M\",182.75,201.032],[\"L\",182.75,201.032],[\"c\",48.759,12.187,97.527,12.187,146.286,0],[\"v\",-54.857],[\"H\",182.75],[\"V\",201.032],[\"z\"]]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":201.04,\"top\":118.75,\"width\":109.71,\"height\":27.43,\"fill\":\"#BE3A2B\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":201.036,\"y\":146.175},{\"x\":310.75,\"y\":146.175},{\"x\":310.75,\"y\":118.747},{\"x\":201.036,\"y\":118.747}]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":237.61,\"top\":82.17,\"width\":36.57,\"height\":36.57,\"fill\":\"#E4E5E6\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":237.607,\"y\":118.747},{\"x\":274.179,\"y\":118.747},{\"x\":274.179,\"y\":82.175},{\"x\":237.607,\"y\":82.175}]},{\"type\":\"polygon\",\"originX\":\"left\",\"originY\":\"top\",\"left\":155.32,\"top\":255.89,\"width\":201.14,\"height\":182.86,\"fill\":\"#660000\",\"stroke\":\"#660000\",\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":[1,0,0,1,0,0],\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"points\":[{\"x\":255.893,\"y\":255.889},{\"x\":282.197,\"y\":319.889},{\"x\":356.464,\"y\":319.889},{\"x\":292.464,\"y\":365.604},{\"x\":319.893,\"y\":438.747},{\"x\":255.893,\"y\":393.032},{\"x\":191.893,\"y\":438.747},{\"x\":219.322,\"y\":365.604},{\"x\":155.322,\"y\":319.889},{\"x\":229.589,\"y\":319.889}]}]}'),
(42, 23, 'testsample', 'uploads/gift.svg', '');

-- --------------------------------------------------------

--
-- Table structure for table `adminuploads`
--

CREATE TABLE `adminuploads` (
  `id` int(100) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '1',
  `imgpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminuploads`
--

INSERT INTO `adminuploads` (`id`, `userid`, `imgpath`) VALUES
(25, 1, 'admin/uploads/dummy.png'),
(26, 1, 'admin/uploads/Transparent_ Butterflies_Photo-Frame.png'),
(28, 1, 'admin/uploads/Tulips.jpg'),
(41, 1, 'admin/uploads/18x24Less.jpg'),
(46, 1, 'admin/uploads/ch1.jpg'),
(47, 1, 'admin/uploads/2 (3MB).png'),
(48, 1, 'admin/uploads/5339.jpg'),
(49, 1, 'admin/uploads/11.8.55.jpg'),
(50, 1, 'admin/uploads/aza2.png'),
(51, 1, 'admin/uploads/flowers.png'),
(52, 1, 'admin/uploads/back.png'),
(53, 1, 'admin/uploads/11.8.5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE `adminuser` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last login date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`id`, `username`, `password`, `last login date`) VALUES
(1, 'adminuser@prettytimely.com', 'prettytimely@1234#', '2016-06-24'),
(2, 'velan.kpom@gmail.com', 'velan', '2016-06-24');

-- --------------------------------------------------------

--
-- Table structure for table `background`
--

CREATE TABLE `background` (
  `id` int(11) NOT NULL,
  `bgcat_id` int(11) NOT NULL,
  `bg_name` varchar(255) NOT NULL,
  `bg_path` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `background`
--

INSERT INTO `background` (`id`, `bgcat_id`, `bg_name`, `bg_path`) VALUES
(22, 8, 'Fawn', '../admin/uploads/fawn.jpg'),
(21, 8, 'Stormy Sky', '../admin/uploads/stormy sky.jpg'),
(43, 10, 'sampe', '../admin/uploads/18x24.jpg'),
(42, 4, 'sample', '../admin/uploads/11.8.55.jpg'),
(44, 13, 'test', '../admin/uploads/Peony 2.png'),
(45, 4, 'sample5', '../admin/uploads/ch1.jpg'),
(46, 4, 'sample56', '../admin/uploads/christmas.png'),
(47, 14, '111', '../admin/uploads/images123.jpg'),
(48, 15, 'Light', '../admin/uploads/colour.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bgimage`
--

CREATE TABLE `bgimage` (
  `id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_json` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bgimage`
--

INSERT INTO `bgimage` (`id`, `image_name`, `image_path`, `image_json`) VALUES
(1, 'test', 'uploads/Penguins.jpeg', ''),
(2, 'tested123', 'uploads/Tulips.jpeg', ''),
(3, 'test1', 'uploads/Koala.jpeg', '');

-- --------------------------------------------------------

--
-- Table structure for table `bg_categories`
--

CREATE TABLE `bg_categories` (
  `bgcat_id` int(11) NOT NULL,
  `bgcat_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bg_categories`
--

INSERT INTO `bg_categories` (`bgcat_id`, `bgcat_name`) VALUES
(4, 'Wood'),
(10, 'Scenery'),
(7, 'Grunge'),
(8, 'Paper'),
(13, 'Peony'),
(14, 'test123'),
(15, 'Snapchat geofilre');

-- --------------------------------------------------------

--
-- Table structure for table `client_download_limit`
--

CREATE TABLE `client_download_limit` (
  `id` int(11) NOT NULL,
  `cur_userid` int(11) DEFAULT NULL,
  `temp_id` int(11) DEFAULT NULL,
  `pdf` int(11) DEFAULT '0',
  `jpeg` int(11) DEFAULT '0',
  `png` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_download_limit`
--

INSERT INTO `client_download_limit` (`id`, `cur_userid`, `temp_id`, `pdf`, `jpeg`, `png`) VALUES
(6, 1, 152, 3, 0, 1),
(7, 1, 154, 5, 3, 4),
(8, 2, 155, 2, 2, 2),
(9, 1, 153, 2, 1, 0),
(10, 1, 147, 1, 0, 0),
(11, 1, 151, 2, 0, 0),
(12, 1, 0, 5, 5, 4),
(13, 1, 160, 5, 1, 1),
(14, 1, 161, 1, 0, 0),
(15, 1, 162, 4, 0, 0),
(16, 1, 163, 6, 1, 1),
(17, 1, 165, 7, 1, 1),
(18, 1, 170, 1, 1, 1),
(19, 1, 171, 1, 0, 0),
(20, 1, 169, 0, 0, 0),
(21, 1, 167, 1, 0, 0),
(22, 1, 172, 1, 0, 0),
(23, 1, 173, 1, 1, 1),
(24, 1, 174, 1, 0, 0),
(25, 1, 175, 1, 0, 0),
(26, 1, 176, 1, 0, 0),
(27, 1, 177, 2, 0, 0),
(28, 1, 178, 3, 0, 0),
(29, 1, 179, 1, 0, 0),
(30, 1, 180, 5, 2, 4),
(31, 1, 182, 3, 3, 2),
(32, 1, 181, 3, 3, 3),
(33, 0, 0, 2, 0, 2),
(34, 0, 180, 0, 0, 1),
(35, 7, 199, 1, 0, 0),
(36, 8, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_login`, `first_name`, `last_name`, `img_path`) VALUES
(1, 'kpomservices@gmail.com', 'KPOM ', 'Services ', 'userimage/1/Cartoondaniellealcorn.jpg'),
(2, 'nusaibah.aziz@gmail.com', '', '', 'userimage/2/Jellyfish.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `download_imit`
--

CREATE TABLE `download_imit` (
  `pdf_limit` int(11) NOT NULL,
  `jpeg_limit` int(11) NOT NULL,
  `png_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `download_imit`
--

INSERT INTO `download_imit` (`pdf_limit`, `jpeg_limit`, `png_limit`) VALUES
(5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `element`
--

CREATE TABLE `element` (
  `id` int(11) NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `element_path` varchar(255) NOT NULL,
  `element_json` longtext NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `element`
--

INSERT INTO `element` (`id`, `element_name`, `element_path`, `element_json`, `userid`) VALUES
(359, 'tt', 'uploads/curly-design3.svg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `element_categories`
--

CREATE TABLE `element_categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `element_categories`
--

INSERT INTO `element_categories` (`category_id`, `category`) VALUES
(23, 'Arrows'),
(21, 'Icons'),
(22, 'Badges'),
(17, 'Curly Designs'),
(18, 'Banners'),
(25, 'Miscellaneous'),
(20, 'Hearts'),
(26, 'Stock Photos'),
(30, 'test123'),
(31, 'Text');

-- --------------------------------------------------------

--
-- Table structure for table `font_file`
--

CREATE TABLE `font_file` (
  `id` int(11) NOT NULL,
  `ff_name` varchar(255) NOT NULL,
  `ff_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `font_file`
--

INSERT INTO `font_file` (`id`, `ff_name`, `ff_path`) VALUES
(9, 'Satisfy', './tcpdf/fonts/googlefonts/Satisfy/Satisfy-Regular.ttf'),
(10, 'Cookie', './tcpdf/fonts/googlefonts/Cookie/Cookie-Regular.ttf'),
(11, 'KaushanScript', './tcpdf/fonts/googlefonts/KaushanScript/KaushanScript-Regular.ttf'),
(12, 'Pacifico', './tcpdf/fonts/googlefonts/Pacifico/Pacifico-Regular.ttf'),
(13, 'Yellowtail', './tcpdf/fonts/googlefonts/Yellowtail/Yellowtail-Regular.ttf'),
(16, 'Mf_I_Love_Glitter', './tcpdf/fonts/googlefonts/Mf_I_Love_Glitter/MfILoveGlitter-Regular.ttf'),
(17, 'Julius_Sans_One', './tcpdf/fonts/googlefonts/Julius_Sans_One/JuliusSansOne-Regular.ttf');

-- --------------------------------------------------------

--
-- Table structure for table `geofilter`
--

CREATE TABLE `geofilter` (
  `geoimages` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geofilter`
--

INSERT INTO `geofilter` (`geoimages`) VALUES
('42,47');

-- --------------------------------------------------------

--
-- Table structure for table `pattern`
--

CREATE TABLE `pattern` (
  `id` int(11) NOT NULL,
  `pattern_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pattern`
--

INSERT INTO `pattern` (`id`, `pattern_path`) VALUES
(57, 'uploads/3.gold-textures.jpg'),
(60, 'uploads/gold a bit darker VLR.jpg'),
(63, 'uploads/Rose Gold Foil2.jpg'),
(66, 'uploads/Rose Gold Foil.jpg'),
(68, 'uploads/Smooth gold.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `template_id` int(100) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `canvas_thumbnail` longtext NOT NULL,
  `canvas_json` longtext NOT NULL,
  `cat_id` int(100) NOT NULL,
  `shopify_product_id` varchar(255) NOT NULL,
  `etsy_listing_id` varchar(255) NOT NULL,
  `created_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`template_id`, `template_name`, `canvas_thumbnail`, `canvas_json`, `cat_id`, `shopify_product_id`, `etsy_listing_id`, `created_date`, `modified_date`) VALUES
(572, '18x24 peony', 'admin/templates/572.png', 'admin/templates/572.pt', 17, '10500821446', '519382576', NULL, NULL),
(589, 'PEONY', 'admin/templates/589.png', 'admin/templates/589.ype', 26, '10500821447', '323423423', NULL, NULL),
(590, 'Pink Peony 18x24', 'admin/templates/590.png', 'admin/templates/590.ype', 17, '10500821442', '', NULL, NULL),
(593, 'no pictures', 'admin/templates/593.png', 'admin/templates/593.ype', 26, '', '', NULL, NULL),
(602, 'cards', 'admin/templates/602.png', 'admin/templates/602.ype', 18, 'wonder121', '', NULL, NULL),
(605, '24 x36', 'admin/templates/605.png', 'admin/templates/605.ype', 17, '', '', NULL, NULL),
(606, '24 x36', 'admin/templates/606.png', 'admin/templates/606.ype', 17, '', '', NULL, NULL),
(613, '5542', 'admin/templates/613.png', 'admin/templates/613.ype', 16, '', '', NULL, NULL),
(615, 'sample', 'admin/templates/615.png', 'admin/templates/615.ype', 13, '', '', NULL, NULL),
(652, '142', 'admin/templates/652.png', 'admin/templates/652.pt', 27, '1234567890', '', NULL, NULL),
(653, '120 size', 'admin/templates/653.png', 'admin/templates/653.pt', 13, '', '', NULL, NULL),
(659, 'left move issue', 'admin/templates/659.png', 'admin/templates/659.pt', 14, '', '', NULL, NULL),
(660, 'sam', 'admin/templates/660.png', 'admin/templates/660.pt', 13, '', '', NULL, NULL),
(661, 'test', 'admin/templates/661.png', 'admin/templates/661.pt', 27, '', '', NULL, NULL),
(662, 'Mf glitter', 'admin/templates/662.png', 'admin/templates/662.pt', 17, '', '', NULL, NULL),
(663, 'Mf glitter', 'admin/templates/663.png', 'admin/templates/663.pt', 17, '', '', NULL, NULL),
(664, '222', 'admin/templates/664.png', 'admin/templates/664.pt', 27, '', '', NULL, NULL),
(665, 'sample', 'admin/templates/665.png', 'admin/templates/665.pt', 27, '23333', '', NULL, NULL),
(666, '123', 'admin/templates/666.png', 'admin/templates/666.pt', 27, '', '', NULL, NULL),
(667, '1231', 'admin/templates/667.png', 'admin/templates/667.pt', 27, '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `template_categories`
--

CREATE TABLE `template_categories` (
  `tempcat_id` int(11) NOT NULL,
  `tempcat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_categories`
--

INSERT INTO `template_categories` (`tempcat_id`, `tempcat_name`) VALUES
(13, 'WEDDING INVITATION'),
(14, 'Programs'),
(16, 'Menu'),
(17, 'Seating Chart'),
(18, 'Signage'),
(19, 'Labels & Tags'),
(20, 'Save the Date'),
(21, 'Engagement & Rehearsal'),
(24, 'Program fan'),
(26, 'Place card Tent'),
(27, 'geofilters');

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE `texts` (
  `text_id` int(11) NOT NULL,
  `text_name` varchar(255) NOT NULL,
  `text_thumbnail` longtext NOT NULL,
  `text_json` longtext NOT NULL,
  `cat_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `texts`
--

INSERT INTO `texts` (`text_id`, `text_name`, `text_thumbnail`, `text_json`, `cat_id`) VALUES
(26, 'sans', 'data:image/png;base64,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', '{\"type\":\"group\",\"originX\":\"left\",\"originY\":\"top\",\"left\":701.5,\"top\":1032.91,\"width\":403.2,\"height\":410.33,\"fill\":\"rgb(0,0,0)\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1,\"scaleY\":1,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":null,\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":false,\"selectable\":true,\"objects\":[{\"type\":\"textbox\",\"originX\":\"left\",\"originY\":\"top\",\"left\":-201.6,\"top\":-205.16,\"width\":400,\"height\":76.84,\"fill\":\"#000000\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1.01,\"scaleY\":1.01,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":null,\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":true,\"selectable\":true,\"text\":\"One\\n\",\"fontSize\":34,\"fontWeight\":\"normal\",\"fontFamily\":\"Julius Sans One\",\"fontStyle\":\"\",\"lineHeight\":1,\"textDecoration\":\"\",\"textAlign\":\"center\",\"textBackgroundColor\":\"\",\"charSpacing\":0,\"minWidth\":20,\"styles\":{\"0\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{}},\"1\":{}}},{\"type\":\"textbox\",\"originX\":\"left\",\"originY\":\"top\",\"left\":-201.6,\"top\":-163.88,\"width\":400,\"height\":366.12,\"fill\":\"#000000\",\"stroke\":null,\"strokeWidth\":0,\"strokeDashArray\":null,\"strokeLineCap\":\"butt\",\"strokeLineJoin\":\"miter\",\"strokeMiterLimit\":10,\"scaleX\":1.01,\"scaleY\":1.01,\"angle\":0,\"flipX\":false,\"flipY\":false,\"opacity\":1,\"shadow\":null,\"visible\":true,\"clipTo\":null,\"backgroundColor\":\"\",\"fillRule\":\"nonzero\",\"globalCompositeOperation\":\"source-over\",\"transformMatrix\":null,\"skewX\":0,\"skewY\":0,\"lockMovementX\":false,\"lockMovementY\":false,\"lockScalingX\":false,\"lockScalingY\":true,\"selectable\":true,\"text\":\"Dorla Losada\\nMerissa March\\nDonovan Dotts\\nMitzi Rivas\\nBessie Diep\\nEnrique Carstensen\\nMinh Dobyns\\nShanel Haswell\\nVida Hutto\",\"fontSize\":36,\"fontWeight\":\"normal\",\"fontFamily\":\"Julius Sans One\",\"fontStyle\":\"\",\"lineHeight\":1,\"textDecoration\":\"\",\"textAlign\":\"center\",\"textBackgroundColor\":\"\",\"charSpacing\":0,\"minWidth\":20,\"styles\":{\"0\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{},\"11\":{}},\"1\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{},\"11\":{},\"12\":{}},\"2\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{},\"11\":{},\"12\":{}},\"3\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{}},\"4\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{}},\"5\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{},\"11\":{},\"12\":{},\"13\":{},\"14\":{},\"15\":{},\"16\":{},\"17\":{}},\"6\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{}},\"7\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{},\"10\":{},\"11\":{},\"12\":{},\"13\":{}},\"8\":{\"0\":{},\"1\":{},\"2\":{},\"3\":{},\"4\":{},\"5\":{},\"6\":{},\"7\":{},\"8\":{},\"9\":{}}}}]}', 8);

-- --------------------------------------------------------

--
-- Table structure for table `text_categories`
--

CREATE TABLE `text_categories` (
  `textcat_id` int(11) NOT NULL,
  `textcat_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `text_categories`
--

INSERT INTO `text_categories` (`textcat_id`, `textcat_name`) VALUES
(8, 'Quick Text'),
(11, 'test123');

-- --------------------------------------------------------

--
-- Table structure for table `userelements`
--

CREATE TABLE `userelements` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `element_path` varchar(255) NOT NULL,
  `element_json` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `last_login_date`) VALUES
(1, 'user@test.com', 'userpass', '2017-03-08'),
(2, 'client@test.com', 'clientpass', '2017-03-08'),
(3, 'user1@test.com', 'userpass', '2017-04-10'),
(8, 'kpomservices@gmail.com', 'fraCyUwc', '2017-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `usertemplatemap`
--

CREATE TABLE `usertemplatemap` (
  `ID` int(11) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `template_id` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertemplatemap`
--

INSERT INTO `usertemplatemap` (`ID`, `userid`, `template_id`) VALUES
(148, 4, 346),
(147, 27, 345),
(146, 26, 344),
(145, 26, 343),
(144, 1, 342),
(143, 1, 341),
(142, 1, 340),
(141, 1, 339),
(140, 24, 337),
(139, 22, 336),
(138, 22, 334),
(100, 18, 263),
(101, 18, 264),
(102, 18, 265),
(103, 18, 266),
(104, 18, 267),
(105, 18, 268),
(137, 24, 333),
(136, 24, 332),
(135, 1, 331),
(134, 1, 330),
(133, 1, 329),
(132, 4, 325),
(131, 4, 324),
(130, 23, 321),
(129, 22, 320),
(128, 21, 319),
(127, 20, 316),
(126, 3, 312),
(125, 1, 299),
(124, 1, 294),
(123, 4, 291),
(122, 4, 290);

-- --------------------------------------------------------

--
-- Table structure for table `useruploads`
--

CREATE TABLE `useruploads` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `imgpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useruploads`
--

INSERT INTO `useruploads` (`id`, `userid`, `imgpath`) VALUES
(26, 0, 'uploads/2017 design 12_2.png'),
(27, 0, 'uploads/53e18662ac04f$!x900.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_background`
--

CREATE TABLE `user_background` (
  `id` int(11) NOT NULL,
  `bg_name` varchar(255) NOT NULL,
  `bg_path` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_background`
--

INSERT INTO `user_background` (`id`, `bg_name`, `bg_path`, `userid`) VALUES
(1, 'r', 'uploads/grey_wash_wall.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_templates`
--

CREATE TABLE `user_templates` (
  `template_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `canvas_thumbnail` longtext NOT NULL,
  `canvas_json` longtext NOT NULL,
  `created_date` date NOT NULL,
  `modified_date` date NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_templates`
--

INSERT INTO `user_templates` (`template_id`, `userid`, `template_name`, `canvas_thumbnail`, `canvas_json`, `created_date`, `modified_date`, `cat_id`) VALUES
(193, 4, '', 'templates/193.png', 'templates/193.pt', '2017-05-29', '2017-05-29', 0),
(194, 5, '', 'templates/194.png', 'templates/194.pt', '2017-05-29', '2017-05-29', 0),
(195, 5, '', 'templates/195.png', 'templates/195.pt', '2017-05-29', '2017-05-29', 0),
(197, 6, 's1', 'templates/197.png', 'templates/197.ype', '2017-05-29', '2017-05-29', 0),
(198, 6, 'svg export test', 'templates/198.png', 'templates/198.ype', '2017-05-29', '2017-05-29', 0),
(199, 7, '', 'templates/199.png', 'templates/199.pt', '2017-05-29', '2017-05-29', 0),
(200, 8, '', 'templates/200.png', 'templates/200.pt', '2017-05-29', '2017-05-29', 21),
(201, 8, '', 'templates/201.png', 'templates/201.pt', '2017-05-29', '2017-05-29', 24),
(202, 8, '', 'templates/202.png', 'templates/202.pt', '2017-06-03', '2017-06-03', 26),
(203, 8, '', 'templates/203.png', 'templates/203.pt', '2017-06-03', '2017-06-03', 21),
(204, 8, 'New Temp 1', 'templates/204.png', 'templates/204.pt', '2017-06-13', '2017-06-13', 27),
(205, 8, 'New Temp 1', 'templates/205.png', 'templates/205.pt', '2017-06-13', '2017-06-13', 27),
(206, 1, 'sample', 'templates/206.png', 'templates/206.pt', '2017-06-13', '2017-06-13', 27),
(207, 1, 'sample123', 'templates/207.png', 'templates/207.pt', '2017-06-13', '2017-06-13', 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminelements`
--
ALTER TABLE `adminelements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adminuploads`
--
ALTER TABLE `adminuploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `background`
--
ALTER TABLE `background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgimage`
--
ALTER TABLE `bgimage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bg_categories`
--
ALTER TABLE `bg_categories`
  ADD PRIMARY KEY (`bgcat_id`);

--
-- Indexes for table `client_download_limit`
--
ALTER TABLE `client_download_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `element_categories`
--
ALTER TABLE `element_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `font_file`
--
ALTER TABLE `font_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pattern`
--
ALTER TABLE `pattern`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `template_categories`
--
ALTER TABLE `template_categories`
  ADD PRIMARY KEY (`tempcat_id`);

--
-- Indexes for table `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`text_id`);

--
-- Indexes for table `text_categories`
--
ALTER TABLE `text_categories`
  ADD PRIMARY KEY (`textcat_id`);

--
-- Indexes for table `userelements`
--
ALTER TABLE `userelements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertemplatemap`
--
ALTER TABLE `usertemplatemap`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `useruploads`
--
ALTER TABLE `useruploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_background`
--
ALTER TABLE `user_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_templates`
--
ALTER TABLE `user_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminelements`
--
ALTER TABLE `adminelements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `adminuploads`
--
ALTER TABLE `adminuploads`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `background`
--
ALTER TABLE `background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `bgimage`
--
ALTER TABLE `bgimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bg_categories`
--
ALTER TABLE `bg_categories`
  MODIFY `bgcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `client_download_limit`
--
ALTER TABLE `client_download_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `element`
--
ALTER TABLE `element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;
--
-- AUTO_INCREMENT for table `element_categories`
--
ALTER TABLE `element_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `font_file`
--
ALTER TABLE `font_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pattern`
--
ALTER TABLE `pattern`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `template_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=668;
--
-- AUTO_INCREMENT for table `template_categories`
--
ALTER TABLE `template_categories`
  MODIFY `tempcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `texts`
--
ALTER TABLE `texts`
  MODIFY `text_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `text_categories`
--
ALTER TABLE `text_categories`
  MODIFY `textcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `userelements`
--
ALTER TABLE `userelements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `usertemplatemap`
--
ALTER TABLE `usertemplatemap`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT for table `useruploads`
--
ALTER TABLE `useruploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_background`
--
ALTER TABLE `user_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user_templates`
--
ALTER TABLE `user_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
