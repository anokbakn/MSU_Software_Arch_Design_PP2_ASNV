<?php
/**
* @author Armand Nokbak
**/

class Home extends Kite {
	/**
	*	This function redirects to index page
	**/
	function main(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		if(isset($_SESSION['username'])){
			$this->render('HomePage');
		}
		else{
			$this->render('index');
		}
	}
	/**
	*	This function uses the user model to check user's login
	**/
	function checklogin(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		
		if(isset($_POST['username'])){ //if the user filled the index page's form
			$user = $this->getmodel('User');
			/** the login method returns null if not found, false if the user does not have a brokerage account
			* and true if the user does have a brokerage account
			**/
			$result = $user->login($_POST['username'], md5($_POST['pwd']));
			
			if($result == 'not a user'){
				$_SESSION['errormessage'] = 'You are not registered as a user!';
				$this->main(); // redirect to index page
			}
			else if($result == false){
				$_SESSION['errormessage'] = 'You do not have a brokerage account!';
				$this->main(); //redirect to index page
			}
			else if($result == true && isset($_SESSION['username'])){
				$this->render('HomePage');
			}
		}
		else{
			$this->main();
		}
		
	}
	
	/**
	* close session
	**/
	function logout(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		// remove all session variables
		session_unset(); 

		// destroy the session 
		session_destroy(); 
	
		$this->main();
	}
	
	/**
	* This method redirects to the HomePage after gathering the company's information
	**/
	function companyInfo(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		unset($_SESSION['errormessage']);
		$_SESSION['errormessage']=NULL;
		
		if(isset($_POST['companyCode'])){
			//get company information from tradier
			$company = $this->getmodel('Company')->getCompanyInfo($_POST['companyCode']);
			if($company==='not_found'){
				$_SESSION['errormessage'] = 'Stock not found';
			}
			else{
				$_SESSION['stock_info']= $company;
			}
		}
		else{
			$this->main();
		}
		
		
		$this->main();
	}
	//this function let's the brokerage account owner buy shares
	function buyShares(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		$_SESSION['buyError']='';
		$_SESSION['buySuccess']='';

		$amount = $_POST['price'] * $_POST['numbShares'];
		
		if($amount > $_SESSION['balance']){
			$_SESSION['buyError'] = 'Not enough money in your brokerage account';
		}
		else{
			$_SESSION['balance'] = $_SESSION['balance'] - $amount;
			$_SESSION['buySuccess'] = 'Shares bought successfully';
			$_SESSION['numbShares'] = $_POST['numbShares'];
			
			$this->getmodel('User')->buy($_SESSION['stock_info']->quotes->quote->symbol, $_SESSION['numbShares'], $_SESSION['accountnumber'], $_POST['price'], $amount);
		}
		
		
		$this->main();
	}
	
	
	//this function let's the brokerage account owner buy shares
	function sellShares(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		$_SESSION['buyError']='';
		$_SESSION['sellSuccess']='';
		
		if(isset($_SESSION['stock_info']) && isset($_SESSION['accountnumber']) && isset($_POST['numb_shares_sold']) ){
			
			$amount = $_POST['sellingPrice'] * $_POST['numb_shares_sold'];
			$_SESSION['numbShares'] = $_POST['numb_shares_sold'];
			//the current stock value
			$stock_value =  $_SESSION['stock_info']->quotes->quote->last;
			
			//the if statement below checks to see whether the user owns shares in the given stock
			if($this->getmodel('User')->ownsShares($_SESSION['accountnumber'], $_SESSION['stock_info']->quotes->quote->symbol)){
				//check to see if the user has enough shares to sell
				$total_numb_shares = $this->getmodel('User')->has_enough_shares($_SESSION['accountnumber'], $_SESSION['stock_info']->quotes->quote->symbol);
				
				if($total_numb_shares < $_POST['numb_shares_sold']){
					$_SESSION['buyError'] = 'You do not own enough shares in that stock to sell!';
				}
				else{
					//sell shares
					$this->getmodel('User')->sell($_SESSION['stock_info']->quotes->quote->symbol, $_POST['numb_shares_sold'], $_SESSION['accountnumber'], $_POST['sellingPrice'], $amount, $stock_value);
					$_SESSION['balance'] = $_SESSION['balance'] + $amount;
					$_SESSION['sellSuccess'] = 'Shares Sold successfully';
					$_SESSION['numbSharesSold'] = $_POST['numb_shares_sold'];
					
				}
			}
			else{
				$_SESSION['buyError'] = 'You do not own shares in that stock!';
			}
		}
		
		
		//redirect to main page
		$this->main();
		
	}
	
	//this method redirects to the portfolio
	function showPortfolio(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		
		if(isset($_SESSION['accountnumber'])){
			
			$_SESSION['portfolio'] = $this->getmodel('User')->showPortfolio($_SESSION['accountnumber']);
		}
		
		
		$this->render('portfolio');
	}
	
	function transactions(){
		//connects to ongoing session
		if(!isset($_SESSION)){session_start();}
		$_SESSION['transactions'] = $this->getmodel('User')->transaction_history($_SESSION['accountnumber']);
		
		$this->render('transactions_history');
		
	}
	
	


}



?>