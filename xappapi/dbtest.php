<?php
	$dbhost = 'localhost';
	
	$dbuser = 'root';	$dbpass = '';	$dbname = 'conscio0_xappapi';
   
	$dbuser = 'conscio0';	$dbpass = '2dt)ftWg6OeP';	$dbname = 'conscio0_xappapi';
	
	$table_name = 'tbl_users';
	
	echo "db test:<br>";
	echo 'PHP_VERSION:'.PHP_VERSION.'<br>'  ;
	echo 'PHP_SAPI:'.PHP_SAPI.'<br><br>'  ;
	echo 'dbuser:'.$dbuser.'<br>'.'dbpass:'.$dbpass.'<br>'.'dbname:'.$dbname.'<br><br>';
	
	if(PHP_VERSION > '5.4'){
		echo 'PHP_VERSION > 5.4 <br>'  ;
		
		$link = mysql_connect($dbhost, $dbuser, $dbpass) or die('Could not connect: ' . mysql_error());
		mysql_select_db($dbname) or die('Could not select database');
				
		// Performing SQL query
		$query = "SELECT * FROM $table_name";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		// Printing results in HTML
		echo "<hr>$table_name<table border=1 cellspacing=0 cellpading=0>\n";
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table><hr>\n";

		// Free resultset
		mysql_free_result($result);

		// Closing connection
		mysql_close($link);

	}else if(PHP_VERSION > '5.3'){
		echo 'PHP_VERSION > 5.3 <br>'  ;
		
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

		if ($mysqli ->connect_errno) {
			die('Connect Error (' . $mysqli ->connect_errno . ') '. $mysqli ->connect_error);
		}
		
		// Performing SQL query
		$query = "SELECT * FROM $table_name";
		$result = $mysqli ->query($query) or die('Query failed: ' .$mysqli->error);

		// Printing results in HTML
		echo "<hr>$table_name<table border=1 cellspacing=0 cellpading=0>\n";
		while ($line = $result ->fetch_array(MYSQLI_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table><hr>\n";


		// Closing connection
		$mysqli ->close();
		
	}
	
	
	
	echo "status:ok";
?>