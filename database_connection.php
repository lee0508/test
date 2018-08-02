<?php
//database_connection.php
//카페24시 계정 ymhpro03 DB비밀번호 dlrlqjq050864
//$connect = new PDO("mysql:host=localhost;dbname=ymhpro03", "ymhpro03", "dlrlqjq0508");
//로컬접속시
$cafe24_host = "localhost";
$cafe24_username = "ymhpro03";      //"root";
$cafe24_password = "dlrlqjq0508";   //"root";
$cafe24_database = "ymhpro03";      //"hintchain";


$local_host = "localhost";
$local_username = "root";
$local_password = "root";
$local_database = "hintchain";

$message = '';
try
{
   $connect = new PDO("mysql:host=localhost;dbname=hintchain", "root", "root");

   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $message = 'Database Success';
  // echo $message;
}
catch(PDOException $error)   
{
   echo $error->getMessage();
}

//session_start();

?>