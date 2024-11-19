<?php
session_start();

if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["contraseña"])) {
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        
        // Consulta para obtener los datos del usuario
        $stmt = $conexion->prepare("SELECT * FROM Usuario WHERE Usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($datos = $resultado->fetch_object()) {
            // Verificar si la contraseña es correcta usando password_verify
            if (password_verify($contraseña, $datos->Contraseña)) {
                // Si la contraseña es correcta, iniciar sesión
                $_SESSION["ID"] = $datos->ID_Usuario;
                $_SESSION["Usuario"] = $datos->Usuario;
                $_SESSION["Email"] = $datos->Email;
                $_SESSION["Nombre"] = $datos->Nombre;
                $_SESSION["Contraseña"] = $datos->Contraseña;
                $_SESSION["Fecha_Creacion_Cuenta"] = $datos->Fecha_Creacion_Cuenta;
                $_SESSION["Fecha_Ultimo_Acceso"] = $datos->Fecha_Ultimo_Acceso;
                $_SESSION["IsAdmin"] = $datos->IsAdmin;
                
                // Actualizar el último acceso del usuario
                $updateStmt = $conexion->prepare("UPDATE Usuario SET Fecha_Ultimo_Acceso = NOW() WHERE Usuario = ?");
                $updateStmt->bind_param("s", $usuario);
                $updateStmt->execute();
                
                // Redirigir al inicio
                header("location:../inicio.php");
            } else {
                // Contraseña incorrecta
                echo "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
            }
        } else {
            // Usuario no encontrado
            echo "<div class='alert alert-danger'>El usuario no existe.</div>";
        }
    } else {
        // Campos vacíos
        echo "<div class='alert alert-danger'>Los campos están vacíos.</div>";
    }
}
?>
