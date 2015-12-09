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
		$_SESSION = array();
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
		}
		
		
		$this->main();
	}


}



?>