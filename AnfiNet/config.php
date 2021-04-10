<?php

	$db_host='localhost';
	$db_name='anfinet';
	$db_user='root';
	$db_password='';

	$conn_error="Connection failed";

	$con=mysqli_connect($db_host,$db_user,$db_password);
	mysqli_select_db($con,$db_name);

?>