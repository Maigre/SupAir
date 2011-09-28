<?php

define("SYSTEMKEY","x65R89sd");

define("DOT",'.');
define("DS",DIRECTORY_SEPARATOR);
define("BASEDIR",dirname(__FILE__)); // root directory of framework
define("INCLUDEDIR", BASEDIR); // directory where the includes reside
define("CLASSDIR", BASEDIR); // directory where the framework classes reside
define("SYSTEMDIR", BASEDIR); // directory where the system (core) classes reside

include_once(BASEDIR.DS."autoload.php");

spl_autoload_register('__autoload');


