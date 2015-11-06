<?php

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "regist.php start" . "\n" );

$userNameReg = "/^[a-z]\w{2,14}$/";
$pwdReg = "/^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/";

$userName = $_POST["username"];
$password = $_POST["password"];
$passwordConfirm = $_POST["passwordConfirm"];

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . "userName = " . $userName . "\n" );
fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . "password = " . $password . "\n" );
fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . "passwordConfirm = " . $passwordConfirm . "\n" );

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "check" . "\n" );
$un_check = preg_match($userNameReg, $userName);
fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . "un_check = " . $un_check . "\n" );

if(!$un_check){
	fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "用户名不合法" . "\n" );
	return;
}

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "查表确认用户名是否存在" . "\n" );
$un_registed = false;
if($un_registed){
	fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "用户名已存在" . "\n" );
	return;
}

$pwd_check = preg_match($pwdReg, $password);
if(!$pwd_check){
	fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "密码名不合法" . "\n" );
	return;
}

if($password!=$passwordConfirm){
	fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "密码不一致" . "\n" );
	return;
}

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "用户信息入库" . "\n" );
$store_res=true;
if(!$store_res){
fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "数据库写入失败" . "\n" );
return;
}

fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" .date('Y-m-d H:i:s',time()+60*60*6). "]". "返回正确" . "\n" );
return "OK";
// $url = "../login.html"; 
// if (isset($url)) 
// { 
// Header("Location: $url");
// } 
?>