<?php
include('../Assets/db_connect.php');

$category_id = $_GET["category_id"];
$sql = "DELETE FROM categories WHERE category_id = '".$category_id."' ";
$result = mysqli_query($objConnect, $sql);
if(!$result){
    echo "<script>";
    echo "alert(\" CAN'T DELETE CATEGORIES \");"; 
    echo "window.history.back()";
    echo "</script>";
} else {
    Header("Location: Categories.php");
}
?>
