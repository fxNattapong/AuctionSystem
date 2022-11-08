<?php
include('../Assets/db_connect.php');

if(isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $query = "DELETE FROM members WHERE member_id = '$member_id'";
    $query_run = mysqli_query($objConnect, $query);
    
    if($query_run) {
        header("Location: Users.php");
    } else {
        echo "<script>";
        echo "alert(\" ERROR CAN'T DELETE \");"; 
        echo "window.history.back()";
        echo "</script>";
    }
} else {
    echo "<script>";
    echo "alert(\" ERROR CAN'T DELETE\");";
    echo "window.history.back()";
    echo "</script>";
}
?>