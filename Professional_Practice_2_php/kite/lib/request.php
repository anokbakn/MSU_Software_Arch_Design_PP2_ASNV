<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 				- request.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/

//stores the request parameters to request object

class request extends kite{

	public function __construct()
	{
		foreach($_REQUEST as $key => $value)
			$this->$key= $value;
	}
		
}