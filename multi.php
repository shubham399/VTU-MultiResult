<?php 
session_start();
if(!isset($_SESSION['userid']))
	header('Location: index.php');
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
</style>
<body>
<div class="container">
<header><img src="logo.png" class="img-responsive"  alt="VTU LOGO"></header>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["Check"]))
{
  $start=htmlspecialchars($_POST["start"]);
  $type=htmlspecialchars($_POST["rtype"]);
  if($type!=1 && $type != 2)
	  $type=1;
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
	  $t=$type-1;
	  $locations=array("results","reval");
	  if(!file_exists("$locations[$t]/$usn.xml"))
	  {
		usleep(1);
		//curlit($usn);
					echo "<iframe src=\"get_result.php?usn=".$usn."&type=$type\"class=\"table\" height=485	 style=\"border:none\"></iframe>";
	  }
	  else
	  {
		   require_once('function.php');
		   $page=htmlspecialchars($_SERVER["PHP_SELF"]);
		  $hash=gethash("$usn|$page|$type");
		  $link="<div class=\"row text-center\"><h3><a href=\"recheck.php?usn=$usn&hash=$hash&tl=$page&type=$type\">Recheck $usn Result</a></h3></div>";
		  echo $link;
		  $file=fopen("$locations[$t]/$usn.xml","r");
		  $buff=fread($file,filesize("$locations[$t]/$usn.xml"));
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
  <div class="text-right"><a href="logout.php">Logout</a></div>
<br><br><br><b>WE RECOMMEND 10 results AT A TIME ELSE MAY RESULT IN BROWSER CRASH</b><br/>
<div class="row pad bg-1">
<div class="col-sm-4 "></div>
	<div class="col-sm-4 ">
	<h3>Get Results:</h3>
	<form method="post" id="usn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<b>START USN:</b><input type="text" id="start" class="form-control" name="start" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN" required>*<br>
	<b>END USN:</b><input type="text" class="form-control" name="end" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN"><br>
	<select name="rtype" class="form-control">
<option value="1">Regular</option>
<option value="2">Revaluation</option>
</select>
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
<div class="row">       
      
</div>
</div>
</body>
</html>
