<?php

session_start();

if (!empty($_POST["btningresarAdmin"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["contraseña"])) {
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        
        // Consulta para obtener los datos del administrador
        $stmt = $conexion->prepare("SELECT * FROM Administrador WHERE UsuarioAdmin = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($datos = $resultado->fetch_object()) {
            // Verificar si la contraseña es correcta usando password_verify
            if (password_verify($contraseña, $datos->Contraseña)) {
                // Si la contraseña es correcta, iniciar sesión
                $_SESSION["ID"] = $datos->ID_Admin;
                $_SESSION["Usuario"] = $datos->UsuarioAdmin;
                $_SESSION["Email"] = $datos->Email;
                $_SESSION["Nombre"] = $datos->Nombre;
                $_SESSION["Contraseña"] = $datos->Contraseña;
                $_SESSION["IsAdmin"] = $datos->IsAdmin;

                // Redirigir al panel de administración
                header("location:../../inicioAdmin.php");
            } else {
                // Contraseña incorrecta
                echo "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
            }
        } else {
            // Usuario no encontrado
            echo "<div class='alert alert-danger'>El Administrador no existe.</div>";
        }
    } else {
        // Campos vacíos
        echo "<div class='alert alert-danger'>Los campos están vacíos.</div>";
    }
}

?>
