<?php
include('../Assets/db_connect.php');

if (isset($_POST['register'])) {
    $username = $_POST['member_username'];
    $email = $_POST['member_email'];
    $password = $_POST['member_password'];

    $sql_username = "SELECT * FROM members WHERE member_username='$username'";
    $sql_email = "SELECT * FROM members WHERE member_email='$email'";
    $res_username = mysqli_query($objConnect, $sql_username);
    $res_email = mysqli_query($objConnect, $sql_email);

    if (mysqli_num_rows($res_username) > 0) {
        echo "<script>";
        echo "alert(\" SORRY... USERNAME ALREADY TAKEN \");"; 
        echo "window.history.back()";
        echo "</script>";
    }else if(mysqli_num_rows($res_email) > 0){
        echo "<script>";
        echo "alert(\" SORRY... EMAIL ALREADY TAKEN \");"; 
        echo "window.history.back()";
        echo "</script>";
    }else{
        $sql_insert = "INSERT INTO members(member_fullname, member_contact, member_address, member_email, member_username, member_password) 
                        VALUES ('$_POST[member_fullname]','$_POST[member_contact]','$_POST[member_address]',
                                '$_POST[member_email]','$_POST[member_username]','$_POST[member_password]')";
        $objQuery = mysqli_query($objConnect, $sql_insert);
        $objResult = mysqli_fetch_array($objQuery);
        $_SESSION["member_username"] = $objResult["member_username"];
        if($_SESSION["member_type"]=="1"){
            Header("Location: ../Admin/index.php");
        } else {
            Header("Location: ../index.php");
        }
    }
}
?>