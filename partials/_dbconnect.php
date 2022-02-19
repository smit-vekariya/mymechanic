<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "mymechanic";

$conn = mysqli_connect($server,$username,$password,$database);
if($conn){
    // echo 'database connected successfully';
}
else{
    // echo 'database can not connect';
}
?>