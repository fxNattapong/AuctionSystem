<?php
include('../Assets/db_connect.php');

$sql_update = "UPDATE categories SET category_name = '$_POST[category_name]' WHERE category_id='$_POST[category_id]' ";
$result= $objConnect->query($sql_update);

if(!$result) {
    echo "<script>";
    echo "alert(\" CAN'T EDIT CATEGORIES \");"; 
    echo "window.history.back()";
    echo "</script>";
} else {
    Header("Location: Categories.php");
}
?>