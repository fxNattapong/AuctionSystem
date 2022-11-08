<?php
include('../Assets/db_connect.php');

$sql_update = "UPDATE members 
                SET member_fullname = '$_POST[member_fullname]',
                    member_contact = '$_POST[member_contact]',
                    member_address = '$_POST[member_address]',
                    member_email = '$_POST[member_email]',
                    member_username = '$_POST[member_username]',
                    member_password = '$_POST[member_password]'
                WHERE member_id = '$_POST[member_id]'";

$result= mysqli_query($objConnect, $sql_update);

if(!$result) {
    echo "<script>";
    echo "alert(\" Error \");"; 
    echo "window.history.back()";
    echo "</script>";
} else {
    echo "<script>";
    echo "window.history.back()";
    echo "</script>";
    // if($_POST["member_type"]=="1"){
    //     // Header("Location: ../Admin/Home.php");
    //     echo "<script>";
    //     echo "window.history.back()";
    //     echo "</script>";
    // } else {
    //     echo "<script>";
    //     echo "window.history.back()";
    //     echo "</script>";
    // }
}
?>