<?php
session_start();
include "../modelo/conexion.php";

// Verificar si el usuario está autenticado
if (empty($_SESSION['ID'])) {
    header('location:login/login.php');
    exit;
}

// Verificar si se ha enviado el ID del hábito
if (isset($_POST['ID_Habito']) && isset($_SESSION['ID'])) {
    $ID_Habito = $_POST['ID_Habito'];
    $ID_Usuario = $_SESSION['ID'];

    // Insertar un nuevo habito
    $sql_insert = $conexion->prepare("INSERT INTO Usuario_Habito (ID_Usuario, ID_Habito) VALUES (?, ?)");
    $sql_insert->bind_param("ii", $ID_Usuario, $ID_Habito);

    // Ejecutar la consulta
    if ($sql_insert->execute()) {
        header("location:../vista/inicio.php?success=1");
    } else {
        echo "<div class='alert alert-danger'>Error al insertar el hábito.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No se ha enviado el ID del hábito o el usuario no está autenticado.</div>";
}
?>
