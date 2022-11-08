<?php 
include('../Assets/db_connect.php');

$sql_insert = "INSERT INTO categories(category_name)
                      VALUES('$_POST[category_name]')";
$result = mysqli_query($objConnect,$sql_insert);
if(!$result) {
    echo "<script>";
    echo "alert(\" CAN'T CREATE CATEGORIES \");"; 
    echo "window.history.back()";
    echo "</script>";
} else {
    Header("Location: Categories.php");
}   
?>