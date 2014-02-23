<!DOCTYPE html>
<html lang="en">
  <head>
  	<?php
  		if($this->session->userdata("logged_in"))
  		{
  			redirect("","refresh");
  		}
  	?>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">

    <title>Login Page</title>

    <!-- Bootstrap core CSS -->
    <link href=<?php echo base_url('public_html/css/bootstrap.css')?> rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href=<?php echo base_url('public_html/css/individual_css/login.css')?> rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
				// has been logged in
				echo "<li>";
				echo anchor("users_controller/show_login_page", "Login");
				echo "</li>";
					
				echo "<li>";
				echo anchor("users_controller/show_signup_page", "Sign up");
				echo "</li>";
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <?php
      	$attributes = array('class' => 'form-signin', 'role' => 'form');
      	echo form_open("users_controller/send_login", $attributes);
      ?>
        <h2 class="form-signin-heading">Please <?php if(isset($action_type)){echo $action_type;} ?></h2>
        <?php
        	$attributes = array(
        		'name'=>'account',
				'class'=>'form-control',
				'placeholder'=>'Account',
				'required'=>true,
				'autofocus'=>true,
        	);
        	echo form_input($attributes);
        ?>
        <?php
        	$attributes = array(
        		'name'=>'password',
				'class'=>'form-control',
				'placeholder'=>'Password',
				'required'=>true,
        	);
        	echo form_password($attributes);
        ?>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>

