<?php
session_start();
include "../modelo/conexion.php";

$ID = $_POST["txtID"];

// Validar el nombre: mínimo 3 caracteres y solo letras
if (!empty($_POST["txtNombre"]) && preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{3,}$/", $_POST["txtNombre"])) {
    $Nombre = $_POST["txtNombre"];
} else {
    header('Location: ../vista/modificarPerfilAdmin.php?error=1');
    exit();
}

// Validar el usuario: al menos una letra, un número, sin espacios, y mínimo 3 caracteres
if (!empty($_POST["txtUsuario"]) && preg_match("/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{3,}$/", $_POST["txtUsuario"]) && !preg_match("/\s/", $_POST["txtUsuario"])) {
    $Usuario = $_POST["txtUsuario"];
} else {
    header('Location: ../vista/modificarPerfilAdmin.php?error=1');
    exit();
}

// Validar el email: debe ser un formato válido
if (!empty($_POST["txtEmail"]) && filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)) {
    $Email = $_POST["txtEmail"];
} else {
    header('Location: ../vista/modificarPerfilAdmin.php?error=1');
    exit();
}

// Verificar si el usuario o email ya existen en la tabla Usuario, excluyendo el actual
$stmtCheck = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE (Usuario = ? OR Email = ?) AND ID_Usuario != ?");
$stmtCheck->bind_param("ssi", $Usuario, $Email, $ID);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

// Verificar si el usuario o email ya existen en la tabla Administrador, excluyendo el actual
$stmtCheckAdmin = $conexion->prepare("SELECT ID_Admin FROM Administrador WHERE (UsuarioAdmin = ? OR Email = ?) AND ID_Admin != ?");
$stmtCheckAdmin->bind_param("ssi", $Usuario, $Email, $ID);
$stmtCheckAdmin->execute();
$resultCheckAdmin = $stmtCheckAdmin->get_result();

if ($resultCheckAdmin->num_rows > 0 || $resultCheck->num_rows > 0) {
    header('Location: ../vista/modificarPerfilAdmin.php?error=2');
    exit();
}

// Actualizar datos
$stmtUpdate = $conexion->prepare("UPDATE Administrador SET UsuarioAdmin = ?, Nombre = ?, Email = ? WHERE ID_Admin = ?");
$stmtUpdate->bind_param("sssi", $Usuario, $Nombre, $Email, $ID);

if ($stmtUpdate->execute()) {
    $_SESSION["Usuario"] = $Usuario;
    $_SESSION["Email"] = $Email;
    $_SESSION["Nombre"] = $Nombre;
    header("location:../vista/PerfilAdmin.php?success=1");
    exit();
} else { 
    header("location:../vista/PerfilAdmin.php?error=1");
    exit();
}
?>
