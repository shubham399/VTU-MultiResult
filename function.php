<?php
function curlit($usn,$type)
{
	$type--;
	$urls=array("http://results.vtu.ac.in/results/result_page.php?usn=","http://results.vtu.ac.in/reval_results/result_page.php?usn=");
	$locations=array("results","reval");
	ob_start();
	echo "<p class=\"text-center\">Checking Result.</p>";
	ob_flush();
	flush();
  $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,$urls[$type].$usn);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  $i=1;
  while (empty($buffer) && $i<=5){
	echo "<p class=\"text-center\">Retrying....<b> $i </b></p>";
  echo str_pad('',4096)."\n";
	ob_flush();
  flush();
  $i++;
        $buffer = curl_exec($curl_handle);
        	 usleep(10);
  }
  curl_close($curl_handle);
  if($i<=5)
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
		$file=fopen("$locations[$type]/$usn.xml","w");
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
  ob_end_flush();
}

function get_connection()
{
	$conn = new mysqli('localhost','id1415568_username123','Password123','id1415568_result');
	if ($conn->connect_error) {
    die("Connection failed: ");
	} 
	return $conn;
}
function gethash($data)
{
  $hash=hash("sha256",$data);
  //Generate a Hash for the Input
  return $hash;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
