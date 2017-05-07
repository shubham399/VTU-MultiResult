<head>
  <title>Multiple Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<?php
function curlit($usn)
{
  $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,'http://results.vtu.ac.in/results/result_page.php?usn='.$usn);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  $i=1;
  while (empty($buffer) && $i <11){
	echo "<p class=\"text-center\">Retrying....<b> $i </b></p>";
  echo str_pad('',4096)."\n";
	ob_flush();
  flush();
  $i++;
        $buffer = curl_exec($curl_handle);
        	 usleep(10);
  }
  curl_close($curl_handle);
  if($i<11)
  {
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
		$buffer=$buffer."</table></div></div></div>";
		$file=fopen("results/$usn.xml","w");
		fwrite($file,$buffer);
		fclose($file);
    print $buffer."<br>";
		}
  }
  else {
    echo "<div class=\"col-md-12\"><div class=\"panel panel-danger\">
                  <div class=\"panel-heading text-center\">
No Response from Server</br></div></div></div>";
  }
}
if(isset($_GET["usn"]))
{
	$usn=htmlspecialchars($_GET["usn"]);
	 if(!file_exists("results/$usn.xml"))
	 {
		 ob_start();
echo "<p class=\"text-center\">Checking Result.</p>";
echo str_pad('',4096)."\n";
ob_flush();
flush();
		curlit($usn);
	 }
	 else
	  {
		  $file=fopen("results/$usn.xml","r");
		  $buff=fread($file,filesize("results/$usn.xml"));
		  echo $buff;
		  fclose($file);

	  }
}
ob_end_flush();
?>
