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

    <title>Series Page</title>

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
  
  <style>
  	#second_container {}
  	
  </style>
  
  <script language="javascript">
	function delete_image_event(series_id, image_id)
	{
		var url = "<?php echo site_url("console_controller/delete_image/");?>";
		url = url.concat("/");
		url = url.concat(series_id);
		url = url.concat("/");
		url = url.concat(image_id);	
		
		if(confirm("Are you sure to delete this image?"))
		{
			window.location.href=url;
		}

		return false;
	}

	function change_series_name(series_id, original_name)
	{
		name=prompt("enter new name" , original_name);

		alert(name);
		
		if(name!=null && name!="" && name!="null")
		{
			var url = "<?php echo site_url("console_controller/change_series_name/");?>";
			url = url.concat("/");
			url = url.concat(series_id);
			url = url.concat("/");
			url = url.concat(name);
			window.location.href=url;			
		}
		
		return false;
	}

	function choose_series_representation(series_id)
	{
		$("#second_container").selectable("enable");

		var str="change_series_representation(".concat(series_id).concat(")");
		document.getElementById("representation_id").setAttribute("onclick",str);
		document.getElementById("representation_id").innerHTML="send choice";
	}

	function change_series_representation(series_id)
	{
		var image_id = $("div[class$='ui-selected']").attr("image_id");
			
		var url = "<?php echo site_url("console_controller/change_series_representation/");?>";
		url = url.concat("/");
		url = url.concat(series_id);
		url = url.concat("/");
		url = url.concat(image_id);
		window.location.href=url;

		//$("#second_container").selectable("disable");
		//$("div[class$='ui-selected']").removeclass("ui-selected");
		
		return false;
	}

	function delete_images()
	{
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
	
	    
	    <?php
	    	if(isset($series) && isset($images))
	    	{
	    ?>
				<div id="first_container">
					<div padding="40px 15px" text-align="left">
						<h1><?php echo $series["name"]; ?></h1>
						<button type='button' onclick='change_series_name(<?php echo $series["id"];?>,"<?php echo $series["name"];?>")'>change series' name</button>
						<span>
							<button type='button' id="representation_id" onclick="choose_series_representation(<?php echo $series["id"];?>)">change series' cover</button>
						</span>
					</div>
				</div>
				
				
      			<?php
      				$attributes = array("class" => "container","role" => "form");
      				echo form_open("console_controller/save_comments/{$series["id"]}", $attributes);
      			?>
      				<div class ="container" id="second_container">
					<?php
						$i=0;
						
						foreach ($images as $image)
						{
							if($i==0)
							{
								echo "<div class='container' image_id='{$image["id"]}'>";
							}
							
							if($i%4==0 && $i!=0)
							{
								echo "</div>";
								echo "<br /><div class='container' image_id='{$image["id"]}'>";
							}
							
							echo "<div class='col-md-3'>";
								echo "<img src=";
								echo base_url("images/{$image["file_name"]}");
								echo " width='25%' height='100px'>";
								echo "<div><textarea rows='3' name='descriptions[{$image["id"]}]' placeholder='description...'>";
								//echo "<div><textarea rows='3' name='comment{$image["id"]}' placeholder='description...'>";
								echo $image["comment"];
    							echo "</textarea></div>";
    							
    							$url=site_url("console_controller/delete_image/{$series["id"]}/{$image["id"]}");
    							echo "<button type='button' onclick='delete_image_event({$series["id"]},{$image["id"]})'>Delete</button>";
    							
    							echo "<a href=";
    							echo site_url("console_controller/delete_image/{$series["id"]}/{$image["id"]}");
    							echo "><button class='btn btn-success' type='button'>Delete</button></a>";
							echo "</div>";
							
							$i++;
						}
						
						while ($i%4!=0)
						{
							echo "<div class='col-md-3'></div>";
							$i++;
						}
						
						echo "</div>";
					?>
					<button class="btn btn-success" type="submit">Save</button>
					
					</div>
				</form>
	    <?php
	    	}
	    	else 
	    	{
	    		redirect("","refresh");
	    	}
	    ?>
	    <br /><br />
	    <div class="container">
			<form action="<?php echo site_url("console_controller/add_images/{$series["id"]}");?>" method="post" enctype="multipart/form-data">
				<input type="file" name="upload_images[]" size="20" multiple />
				<br />
				<input type="submit" value="UPLOAD" />
			</form>
			
	    	<!--
			<?php //echo form_open_multipart("console_controller/add_images/{$series["id"]}");?>
				<input type="file" name="userfile" size="20" />
				<br />
				<input type="submit" value="UPLOAD" />
			</form>
			-->
			
		</div>
  	</div>
    


	<div id="footer">
		<p class="pull-right">
			<a href="#">Back to top</a>
		</p>
		<p>
			© 2013 Company, Inc. · 
			<a href="#">Privacy</a>
         	·
         	<a href="#">Terms</a>
		</p>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
