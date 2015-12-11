<?php
/**
* @author Armand Nokbak 
	This is the model (class) that retrieves company's information.
**/
class Company{

	/**
	*	This method retrieves company's information.
	**/
	function getCompanyInfo($code){
		$search = "https://sandbox.tradier.com/v1/markets/quotes?symbols=".$code;
		$ch = curl_init($search);

		// Headers

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Accept: application/json",
		  "Authorization: Bearer WiCsBxxVaai9CSEi7LHBGrgCOmK2",
		));

		// Send synchronously

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);

		// Failure
		if ($result === FALSE)
		{
		  //echo "cURL Error: " . curl_error($ch);
		  return 'not_found';
		}

		// Success
		else
		{
			//echo "Request completed: " . $result. '<br><br>';
		}

		curl_close($ch);
		
		$json = json_decode($result);
		//echo $json->quotes->quote->description;
		return $json;
				
	}

}
?>