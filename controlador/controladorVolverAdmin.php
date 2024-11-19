<?php
// Archivo de conexión
include "../modelo/conexion.php";

// Obtener el ID del usuario a transferir
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = $conexion->prepare("SELECT * FROM Usuario WHERE ID_Usuario = ?");
    $sql->bind_param("i", $id_usuario);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_object();

        // Consulta para insertar el usuario en la tabla Administrador
        $insertSql = $conexion->prepare("INSERT INTO Administrador (UsuarioAdmin, Nombre, Email, Contraseña) VALUES (?, ?, ?, ?)");
        $insertSql->bind_param("ssss", $usuario->Usuario, $usuario->Nombre, $usuario->Email, $usuario->Contraseña);

        // Ejecutar la inserción en la tabla Administrador
        if ($insertSql->execute()) {
            // Consulta para eliminar al usuario de la tabla Usuario
            $deleteSql = $conexion->prepare("DELETE FROM Usuario WHERE ID_Usuario = ?");
            $deleteSql->bind_param("i", $id_usuario);

            // Ejecutar la eliminación del usuario de la tabla Usuario
            if ($deleteSql->execute()) {
                header('Location: ../vista/inicioAdmin.php?success=1');
            } else {
                echo "<script>alert('Error al eliminar al usuario de la tabla Usuario');</script>";
            }
        } else {
            echo "<script>alert('Error al transferir el usuario a la tabla Administrador');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado');</script>";
    }
} else {
    echo "<script>alert('ID de usuario no especificado');</script>";
}

exit();
?>
