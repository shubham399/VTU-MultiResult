<!DOCTYPE html>
<html lang="en">
<head>
  <title>Multiple Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
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
</style>
<body>
<div class="container">
<header><img src="../logo.png" class="img-responsive"  alt="VTU LOGO"></header>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["Check"]))
{
  $start=htmlspecialchars($_POST["start"]);
	if(!isset($_POST["end"]))
		$end=$start;
	else if(empty($_POST["end"]))
		$end=$start;
	else
	$end=htmlspecialchars($_POST["end"]);
	$base=substr($start,0,7);
	$verify=substr($end,0,7);

	$base=strtoupper($base);
	$verify=strtoupper($verify);
	$comp=strcmp($base,$verify);
	$usn="";
	if(!$comp)
	{
		$s=(int)substr($start,7);
		$e=(int)substr($end,7);
		if(($e-$s)>50)
		{
			$e=$s+50;
		}
		for($i=$s;$i<=$e;$i++)
		{
			$usn=$base;
			if($i<10)
			$usn=$usn."00";
			else if($i<100)
			$usn=$usn."0";
			$usn=$usn.$i;
      echo "<div class=\"container\">";
	  if(!file_exists("../results/$usn.xml"))
	  {
		usleep(1);
		//curlit($usn);
					echo "<iframe src=\"get_result.php?usn=".$usn."\"class=\"table\" height=485	 style=\"border:none\"></iframe>";
	  }
	  else
	  {
		  $file=fopen("../results/$usn.xml","r");
		  $buff=fread($file,filesize("../results/$usn.xml"));
		  echo $buff;
		  fclose($file);

	  }
      echo "</div>";

    }
}
}
else {
  ?>
  <div class="text-center">
<br><br><br><b>WE RECOMMEND 10 RESULTS AT A TIME ELSE MAY RESULT IN BROWSER CRASH</b><br/>
<div class="row pad bg-1">
<div class="col-sm-4 "></div>
	<div class="col-sm-4 ">
	<h3>Get Results:</h3>
	<form method="post" id="usn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<b>START USN:</b><input type="text" id="start" class="form-control" name="start" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN" required>*<br>
	<b>END USN:</b><input type="text" class="form-control" name="end" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN"><br>
<br><input type="submit" class="btn btn-primary" name="Check" value="GET RESULT">
</form>
</div>
</div>
  <?php
}
?>
<div class="container">
    <hr />
		<p class="help-block text-center"><b>By:</b>Shubham</p>
        <div class="text-center center-block">
                <a href="http://github.com/shubham399"><i class="fa fa-github fa-3x social"></i></a>
</div>
<div class="help-block text-centre">
<b>Liked My Work?  Help me to get a Cup of Coffee and stay motivated to work on this Project <a class="btn btn-hot text-uppercase btn-lg" href="https://www.payumoney.com/paybypayumoney/#/310421">Donate <span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a></b>

</div>
</div>
</body>
</html>
