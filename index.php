<!DOCTYPE html>
<html lang="en">
<head>
  <title>Multiple Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
<header><img src="http://results.vtu.ac.in/results/images/logo.png"  alt="VTU LOGO"></header>
<?php
function curlit($usn)
{
  $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,'http://results.vtu.ac.in/results/result_page.php?usn='.$usn);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);

  while (empty($buffer)){
        $buffer = curl_exec($curl_handle);
        	 usleep(20);
  }
  curl_close($curl_handle);
 	  $found=0;
		$found=stripos($buffer,'<script type="text/javascript">');
		if($found)
		{
			echo "<div class=\"col-md-12\"><div class=\"panel panel-warning\">
										<div class=\"panel-heading text-center\">
Invalid USN or Result Yet Not Available</br></div></div></div>";
		}
		else if($found === false)
		{
		$extract = array("start" =>'	<div class="row" style="margin-top:20px;">', "end"=>'																			</table>');
		$start = stripos($buffer, $extract['start']);
		$end = strripos($buffer, $extract['end']);
		$buffer = substr($buffer, $start, $end);
		$buffer=$buffer."</table></div>";
    print $buffer."<br>";
		}
}
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["Check"]))
{
  $start=htmlspecialchars($_POST["start"]);
	if(!isset($_POST["end"]))
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
			$e=$s+10;
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
      curlit($usn);
      echo "</div>";
      usleep(10);
    }
}
}
else {
  ?>
  <div class="text-center">
<br><br><br><b>ONLY 10 RESULTS AT A TIME ELSE MAY CAUSE IN BROWSER CRASH</b><br/>
<div class="row pad bg-1">
<div class="col-sm-4 "></div>
	<div class="col-sm-4 ">
	<h3>Get Results:</h3>
	<form method="post" id="usn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<b>START USN:</b><input type="text" id="start" class="form-control" name="start" pattern="[1-4]{1}[A-Za-z]{2}[0-9]{2}[A-Za-z]{2}[0-9]{3}" title="Please Enter 1st 7 character of the USN" ><br>
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
</div>
</body>
</html>