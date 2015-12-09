<?php
/**
* @author Armand Nokbak
**/
?>


<br>

<?php
	// Request: Market Quotes (https://sandbox.tradier.com/v1/markets/quotes?symbols=spy)

	$ch = curl_init("https://sandbox.tradier.com/v1/markets/quotes?symbols=spy");

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
		echo "cURL Error: " . curl_error($ch);
	}

	// Success
	else
	{
		echo "Request completed: " . $result;
	}

	curl_close($ch);

	try
	{
		//open the database
		//This is the link from the Kite folder inside the htdocs folder of xampp
		$db = new PDO('sqlite:../../../Users/anokbakn/Documents/Professional_Practice_1/BAMS7.db');

		//create the database

		$result = $db->query('SELECT * FROM Person');

		foreach($result as $row) {
			print "<br>".$row[0];
		}

		$db = NULL;

	}
	catch(PDOException $e)
	{
		print 'Exception : '.$e->getMessage();
	}

	 

	echo '<br>'. md5('ABCDEFGH124');



?>