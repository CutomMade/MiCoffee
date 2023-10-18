<?php

$conn = mysqli_connect('35.202.101.209','root','','shop_db') or die('connection failed');

$mysqli = new mysqli('35.202.101.209', 'root', '', 'shop_db');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
return $mysqli;


?>