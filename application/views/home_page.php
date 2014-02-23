<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">

    <title>Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href=<?php echo base_url('public_html/css/bootstrap.css')?> rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href=<?php echo base_url('public_html/css/individual_css/home_page.css')?> rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
  	<div id="wrap">
	    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href=<?php echo site_url(""); ?>>Line Pictures</a>
	        </div>
	        <div class="collapse navbar-collapse">
	          
	          <ul class="nav navbar-nav navbar-right">
	            <?php
					if($this->session->userdata('logged_in'))
					{
						// has been logged in
						echo "<li>";
						echo anchor("console_controller/show_console_page", $this->session->userdata("account"));
						echo "</li>";
							
						echo "<li>";
						echo anchor("users_controller/send_logout", "Logout");
						echo "</li>";
					}
					else
					{
						echo "<li>";
						echo anchor("users_controller/show_login_page", "Login");
						echo "</li>";
						
						echo "<li>";
						echo anchor("users_controller/show_signup_page", "Sign up");
						echo "</li>";
					}
	            ?>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
	
	    <div id="first_container">
	      <div class="starter-template">
	        <h1>Upload your pictures!!</h1>
	        <p class="lead">These pictures will be used on your Facebook Messenger.</p>
	      </div>
	    </div><!-- /.container -->
  	</div>



	<div id="footer">
		<span class="container" text-align="center">
			© 2013 Company, Inc. · 
			<a href="#">Privacy</a>
         	·
         	<a href="#">Terms</a>
		</span>
		<span class="pull-right">
			<a href="#">Back to top</a>
		</span>
	</div>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
