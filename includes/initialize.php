<?php

//define the core paths
//Define them as absolute peths to make sure that require_once works as expected

//DIRECTORY_SEPARATOR is a PHP Pre-defined constants:
//(\ for windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'OnlineGradingSystem');

defined('LIB_PATH') ? null : define ('LIB_PATH',SITE_ROOT.DS.'includes');

// load config file first 
require_once("config.php");
//load basic functions next so that everything after can use them
require_once("functions.php");
//later here where we are going to put our class session
require_once("session.php");
require_once("member.php");
require_once("student.php");
require_once("student_details.php");
require_once("student_requirements.php");
require_once("department.php");
require_once("sy.php");
require_once("instructor.php");
require_once("instructorclasses.php");
require_once("studSubjects.php");
require_once("grades.php");
require_once("room.php");
require_once("subject.php");
require_once("course.php");
require_once("photos.php");
require_once("major.php");
require_once("studSubjects.php");
require_once("section.php");
require_once("assessment.php");
require_once("rawscores.php");
require_once("computedscores.php");



//Load Core objects
require_once("database.php");

//load database-related classes


?>