<?php 
session_start();
if(isset($_SESSION['userid']))
	header('Location: multi.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Multiple Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<style>
.pad {
    padding-top: 50px;
    padding-right: 30px;
    padding-bottom: 50px;
    padding-left: 80px;
}
.bg-1 {
    background-color: white; /* Green */
    color: #000000;
}
.red
{
	color:red;
}
</style>
<body>
<div class="container">
<header><img src="logo.png" class="img img-responsive"  alt="VTU LOGO"></header>
<?php
$loginerr="";
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["login"]))
{
	include('function.php');
	$conn=get_connection();
	$email=test_input($_POST['email']);
	$pass=gethash(test_input($_POST["password"]));
	$sql="SELECT `id` FROM `primeuser` WHERE `email`='$email' and `hash`='$pass'";
	$result = $conn->query($sql);
	$conn->close();
	if($result->num_rows == 1)
	{	$row = $result->fetch_assoc();
		$_SESSION['userid']=$row['id'];
		header('Location: ./multi.php');
	}
	else
	$loginerr="Invalid Username or Password";
	
}
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["Check"]))
{
	$usn=strtoupper(htmlspecialchars($_POST["usn"]));
	$rtype=htmlspecialchars($_POST["rtype"]);
	if($rtype!= 1 && $rtype != 2)
		$rtype=1;
	if(isset($_COOKIE['usn']))
	{
		$hash=$_COOKIE['hash'];
		require_once('function.php');
		$newwhash=gethash($_COOKIE['usn']);
		if($hash==$newwhash)
		{
		$usns=explode(",",$_COOKIE['usn']);
		$f=1;
		foreach($usns as $i)
		{
			if($i==$usn)
			{
				$f=0;
				break;
			}
		}
		}
		else
		{
			$usns="SHH YOU FOUND OUR LITTLE SECRET NOW MAIL ME A SCREENSHOT OF THIS PAGE WITH STEPS HOW YOU DID IT TO GET A PRIME ACCOUNT mail at shubham.399@gmail.com";
					require_once('function.php');
					$hash=gethash($usns);
					setcookie('usn',$usns,(time()+60*60*24));
		setcookie('hash',$hash,(time()+60*60*24));
		}
		if(sizeof($usns)<10 && $f==1)
		{
		array_push($usns,$usn);
		$usns=implode(",",$usns);
		require_once('function.php');
		$hash=gethash($usns);
		setcookie('usn',$usns,(time()+60*60*24));
		setcookie('hash',$hash,(time()+60*60*24));
		}
	}
	else
	{
		require_once('function.php');
		$hash=gethash($usn);
		setcookie('usn',$usn,(time()+60*60*24));
		setcookie('hash',$hash,(time()+60*60*24));
	
	}
	header('Location: ./get_result.php?usn='.$usn."&type=".$rtype);
}
?>
<h3 class="help-block text-center">Check Your Result and 7 Friends Results for Free .. with 2 enemies too :P </h3><hr>
<form method="post" id="usn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirm('You will be allowed to check only 10 USNs in future\nDo You want to continue?');">
<b>USN:</b><input type="text" id="start" class="form-control" name="usn" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN" required><br>
<select name="rtype" class="form-control">
<option value="1">Regular</option>
<option value="2">Revaluation</option>
</select>
<br><input type="submit" class="btn btn-primary btn-block" name="Check" value="GET RESULT" >
</form>
<hr>
<h4 class="text-center">Due to Heavy Server Load ,Bandwidth and high maintance the Multiple Results will be coming soon as a Prime Member only feature </h4>
<hr>
<div class="container">
<ul class="nav nav-tabs center-block">
  <li class="active"><a data-toggle="tab" href="#login">Login</a></li>
  <li><a data-toggle="tab" href="#register">Register</a></li>
</ul>
<hr>
<div class="tab-content">
  <div id="login" class="tab-pane fade in active">
    <h3>Login</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<b>Email:</b><input type="email"  class="form-control" name="email" required><br>
<b>Password:</b><input type="password"  class="form-control" name="password"  required><br>
<p class="help-block red"><?php echo $loginerr;?></p><br>
<br><input type="submit" class="btn btn-primary btn-block" name="login" value="Login" >
</form>

  </div>
  <div id="register" class="tab-pane fade">
  <!--
    <h3>Register</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<b>Name:</b><input type="text"  class="form-control" name="name" required><br>
<b>Email:</b><input type="email"  class="form-control" name="email" required><br>
<b>Password:</b><input type="password"  class="form-control" name="password"  required><br>
<b>Confirm Password:</b><input type="password"  class="form-control" name="c-password"  required><br>
<br><input type="submit" class="btn btn-primary btn-block" name="register" value="Register" >
</form>
-->
<p>Donate <b>20 INR</b> at donateshubham@uboi through UPI and send an mail which should contain Name,email,password and the Screenshot of the successful donation.Your account will be opened within 24 hours</p>
<a href="mailto:tocecse.cf@gmail.com">Mail Here</a>
<img class="img img-responsive" src="payqr.jpeg"/> Scan QR to Pay
  </div>
</div>
</div>
<div class="container">
<hr><br><br><br><br><br><p class="help-block">Find an Easter Egg and get free from the bond of "Check Your Result and 7 Friends Results for Free .. with 2 enemies too :P"</p> 
</div>
<div class="container">
    <hr />
		<p class="help-block text-center"><b>By:</b>Shubham</p>
        <div class="text-center center-block">
                <a href="http://github.com/shubham399"><i class="fa fa-github fa-3x social"></i></a>
				</div>
				<div class="row">       
      </div>


</div>
</body>
</html>