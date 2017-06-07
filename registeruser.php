<head>
  <title>Multiple Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
.red
{
	color:red;
}
  </style>
</head>
<body>
<div class="container">
<?php
$server=$_SERVER['SERVER_NAME'];
$nameerr=$emailerr=$cpasserr="";
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["login"]))
{
	$password=htmlspecialchars($_POST["password"]);
	if($password === "registeruser")
		$_SESSION["reglognin"]=1;
	else
		$cpasserr="Invalid Password";
}
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["logout"]))
{
	$_SESSION["reglognin"]=0;
	session_unset(); 
	session_destroy();
}
$name=$email=$pass="";
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["register"]))
{
	$location=array('http://www.toce-cse.cf/registeruser.php','http://http://vturesult.cf/check/registeruser.php');
	$l=0;
	if($server == "www.toce-cse.cf")
		$l=1;
	$flag=1;
	include('function.php');
	$conn=get_connection();
	$name=test_input($_POST['name']);
	$email=test_input($_POST['email']);
	$pass=test_input($_POST["password"]);
	$hash=gethash($pass);
	$cpass=gethash(test_input($_POST["c-password"]));
	//Check if email already register
	$sql="SELECT `id` FROM `primeuser` WHERE `email`='$email'";
	$result = $conn->query($sql);
	if($result->num_rows == 1)
	{
		$emailerr="Email already belong to an User";
		$flag=0;
	}
	if($hash != $cpass)
	{
			$cpasserr="Password doesnot match";
			$flag=0;
	}
	if($flag)
	{
		$sql="INSERT INTO `primeuser`(`name`, `email`, `hash`) VALUES ('$name','$email','$hash')";
		if ($conn->query($sql) === TRUE) {
		$cpasserr="Registration Successful";
} else {
	$cpasserr="Error While Registring";
}
			$post = [
    'name' => "$name",
    'email' => "$email",
    'password'   => "$pass",
	'c-password' => "$pass",
	'register' => 'register'
];
$ch = curl_init($location[$l]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$response = curl_exec($ch);
curl_close($ch);
	}
	$conn->close();
	
}
if (isset($_SESSION["reglognin"]) && $_SESSION["reglognin"]==1)//loggedin to register
{
?>
<div class="row text-right">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<input type="submit" class="btn btn-link text-right" name="logout" value="Logout" >
</form>
</div>
<h3>Register</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<b>Name:</b><input type="text"  class="form-control" name="name" required value="<?php echo $name;?>"><span class="help-block red"><?php echo $nameerr; ?></span>
<b>Email:</b><input type="email"  class="form-control" name="email" required value="<?php echo $email;?>"><span class="help-block red"><?php echo $emailerr; ?></span>
<b>Password:</b><input type="password"  class="form-control" name="password"  required value="<?php echo $pass;?>">
<b>Confirm Password:</b><input type="password"  class="form-control" name="c-password"  required><span class="help-block red"><?php echo $cpasserr; ?></span>
<br><input type="submit" class="btn btn-primary btn-block" name="register" value="Register" >
</form>
<?php } else {?>

<h4>Login to Register</h4>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<b>Password:</b><input type="password"  class="form-control" name="password"  required><span class="help-block red"><?php echo $cpasserr; ?></span>
<input type="submit" class="btn btn-primary btn-block" name="login" value="Login" >
</form>
<?php }?>
</div>
</body>
</html>

