<?php	

	$host = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "pj";
	
	
	
	//Database connection
	$condb = mysqli_connect($host,$dbusername,$dbpassword,$dbname);
	if(!$condb)
	{
		die("gagal");
	}
	else
	{
		#die("berjaya");
	}
	
	
?>