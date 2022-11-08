<?php
    session_start();
    include('../Assets/db_connect.php');

    $username = mysqli_real_escape_string($objConnect, $_POST['member_username']);
    $password = mysqli_real_escape_string($objConnect, $_POST['member_password']);

    $strSQL = "SELECT * FROM members WHERE member_username = '$username' and member_password = '$password'";
    $objQuery = mysqli_query($objConnect, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);

    if(!$objResult) {
        echo "<script>";
        echo "alert(\" INVALID USERNAME OR PASSWORD \");"; 
        echo "window.history.back()";
        echo "</script>";
    } else {
        $_SESSION["member_type"] = $objResult["member_type"];
        if($_SESSION["member_type"]=="1"){
            $_SESSION["member_username"] = $objResult["member_username"];
            Header("Location: ../Admin/Home.php");
        }
        if ($_SESSION["member_type"]=="2"){  
            $_SESSION["member_username"] = $objResult["member_username"];
            Header("Location: ../index.php");
        }
    }
?>