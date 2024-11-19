<?php
session_start();
session_destroy();
header("location:/ProyectoBase/vista/login/login.php");
?>
