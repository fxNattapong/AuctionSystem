<?php
include('../Assets/db_connect.php');

if(isset($_POST['member_id'])) {
    $sql_update = "UPDATE members 
                    SET member_fullname = '$_POST[member_fullname]',
                        member_contact = '$_POST[member_contact]',
                        member_address = '$_POST[member_address]',
                        member_email = '$_POST[member_email]',
                        member_username = '$_POST[member_username]',
                        member_password = '$_POST[member_password]',
                        member_type = '$_POST[member_type]'
                    WHERE member_id = '$_POST[member_id]'";
    $result= mysqli_query($objConnect, $sql_update);

    if(!$result) {
        echo "<script>";
        echo "alert(\" ERROR CAN'T EDIT.  \");"; 
        echo "window.history.back()";
        echo "</script>";
    } else {
        header("Location: Users.php");
    }
} else {
    echo "<script>";
    echo "alert(\" ERROR NO DATA. 2\");";
    echo "window.history.back()";
    echo "</script>";
}
?>