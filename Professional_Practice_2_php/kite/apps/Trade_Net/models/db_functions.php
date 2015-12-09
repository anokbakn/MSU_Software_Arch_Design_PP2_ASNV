<?php
/**
* @author Armand Nokbak 
* This class holds the function to connect to the Account Management database
**/

function connect_db(){
	$db = null; 
	try
	{
	//open the database
	//This is the link from the Kite folder inside the htdocs folder of xampp
	$db = new PDO('sqlite:../../../Users/anokbakn/Documents/Professional_Practice_1/BAMS7.db');


	//$result = $db->query('SELECT * FROM Person');
	/**
	foreach($result as $row) {
		print "<br>".$row[0];
	}

	$db = NULL;

	
	**/
	}
	catch(PDOException $e)
	{
	print 'Exception : '.$e->getMessage();
	}
	return $db;
}

?>