<?php
// define('HOST', 'localhost');
// define('DATABASE', 'tsportns');
// define('USERNAME', 'root');
// define('PASSWORD', '');

$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = "nkstore";
$port=3306;
$conn = mysqli_connect($hostname, $username, $password,$dbname,$port);

if (!$conn) {
 die('Không thể kết nối: ' . mysqli_error($conn));
 exit();
}
// echo 'Kết nối thành công';
mysqli_set_charset($conn,"utf8");

//mysql_set_charset('utf8', $con);

?>