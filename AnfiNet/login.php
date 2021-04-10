<?php
session_start();
if(isset($_POST['login'])){
	include('config.php');
	$eid=$_POST['eid'];
	$pass=$_POST['password'];
	$query="SELECT id,First_Name,Last_Name,Academic_Year,Email,member_level,Password FROM user WHERE id='".$eid."';";

	$result=mysqli_query($con,$query);
	$num=mysqli_num_rows($result);
	if($num===1){
		$row=mysqli_fetch_assoc($result);
		if(password_verify($pass,$row['Password'])){
			$m_level=$row['member_level'];
			$_SESSION['fname'] = $row['First_Name'];
			$_SESSION['lname'] =  $row['Last_Name'];
			$_SESSION['email'] =  $row['Email'];
			$_SESSION['year'] =  $row['Academic_Year'];
			$_SESSION['username'] = $eid;
			$_SESSION['password'] = $pass;

			if($m_level==='1'){
				header('Location: admin.php') ;
				$_SESSION['mlevel']=1;
			}else{
				header('Location: user.php');
				$_SESSION['mlevel']=0;
			}
		}else{
			header('Location: index.php');
			$_SESSION['error']="Incorrect password.";
		}
	}
	else{
		header('Location: index.php');
		$_SESSION['error']="There is no account by this id.";

	}



}

?>
