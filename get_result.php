<head>
  <title>Get Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php
session_start();
if(isset($_SESSION['userid']) || isset($_COOKIE['usn']))
{
require_once('function.php');
if(isset($_GET["usn"]))
{
	$usn=strtoupper(htmlspecialchars($_GET["usn"]));
	$type=htmlspecialchars($_GET["type"]);
	if($type != 1 && $type != 2)
		$type=1;
	$freeusn=1;
	if(isset($_COOKIE['usn']) && !isset($_SESSION['userid']))
	{
		$hash=$_COOKIE['hash'];
		require_once('function.php');
		$newwhash=gethash($_COOKIE['usn']);
		//echo $hash." ".$newwhash."<br>";
		if($hash == $newwhash)
		{
			$usns=explode(",",$_COOKIE['usn']);
			foreach($usns as $i)
			{
				if($i==$usn)
				{
					$freeusn=0;
					break;
				}
			}
		}
		else
		{
			echo "<br><br><br><h4 class=\"help-block text-center\">SOME ERROR HAPPENED PLEASE RETRY</h4>";
?>
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
<?php		
		exit(0);
		
		}
	}
	if($freeusn==0 || isset($_SESSION['userid']))
	{
		$location="results";
		if($type==2)
			$location="reval";
	 if(!file_exists("$location/$usn.xml"))
		curlit($usn,$type);
	 else
	  {
		  $file=fopen("$location/$usn.xml","r");
		  $buff=fread($file,filesize("$location/$usn.xml"));
		  echo $buff;
		  fclose($file);
		  require_once('function.php');
		  $page=htmlspecialchars($_SERVER["PHP_SELF"]);
		  $page=$page."?usn=$usn";
		  $hash=gethash("$usn|$page|$type");
		  $link="<div class=\"row text-center\"><h3><a href=\"recheck.php?usn=$usn&tl=$page&type=$type&hash=$hash\">Recheck Your Result</a></h3></div>";
		  echo $link;

	  }
	}
	else
		echo "<br><br><br><h4 class=\"help-block text-center\">You are  only  allowed to  search for ".$_COOKIE["usn"]."</h4>";
}
else
		echo "<br><br><br><h4 class=\"help-block text-center\">You are  only  allowed to  search for ".$_COOKIE["usn"]."</h4>";
ob_end_flush();
}
else
{
	echo "<br><br><br><h4 class=\"help-block text-center\">Please Login to Search the Multiple Results</h4>";
}
?>
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