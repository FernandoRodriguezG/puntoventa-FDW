<?php
session_start();
session_destroy();
header("location:http://localhost/FDW21/proyecto/index.php");
?>