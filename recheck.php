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
if(isset($_GET['hash']))
{
	$locations=array("results","reval");
$usn=htmlspecialchars($_GET['usn']);
$type=$_GET["type"];
$page=$_GET['tl'];
$posthash=htmlspecialchars($_GET['hash']);
require_once('function.php');
$hash=gethash("$usn|$page|$type");
	if($hash===$posthash)
	{
		$type--;
		if(file_exists("$locations[$type]/$usn.xml"))
		{
			ob_start();
			echo "Deleting Old Data....<br>";
			ob_flush();
		unlink("$locations[$type]/$usn.xml");
		require_once('function.php');
		sleep(1);
		echo "Rechecking Result....<br>";
		ob_flush();
		curlit($usn,($type+1));
		echo "Data Updated Please Click Back to see the new Result<br>";
		echo "<input class=\"btn btn-link\" action=\"action\" onclick=\"history.go(-1);\" type=\"button\" value=\"Back\" />";
		ob_end_flush();
		}
		
		header("Refresh:5 url=$page");
	}
	else
	{
		echo "Invalid USN/Hash";
	}
}
else
	header('Location: index.php');
?>