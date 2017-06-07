<?php
session_start();
$_SESSION["userid"]=0;
session_unset(); 
session_destroy();
echo "You are Logged Out Successfully";
header("Location: ./index.php")
 ?>