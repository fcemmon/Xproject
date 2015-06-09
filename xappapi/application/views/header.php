<!DOCTYPE html>

<html>
    <head>
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            var base_url = "<?php echo $base_url;?>";
        </script>

        <link href="<?php echo $base_url;?>public/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
        <link href="<?php echo $base_url;?>public/css/jquery.mCustomScrollbar.css" rel="stylesheet" />
        <link href="<?php echo $base_url;?>public/css/msgBoxLight.css" rel="stylesheet" />
        <link href="<?php echo $base_url;?>public/css/timepicker-addon.css" rel="stylesheet" />
		
        <link href="<?php echo $base_url;?>public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo $base_url;?>public/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link href="<?php echo $base_url;?>public/css/theme.bootstrap.css" rel="stylesheet" />
		
        <link href="<?php echo $base_url;?>public/css/common.css" rel="stylesheet" />         
		
        <script src="<?php echo $base_url;?>public/js/jquery-2.0.2.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery-ui-timepicker-addon.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.validate.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.msgBox.js" type="text/javascript"></script>
        <script src="<?php echo $base_url;?>public/js/bootstrap.min.js"></script>        

    </head>
 <body>
     
    <div class="container">
        <!----------------------header----------------->

            <div class="navbar navbar-fixed-top" style="margin: 0px;">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse" style="margin-top:15px">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <div class="nav-collapse navbar-inverse-collapse">   
                    <ul class="nav" id="nav1">
						<li class="menu-text <?php echo ($header == "users")?"active":""; ?>">
							<a href="<?php echo $base_url;?>index.php/users/index"><h5>Users</h5></a>
						</li>
						<li class="menu-text <?php echo ($header == "medias")?"active":""; ?>">
							<a href="<?php echo $base_url;?>index.php/medias/index"><h5>Medias</h5></a>
						</li>
                    </ul>
					
                    <ul class="nav pull-right" id="nav2">
						<li class="signout dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-top:12px">
								<i class="icon-user icon-white"></i><b class="caret"></b>
							</a>
	                        <ul class="dropdown-menu">
	        	              <li><a onclick="onChangePassword();" style="cursor:pointer"><i class="icon-lock icon-white"></i>Change Password</a></li>
	                    	</ul>
                      	</li>
						
                        <li class="signout" ><a onclick="logout();" style="cursor:pointer"><h5>Log out</h5></a></li>
                    </ul>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>