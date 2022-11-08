<?php
include('../Assets/Session.php');
if($_SESSION["member_type"]=="1") { 
    session_destroy();
    header("location: ../Admin/index.php");
} else {
    session_destroy();
    header("location: ../index.php");
}
?>