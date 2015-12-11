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
	<div class="alert alert-info" >
		<strong>Info! Please enter the company's exchange code below.<br>For Apple enter AAPL. For Facebook enter FB.<br>
		After you search for a stock, then the buy/sell option will be available.<br>
		You can only sell shares from the company which information will be displayed below.</strong>
	</div>
	
	

	<form class="form-inline" role="form" method="POST" action="../Home/companyInfo" style="float:right">
	  <div class="form-group">
		 <label >Enter ticker symbol:</label>
		<input type="text" class="form-control" name="companyCode" size="45">
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
	<br>
	
	<!-- search results -->
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
		
		<?php
			if(isset($_SESSION['buyError']) && ($_SESSION['buyError']!='')){
				echo '<div class="alert alert-danger" >
						<strong>'.$_SESSION['buyError'].'</strong>
					</div>
				';
				
			}
			if(isset($_SESSION['buySuccess']) && ($_SESSION['buySuccess']!='')){
				echo '<div class="alert alert-success" >
						<strong>'.$_SESSION['buySuccess'].'<br>You just bought '.$_SESSION['numbShares'].' share(s) of '.$_SESSION['stock_info']->quotes->quote->description.'</strong>
					</div>
				';
				
			}
			
			if(isset($_SESSION['sellSuccess']) && ($_SESSION['sellSuccess']!='')){
				echo '<div class="alert alert-success" >
						<strong>'.$_SESSION['sellSuccess'].'<br>You just sold '.$_SESSION['numbSharesSold'].' share(s) of '.$_SESSION['stock_info']->quotes->quote->description.'</strong>
					</div>
				';
				
			}
				
			$_SESSION['buyError']='';
			$_SESSION['buySuccess']='';
			$_SESSION['sellSuccess']='';
			
		?>
		
		<?php
			//making sure variables are set
			if(isset($_SESSION['stock_info'])){
		?>
		<form class="form-inline" role="form" method="POST" action="../Home/buyShares" style="float:left">
			<input type="hidden" name="price" value=<?php echo $_SESSION['stock_info']->quotes->quote->last;?>>
			<input type="text" class="form-control" name="numbShares" size="10" placeholder="# of shares">
			<button type="submit" class="btn btn-primary">Buy</button>
			<div class="form-group">
				
			
			</div>
		</form>
		<form class="form-inline" role="form" method="POST" action="../Home/sellShares" style="float:right">
			<input type="hidden" name="price" value=<?php echo $_SESSION['stock_info']->quotes->quote->last;?>>
			<div class="form-group">
				
				<input type="text" class="form-control" name="sellingPrice" size="10" placeholder="Selling Price">
				<input type="text" class="form-control" name="numb_shares_sold" size="15" placeholder="# of shares to sell">
				
				
			</div>
			<button type="submit" class="btn btn-primary">Sell</button>
		</form>
		<?php
			
			}// end of if(isset($_SESSION['stock_info']))
		?>
		
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