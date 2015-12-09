<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <title>Trade Net Brokerage System</title>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
	
	


      
    <![endif]-->
    
    <!-- code from Bootply  -->
        <style>
            body {
                height: 100%;
                /*background-color: #f5f5f5;*/
                /* The html and body elements cannot have any padding or margin. */
            }
            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by its height */
                margin: 0 auto -60px;
                /* Pad bottom by footer height */
                padding: 0 0 60px;
            }
            /* Set the fixed height of the footer here */
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }
            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */
            #wrap > .container {
                padding: 60px 15px 0;
            }
            .container .credit {
                margin: 20px 0;
            }
            #footer > .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            code {
                font-size: 80%;
            }

            .navbar-header{
                padding-top: 15px;
            }
            .form-control{
                position:relative;
            }
            .form-group.required .control-label:after {
                content:"*";
                color:red;
            }
            th, td {
    		padding: 5px;
		}
        </style>

  </head>

  <body >

  <?php
  $home=$about=$services=$contact="";
	$node = KITE::getInstance('node');
	$o1 = $node->get('n1');
	if($o1=='')
		$home = 'active';
	elseif($o1 == 'about')
		$about ='active';
	elseif($o1=='services')
		$services="active";
	elseif($o1 =='contact')
		$contact ="active";
  
  ?>
    <div class="container"  background="../mississippi-state-bulldogs-logo-wallpaper.jpg">
      <div class="page-header">
      <?php
      	session_start();
      ?>
      
      <?php
      	/** Displaying the username**/
      	/**
      	if(isset($_SESSION['username'])){
	  		echo '<div id ="sizing-addon1" style=" clear: both"><p style="float:right">Welcome '.$_SESSION['username'].'</p></div>';
	  }
	  **/
      		?>
      
        <ul class="nav nav-pills pull-right">
          <li ><a href="../home/index">Home</a></li>
		  <!--<li><a href="../home/buyShares">Buy/Sell</a></li>-->
		  <li ><a href="#">Portfolio</a></li> 
	  <li ><a href="#">Contact</a></li>
	  <?php
        	if((isset($_SESSION['role'])) && ($_SESSION['role']=="admin")){
        		echo '<li ><a href="../home/adminConsole">Admin Console</a></li>';
        	
        	}
           ?>
	  <?php		/** HERE WE TOGGLE BETWEEN LOGIN AND LOGOUT **/
	  	if(!isset($_SESSION['username'])){
	  		echo '<li class="<?php echo $login; ?>"><a href="../home/showLoginPage">Login/Register</a></li>';
	  	} else{
	  		echo '<li class="<?php echo $logout; ?>"><a href="../home/logout">Not '.$_SESSION['username'].' / Logout</a></li>';
	  	}
	  
	  ?>
	  
        </ul>
        
        
        <h3 class="text-muted"><b>Trade Net Brokerage System</b></h3>
        
        
        
        
        
        	
      </div>
	 
	 
	 	<!--code from Bootply  -->
		<!-- Begin page content -->

    <!-- sidebar -->
    <div class="row">
    <div class="col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
        <ul class="nav">
            <li class="active"><a href="../home/index">Home</a></li>
            <!--<li><a href="../home/buyShares">Buy/Sell</a></li>-->
			<li><a href="#">Portfolio</a></li>
                         
        </ul>
    </div>
    
    <div class="col-md-10">
	 		<?php echo '<br>'; ?>

			<?php KITE::app(); ?>
 
 	</div>	<!-- end of div class="col-md-9" for the entire content-->

	</div> <!-- end of div class="row" for the entire body-->
 	
      <div class="footer" style="clear:both">
        <div><!--KITE FRAMEWORK-->
		<div class="pull-right">by MSU Software Arch. Group.  copyright 2015</a></div>
		</div>
		
      </div>

    </div> <!-- /container -->

  </body>
</html>