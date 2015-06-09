<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            var base_url = "<?php echo $base_url; ?>";
        </script>
        <script src="public/js/jquery-2.0.2.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
        <link href="public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="public/css/bootstrap-responsive.min.css" rel="stylesheet" />
        
        <link href="public/css/common.css" rel="stylesheet" />
    </head>
<body>
	<div class="login_container">
		<div class="form-login">
			<h2 class="form-login-heading">Please log in</h2>
			<input type="text" name="username" id="username" class="input-block-level" placeholder="ID">
			<input type="password" name="password" id="password" class="input-block-level" placeholder="Password">
			<button class="btn btn-primary btn-lg pull-right" type="submit" onclick="onLoginSubmit()">Log In</button>
		</div>
    </div>
	<script src="public/js/login.js"></script>
</body>
</html>