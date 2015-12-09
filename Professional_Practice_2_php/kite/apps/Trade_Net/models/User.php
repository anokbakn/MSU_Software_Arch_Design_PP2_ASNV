<?php
/** @author Armand Nokbak  **/

/**
* This model class manages the user and the user business logic
**/
require_once 'db_functions.php';

class User {


	function login($username, $pwd){
		
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		
		//echo $username .'<br>' . $pwd;
		$db = connect_db();
		//Check that user exists
		$result = $db->query('SELECT * FROM Person WHERE username="'.$username.'" AND password="'.$pwd.'"');
		
		if(sizeof($result)==0){ // if no result found
			return 'not a user';
		}
		else if (sizeof($result)==1){
				
			$has_brokerage = false;
			foreach($result as $row) {
				//echo '<br>'.$row['ssn'];
				//check that user has a brokerage account
				$result2 = $db->query('SELECT * FROM Account WHERE ssn='.$row['ssn'].' AND type="brokerage"');
				
				
				//get brokerage account results
				foreach($result2 as $row2) {
					$has_brokerage = true;
					$_SESSION['accountnumber']=$row2['accountnumber'];
					$_SESSION['balance'] = $row2['balance'];
					$_SESSION['ownerFN'] = $row2['ownerFN'];
					$_SESSION['ownerLN'] = $row2['ownerLN'];
					$_SESSION['username'] = $username;
					
				}
				//var_dump($has_brokerage);
				
			}
			return $has_brokerage;
		}
		else{
			return 'not a user';
		}

		$db = NULL; //close connection
	}


}
?>