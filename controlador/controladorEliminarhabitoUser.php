<?php
session_start();
include "../modelo/conexion.php";

if (isset($_GET['ID_Usuario_Habito'])) {
    $ID_Usuario_Habito = $_GET['ID_Usuario_Habito'];

    // Consulta para eliminar el registro en la tabla Usuario_Habito
    $stmtDeleteUsuarioHabito = $conexion->prepare("DELETE FROM Usuario_Habito WHERE ID_Usuario_Habito = ?");
    $stmtDeleteUsuarioHabito->bind_param("i", $ID_Usuario_Habito);

    if ($stmtDeleteUsuarioHabito->execute()) {
        header('Location: ../vista/eliminarHabito.php?success=1');
    } else {
        header('Location: ../vista/eliminarHabito.php?error=1');
    }
} else {
    header('Location: ../vista/eliminarHabito.php?error=1');
}
?>
