<?php
session_start();

if (!empty($_POST["btnRegistrar"])) {
    // Validar el nombre: mínimo 3 caracteres y solo letras
    if (!empty($_POST["nombre"]) && preg_match("/^[a-zA-Z ]{3,}$/", $_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    } else {
        echo "<div class='alert alert-danger'>El nombre debe tener al menos 3 caracteres y solo letras.</div>";
        exit();
    }

    // Validar el email: debe ser un formato válido
    if (!empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["email"];
    } else {
        echo "<div class='alert alert-danger'>El correo electrónico no es válido.</div>";
        exit();
    }

    // Validar el usuario: debe contener al menos una letra, un número, no igual al nombre, sin espacios, y mínimo 3 caracteres
    if (!empty($_POST["usuario"]) && $_POST["usuario"] !== $nombre && preg_match("/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{3,}$/", $_POST["usuario"]) && !preg_match("/\s/", $_POST["usuario"])) {
        $usuario = $_POST["usuario"];
    } else {
        echo "<div class='alert alert-danger'>El usuario debe contener al menos una letra y un número, no puede tener espacios y debe tener al menos 3 caracteres.</div>";
        exit();
    }

    // Validar la contraseña: mínimo 4 caracteres
    if (!empty($_POST["contraseña"]) && strlen($_POST["contraseña"]) >= 4) {
        $contraseña = $_POST["contraseña"];
    } else {
        echo "<div class='alert alert-danger'>La contraseña debe tener al menos 4 caracteres.</div>";
        exit();
    }

    // Verificar si el email ya está registrado en la tabla Administrador
    $checkEmailSql = $conexion->prepare("SELECT * FROM Administrador WHERE Email = ?");
    $checkEmailSql->bind_param("s", $email);
    $checkEmailSql->execute();
    $checkEmailSqlResult = $checkEmailSql->get_result();

    // Verificar si el usuario ya está registrado en la tabla Administrador
    $checkUserAdminSql = $conexion->prepare("SELECT * FROM Administrador WHERE UsuarioAdmin = ?");
    $checkUserAdminSql->bind_param("s", $usuario);
    $checkUserAdminSql->execute();
    $checkUserAdminSqlResult = $checkUserAdminSql->get_result();

    if ($checkEmailSqlResult->num_rows > 0) {
        // Si el email ya existe en la tabla Administrador
        echo "<div class='alert alert-danger'>El E-mail ya está registrado.</div>";
    } else if ($checkUserAdminSqlResult->num_rows > 0) {
        // Si el usuario ya existe en la tabla Administrador
        echo "<div class='alert alert-danger'>El Usuario ya está en uso.</div>";
    } else {
        // Verificar si el usuario o email ya existen en la tabla Usuario
        $sql = $conexion->prepare("SELECT Usuario, Email FROM Usuario WHERE Usuario = ? OR Email = ?");
        $sql->bind_param("ss", $usuario, $email);
        $sql->execute();
        $sqlResult = $sql->get_result();

        if ($sqlResult->num_rows > 0) {
            echo "<div class='alert alert-danger'>El usuario o el E-mail ya están registrados.</div>";
        } else {
            // Encriptar la contraseña usando password_hash
            $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $sql_insert = $conexion->prepare("INSERT INTO Usuario (Usuario, Nombre, Email, Contraseña) VALUES (?, ?, ?, ?)");
            $sql_insert->bind_param("ssss", $usuario, $nombre, $email, $contraseña_encriptada);

            if ($sql_insert->execute()) {
                echo "<div class='alert alert-success'>Registro completado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al registrar el usuario.</div>";
            }
        }
    }
}
?>
