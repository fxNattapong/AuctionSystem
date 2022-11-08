<?php
include('../Assets/db_connect.php');

if(isset($_POST['member_username'])) {
    $sql_insert = "INSERT INTO members(member_fullname, member_contact, member_address, member_email, member_username, member_password, member_type) 
                    VALUES ('$_POST[member_fullname]','$_POST[member_contact]','$_POST[member_address]','$_POST[member_email]',
                            '$_POST[member_username]','$_POST[member_password]','$_POST[member_type]')";
    $result = mysqli_query($objConnect,$sql_insert);

    if(!$result) {
        echo "<script>";
        echo "alert(\" ERROR CAN'T CREATE. \");";
        echo "window.history.back()";
        echo "</script>";
    } else {
        Header("Location: Users.php");
    }
} else {
    echo "<script>";
    echo "alert(\" ERROR NO DATA. \");";
    echo "window.history.back()";
    echo "</script>";
}
?>