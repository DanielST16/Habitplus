<?php
if (!empty($_POST["btnCambiarContraseña"])) {
    $contraseñaActual = $_POST["contraseñaActual"];
    $nuevaContraseña = $_POST["nuevaContraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];

    if (password_verify($contraseñaActual, $_SESSION["Contraseña"])) {
        if ($nuevaContraseña === $confirmarContraseña) {
            // Encriptar la nueva contraseña
            $nuevaContraseña_encriptada = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

            // Consulta para actualizar la contraseña
            if ($_SESSION["IsAdmin"]) {
                // Para administrador
                $stmt = $conexion->prepare("UPDATE Administrador SET Contraseña = ? WHERE ID_Admin = ?");
                $stmt->bind_param("si", $nuevaContraseña_encriptada, $_SESSION['ID']);
            } else {
                // Para usuario
                $stmt = $conexion->prepare("UPDATE Usuario SET Contraseña = ? WHERE ID_Usuario = ?");
                $stmt->bind_param("si", $nuevaContraseña_encriptada, $_SESSION['ID']);
            }

            if ($stmt->execute()) {
                // Actualizar la contraseña en la sesión
                $_SESSION['Contraseña'] = $nuevaContraseña_encriptada;
                echo "<div class='alert alert-success'>Contraseña cambiada exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Hubo un error al cambiar la contraseña.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Confirma bien la nueva contraseña.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Contraseña actual incorrecta.</div>";
    }
}
?>
