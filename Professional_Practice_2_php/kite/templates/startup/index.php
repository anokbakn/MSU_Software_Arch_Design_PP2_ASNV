
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Startup Teamplate</title>
    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
	
	<style>
	#logo{
		
	}
	.texture{
		margin-top:20px;
		height:150px;
		background:#F4FAFE;
		background: 
		linear-gradient(63deg,  #E6F6FF  23%, transparent 23%) 2px 0, 
		linear-gradient(63deg, transparent 74%,  #E6F6FF 78%), 
		linear-gradient(63deg, transparent 34%,  #E6F6FF 38%, #E6F6FF 58%, transparent 62%), 
		#F4FAFE;
		background-size: 5px 5px;
	}
	
	.wrap{
	background: #e5f5ff; /* Old browsers */
background: -moz-linear-gradient(top,  #e5f5ff 0%, #ffffff 33%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e5f5ff), color-stop(33%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e5f5ff 0%,#ffffff 33%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e5f5ff 0%,#ffffff 33%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e5f5ff 0%,#ffffff 33%); /* IE10+ */
background: linear-gradient(to bottom,  #e5f5ff 0%,#ffffff 33%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5f5ff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

	}
	#body-wrapper {

    height: 100%;
    width: 100%;
}
	

	</style>
  </head>

  <body>
  <div id="body-wrapper">
    <div class="wrap">

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
  
  <div class="navbar navbar-inverse ">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <li class="<?php echo $home; ?>"><a href="<?php echo ROOT; ?>index.php&tmpl=startup">Home</a></li>
          <li class="<?php echo $about; ?>"><a href="<?php echo ROOT; ?>about&tmpl=startup">About</a></li>
          <li class="<?php echo $services; ?>"><a href="<?php echo ROOT; ?>services&tmpl=startup">Services</a></li>
		     <li class="<?php echo $contact; ?>"><a href="<?php echo ROOT; ?>contact&tmpl=startup">contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
	<img  id="logo" src="<?php echo ROOT; ?>img/kite_logo.png" />

        <?php KITE::app() ?>
		
		 <div class="footer">
		 <hr>
        <div>KITE FRAMEWORK @ www.packetcode.com
		<div class="pull-right">by 
		<a href="http://www.twitter.com/shaadomanthra">Krishna Teja</a></div>
		</div>
    </div><!-- /.container -->
	
	</div>
	</div>
  </body>
</html>
