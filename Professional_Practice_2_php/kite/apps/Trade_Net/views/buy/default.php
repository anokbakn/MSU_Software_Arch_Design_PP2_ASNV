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
	

	<form class="form-inline" role="form" method="POST" action="../Home/companyInfo" style="float:right">
	  <div class="form-group">
		 <label >Enter ticker symbol:</label>
		<input type="text" class="form-control" name="companyCode" size="45">
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
	<br>
	
	<!-- search results 
	<div class="col-md-12" style="margin-top:20px">
		<div class="alert alert-success" >
			<?php
				if(isset($_SESSION['stock_info'])){
					echo '<strong>Symbol: </strong>'.$_SESSION['stock_info']->quotes->quote->symbol
					.'<br><strong>Description: </strong>'.$_SESSION['stock_info']->quotes->quote->description
					.'<br><strong>Exchange: </strong>'.$_SESSION['stock_info']->quotes->quote->exch
					.'<br><strong>Last Price: </strong>$'.$_SESSION['stock_info']->quotes->quote->last
					.'<br><strong>Daily Net Change: </strong>'.$_SESSION['stock_info']->quotes->quote->change
					.'<br><strong>Daily Net Percentage: </strong>'.$_SESSION['stock_info']->quotes->quote->change_percentage
					.'<br><strong>Daily Volume: </strong>'.$_SESSION['stock_info']->quotes->quote->volume
					.'<br><strong>Daily Average Volume: </strong>'.$_SESSION['stock_info']->quotes->quote->average_volume
					.'<br><strong>52-Week High: </strong>'.$_SESSION['stock_info']->quotes->quote->week_52_high
					.'<br><strong>52-Week Low: </strong>'.$_SESSION['stock_info']->quotes->quote->week_52_low
					;
				}
			?>
		</div>
	</div>
	-->
	
</div>
<!-- right sidebar -->
<div class="col-md-3">
	<div class="well well-sm"><?php if(isset($_SESSION['ownerFN']) && isset($_SESSION['ownerLN'])){ echo $_SESSION['ownerFN'].' '.$_SESSION['ownerLN'];} ?></div>
	<div class="well well-sm">Your balance : <b><i>$<?php if(isset($_SESSION['balance'])){ echo $_SESSION['balance'];} ?></i></b></div>
</div>