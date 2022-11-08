<?php
$objConnect = mysqli_connect("localhost","root","")or die("Can't connect to database");
$db = mysqli_select_db($objConnect, "dbAuction");
mysqli_query($objConnect, "SET NAMES utf8");

if($objConnect->connect_error) {
    die("Connection failed". $conn->connect_error);
}
?>