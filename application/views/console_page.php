<!DOCTYPE html>
<html lang="en">
  <head>
  	<?php
  		if(!$this->session->userdata("logged_in"))
  		{
  			redirect("users_controller/show_login_page","refresh");
  		}
  	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">

    <title>Console Page</title>

    <!-- Bootstrap core CSS -->
    <link href=<?php echo base_url('public_html/css/bootstrap.css')?> rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href=<?php echo base_url('public_html/css/individual_css/console.css')?> rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
  <script language="javascript">
	function delete_series_event(series_id)
	{
		var url = "<?php echo site_url("console_controller/delete_series/");?>";
		url = url.concat("/");
		url = url.concat(series_id);
		
		if(confirm("Are you sure to delete this image?"))
		{
			window.location.href=url;
		}

		return false;
	}
  </script>
  
  
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
					echo "<li>";
					echo anchor("console_controller/show_console_page",$this->session->userdata("account"));
					echo "</li>";
	          			
					echo "<li>";
					echo anchor("console_controller/send_logout","Logout");
					echo "</li>";
	          	?>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>

	    <div id="first_container">
	    	<div padding="40px 15px" text-align="left">
	    		<h1>Existing series</h1>
	    	</div>
	    </div>
	    <div class="container">
	    	<?php
	    		if(isset($series))
	    		{
	    			foreach ($series as $item)
					{
			?>
						<div text-align="left" class="col-md-8">
							<a href=<?php echo site_url("console_controller/show_series_page/{$item["id"]}"); ?>>
								<?php
									echo $item["name"];
									echo " : ";
									if($item["represented_image_id"]>0)
									{
										echo "<img src=";
										echo base_url("images/{$item["represented_image_file_name"]}");
										echo " width='15%' height='100px'>";
									}
								?>
							</a>
						</div>
						<div text-align="center" class="col-md-4">
							<a href=<?php echo site_url("console_controller/show_series_page/{$item["id"]}"); ?>>
								<button class="btn btn-success" type="submit">Edit</button>
							</a>
							
							<button type='button' onclick='delete_series_event(<?php echo $item["id"];?>)'>Delete</button>
							<a href=<?php echo site_url("console_controller/delete_series/{$item['id']}"); ?>>
								<button class="btn btn-success" type="submit">Delete</button>
							</a>
						</div>
			<?php
					}
	    		}
	    	?>
	    </div><!-- /.container -->
	    
		<div class="container">
			<div class="starter-template">
				<?php
					echo form_open('console_controller/new_series');
						echo "New Series Name : ";
						echo form_input("series_name");
						echo form_submit("submit","NEW SERIES");
					echo form_close();
				?>
				<script type="text/javascript">
					FB.getLoginStatus(function(response) {
						if (response.status === 'connected')
						{
							// the user is logged in and has authenticated your
							// app, and response.authResponse supplies
							// the user's ID, a valid access token, a signed
							// request, and the time the access token 
							// and signed request each expire
							var uid = response.authResponse.userID;
							var accessToken = response.authResponse.accessToken;
						}
						else if (response.status === 'not_authorized')
						{
							// the user is logged in to Facebook, but has not authenticated your app
							FB.login(function(response) {
							    if (response.authResponse)
								{
									// The person logged into your app
								}
								else
								{
							        // The person cancelled the login dialog
							    }
							});
						}
						else
						{
							//the user isn't logged in to Facebook.
							
						}
					}, ture);
				</script>
				
			</div>
		</div>
	
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
    <script src=<?php echo base_url("public_html/js/bootstrap.js")?>></script>
  </body>
</html>
