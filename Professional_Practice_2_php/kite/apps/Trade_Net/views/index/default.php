<?php
/**
* @author Armand Nokbak
**/
// This is the index page

//connects to ongoing session
if(!isset($_SESSION)){session_start();}
?>

<div class="col-md-4"></div>

<div class="col-md-4">

	<?php //to display error messages
	
		if(isset($_SESSION['errormessage'])){
			echo '
				<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				'.$_SESSION['errormessage'].'
				</div>
			';
			
		}
		unset($_SESSION['errormessage']);
		$_SESSION['errormessage']=NULL;
	?>
	<div class="alert alert-warning">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		If this is your first time using our system, make sure to configure the database first!
	</div>

	<form role="form" method="POST" action="../Home/checklogin">
	  <div class="form-group">
		<label for="username">username:</label>
		<input type="text" class="form-control" name="username">
	  </div>
	  <div class="form-group">
		<label for="pwd">Password:</label>
		<input type="password" class="form-control" name="pwd">
	  </div>
	  
	  <button type="submit" class="btn btn-default">login</button>
	</form>
</div>

<div class="col-md-4"></div>