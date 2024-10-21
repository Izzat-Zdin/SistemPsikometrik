<?php
include('connect.php');
	
	if(!empty($_POST))
	{
		$jadual = "guru_acc";
		$fullname = mysqli_real_escape_string($condb,$_POST['guru_nama']);
		$email = mysqli_real_escape_string($condb,$_POST['guru_email']);
		$password = mysqli_real_escape_string($condb,$_POST['guru_pass']);
		
    
	
	if(empty($fullname) or empty($password) or empty ($email))
	{
		die("<script> alert(' Sila Lengkapkan Pendaftaran ');
		window.history.back();</script>");
	}
	$simpan = "insert into guru_acc
	(guru_nama,guru_email,guru_pass)
	values
	('$fullname','$email','$password')";
	
	if(mysqli_query($condb,$simpan))
	{
		echo ("<script> alert('berjaya');
		window.location.href = '../login-guru.php';</script>");
		}
	else
	{
		echo "<script>alert('berjaya')</script>";
	}
	$arahanpenyewa = "SELECT * FROM guru_acc
    where
    guru_acc.guru_email =  '".$_SESSION['guru_email']."'
        ORDER BY guru_acc.guru_nama ASC ";

    $laksanapenyewa = mysqli_query($condb,$arahanpenyewa);

    while($data= mysqli_fetch_array($laksanapenyewa))
    {
      $dataguru=array(
      'guru_nama' => $data['guru_nama'],
      'guru_email' => $data['guru_email'],
	  'guru_pass' => $data['guru_pass'],
      );
    }
  }
	
include ('SignUpGuru.html');
	?>