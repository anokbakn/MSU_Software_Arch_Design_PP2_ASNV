<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- root
 *	file 				- index.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/


	//defining a global constant to block direct access to files
	define('_KITE',true);
	// directory sperator
	define('DS',DIRECTORY_SEPARATOR);
	
	//check for the installation file
	// 'check.php' is a sample file used before installation
	// if the file is deleted after the installation is done
	if(file_exists('lib'.DS.'installer'.DS.'check.php'))
	{
		require_once "lib".DS."installer".DS."installer.php";
		$install = new Installer();
		$install->main();
	}
	else{
		//load the error class and kite class
		require_once "lib".DS."error.php";
		require_once "lib".DS."kite.php";
		$kite = KITE::getInstance('kite');
		$kite->kite_main();
	}

?>