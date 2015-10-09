<?php

session_start();


echo "0002<br>";
// setcookie("user", "Alex Porter", time()+300);

if(isset($_COOKIE["user"])){
	echo $_COOKIE["user"]."<br>";
}else{
	echo "no cookie<br>";
}

if(isset($_SESSION['views'])){
  	$_SESSION['views']=$_SESSION['views']+1;
	echo "Pageviews=". $_SESSION['views'];
}else{
	$_SESSION['views']=1;
}

$data = $_SESSION;
foreach ($data as $key => $value) { fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s' ,time()+60*60*6). "]". "data:" . $key . ": " .$value."\n" ); }

?>