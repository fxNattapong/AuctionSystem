<?php
include('../Assets/db_connect.php');

$sql_update = "UPDATE payments 
                SET payment_parcel_code = '$_POST[payment_parcel_code]',
                    payment_status = '2'
                WHERE payment_id = '$_POST[payment_id]' ";
$result = mysqli_query($objConnect,$sql_update);
if(!$result) {
    echo "<script>";
        echo "alert(\" ERROR CAN'T UPDATE \");"; 
        echo "window.history.back()";
        echo "</script>";
} else {
    Header("Location: Products.php");
}
?>