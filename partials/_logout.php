<?php
session_start();
echo 'you are login out';

session_destroy();

header('location: ../index.php');


?>