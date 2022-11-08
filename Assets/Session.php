<?php
    session_start();
    $objConnect = mysqli_connect("localhost","root","")or die("Can't connect to database");
    $db = mysqli_select_db($objConnect, "dbAuction");
    mysqli_query($objConnect, "SET NAMES utf8");

    if($objConnect->connect_error) {
        die("Connection failed". $conn->connect_error);
    }
   
    $user_check = $_SESSION['member_username'];
    
    $strSQL = "SELECT member_username FROM members WHERE member_username = '$user_check'";
    $ses_sql = mysqli_query($objConnect, $strSQL);
    
    $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
    
    $login_session = $row['member_username'];
    
    if(!isset($_SESSION['member_username'])){
        header("location:../index.php");
        die();
    }
?>