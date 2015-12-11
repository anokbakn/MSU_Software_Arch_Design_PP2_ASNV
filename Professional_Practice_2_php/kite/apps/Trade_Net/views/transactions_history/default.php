<?php
	/**
	* @author Armand Nokbak
	**/
	//connects to ongoing session
	if(!isset($_SESSION)){session_start();}
?>
<!-- Left sidebar -->
	<div class="col-md-1"></div>
<!-- main area -->
<div class="col-md-8">
	
	<!-- search results -->
	<div class="col-md-12" style="margin-top:20px">
		
		<table class="table">
			<thead>
			  <tr>
				<th>Stocks</th>
				<th>Price</th>
				<th># of shares</th>
				<th>Type of transaction</th>
				<th>Transaction date</th>
			  </tr>
			</thead>
		  <?php
				if(isset($_SESSION['transactions'])){
					foreach($_SESSION['transactions'] as $row){
						$date = new DateTime();
						$date->setTimestamp($row[6]); 
						echo '<tr><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.$date->format('Y-m-d H:i:s').'</td></tr>';
					}
				}
		  ?>
		  
		</table>
	</div>
	<br>
	<br>
</div>
<!-- right sidebar -->
<div class="col-md-3">
	<div class="well well-sm"><?php if(isset($_SESSION['ownerFN']) && isset($_SESSION['ownerLN'])){ echo $_SESSION['ownerFN'].' '.$_SESSION['ownerLN'];} ?></div>
	<div class="well well-sm">Account number : <b><i><?php if(isset($_SESSION['accountnumber'])){ echo $_SESSION['accountnumber'];} ?></i></b></div>
	<div class="well well-sm">Your balance : <b><i>$<?php if(isset($_SESSION['balance'])){ echo $_SESSION['balance'];} ?></i></b></div>
</div>