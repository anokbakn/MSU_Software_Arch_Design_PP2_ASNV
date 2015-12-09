<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 				- basket.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/

// The basket object is used to carry data to the view
// any data extracted from database is stored in basket object
class basket{

	//function to store a value as object varaible
	function set($key,$value)
	{
		$this->$key = $value;
	}
	
	//function to retrive the stored object variables
	function get($key)
	{
		if(isset($this->$key))
			return $this->$key;
		else
			return null;
	}
	
}
?>