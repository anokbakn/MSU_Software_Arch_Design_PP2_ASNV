<?php
/** @author Armand Nokbak  **/

/**
* This model class manages the user and the user business logic
**/
require_once 'db_functions.php';
require_once 'Company.php';

class User {


	public function login($username, $pwd){
		
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
	
	public function buy($stock, $shares_numb, $accountnumber, $price, $amount){
		//connect to database
		try{
			$db = connect_db();
			
		
			$result = $db->exec('INSERT INTO Brokerage_Transactions (accountnumber, stock, price, numb_shares, type_of_transaction, transaction_date) VALUES ('.$accountnumber.', "'.$stock.'", '.$price.', '.$shares_numb.', "buy", '.time().')');
		
		
			
			
			//use amount to deduce from brokerage account balance.
			$db->exec('UPDATE Account SET balance = balance-'.$amount.' WHERE accountnumber='.$accountnumber);
			
			//close db connection
			$db = NULL;
		}
		catch (PDOException $e) { 
			throw new pdoDbException($e);
			echo $e->getMessage();			
		} 
	}
	//this method checks whether user owns a particular stock's shares
	public function ownsShares($accountnumber, $symbol){
		
		$db = connect_db();
		//Check that user exists
		$result = $db->query('SELECT * FROM Brokerage_Transactions WHERE accountnumber='.$accountnumber.' AND stock="'.$symbol.'"');
		
		foreach($result as $row) {//if user owns stock's shares
			$db=NULL;
			return true;
		}
		
		//close db connection
		$db=NULL;
		
		return false; //if user does not  own stock's shares
				
	}
	
	//this function checks if the user has enough shares to sell
	public function has_enough_shares($accountnumber, $symbol){
		$db = connect_db();
		//Count amount of shares bought
		$result = $db->query('SELECT SUM(numb_shares) AS total_shares FROM Brokerage_Transactions WHERE accountnumber='.$accountnumber.' AND type_of_transaction="buy" AND stock="'.$symbol.'"');
		
		$total = 0;//total number of shares
		foreach($result as $row) {
			
			$total = $row['total_shares']; //return number of shares
		}
		
		//Count amount of shares sold
		$result2 = $db->query('SELECT SUM(numb_shares) AS total_shares_sold FROM Brokerage_Transactions WHERE accountnumber='.$accountnumber.' AND type_of_transaction="sell" AND stock="'.$symbol.'"');
		
		foreach($result2 as $row2) {
			
			$total = $total - $row2['total_shares_sold']; //return number of shares sold
		}
		
		$db = NULL;
		
		return $total;
	}
	
	//this method helps user sell shares
	public function sell($stock, $shares_numb, $accountnumber, $price, $amount, $stock_value){
		//connect to database
		try{
			$db = connect_db();
			
		
			$result = $db->exec('INSERT INTO Brokerage_Transactions (accountnumber, stock, price, numb_shares, type_of_transaction, transaction_date) VALUES ('.$accountnumber.', "'.$stock.'", '.$price.', '.$shares_numb.', "sell", '.time().')');
		
			//add current loss and current profit
			if($stock_value < $price){ //if profit
				$db->exec('UPDATE brokerage_account SET currentprofit = currentprofit + ('.($price - $stock_value).'*'.$shares_numb.') WHERE accountnumber='.$accountnumber);
			}
			else{ //if loss
				$db->exec('UPDATE brokerage_account SET currentlost = currentlost + ('.($stock_value - $price).'*'.$shares_numb.') WHERE accountnumber='.$accountnumber);
					
			}
			
			//use amount to deduce from brokerage account balance.
			$db->exec('UPDATE Account SET balance = balance+'.$amount.' WHERE accountnumber='.$accountnumber);
			
			//echo $stock;
			//close db connection
			$db = NULL;
		}
		catch (PDOException $e) { 
			throw new pdoDbException($e);
			echo $e->getMessage();			
		} 
	}
	
	// this gets the fortfolio for the user
	public function showPortfolio($accountnumber){
		$db = connect_db();
		//get all the stocks the user owns
		$result = $db->query('SELECT DISTINCT stock FROM Brokerage_Transactions WHERE accountnumber='.$accountnumber);
		
		$portfolio = array();
		foreach($result as $row){
			$elements = array();
			$company = new Company();
			//get company info
			$companyinfo = $company->getCompanyInfo($row['stock']);
			$current_price = $companyinfo->quotes->quote->last;
			//echo '<br>'.$current_price;
			
			array_push($elements, $row['stock'], $current_price, $this->has_enough_shares($accountnumber, $row['stock']), ($current_price * $this->has_enough_shares($accountnumber, $row['stock'])));
			
			array_push($portfolio, $elements);
		}
		
		$db=NULL;
		return $portfolio;
	}
	
	public function transaction_history($accountnumber){
		
		$db = connect_db();
		//Check that user exists
		$result = $db->query('SELECT * FROM Brokerage_Transactions WHERE accountnumber='.$accountnumber);
		$transactions = array();
		foreach($result as $row){
			array_push($transactions, $row);
		}
			
		
		$db=NULL;
		return $transactions;
	}

}
?>