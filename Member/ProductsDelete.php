<?php
include('../Assets/db_connect.php');

if(isset($_POST['product_id'])) {
    $id = $_POST['product_id'];

    $query = "DELETE FROM products WHERE product_id = '$id'";
    $query_run = mysqli_query($objConnect, $query);

    if($query_run) {
        header("Location: Products.php");
    } else {
        echo "<script>";
        echo "alert(\" ERROR CAN'T DELETE \");"; 
        echo "window.history.back()";
        echo "</script>";
    }
} else {
    echo "<script>";
    echo "alert(\" ERROR CAN'T DELETE 2\");";
    echo "window.history.back()";
    echo "</script>";
}
?>