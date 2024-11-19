<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('Location: login/login.php');
    exit();
} else if (!$_SESSION['IsAdmin']) { 
    // Comprobar si la sesión activa del usuario no tiene privilegios de administrador (según la variable IsAdmin)
    header('location:inicio.php');
}
?>

<!-- Primero se carga el topbar -->
<?php require('./layout/topbarAdmin.php'); ?>

<!-- Luego se carga el sidebar -->
<?php require('./layout/sidebarAdmin.php'); ?>

<!-- Inicio del contenido principal -->
<div class="page-content">
    <h1 class="text-center font-weight-bold">CAMBIAR CONTRASEÑA ADMIN</h1>
    <form id="formularioCambioContraseña" action="" method="POST">
        <!-- Campo para la contraseña actual -->
        <div class="form-group">
            <label for="contraseñaActual">Contraseña Actual:</label>
            <input type="password" class="form-control" id="contraseñaActual" name="contraseñaActual" required minlength="4">
        </div>

        <!-- Campo para la nueva contraseña -->
        <div class="form-group">
            <label for="nuevaContraseña">Nueva Contraseña:</label>
            <input type="password" class="form-control" id="nuevaContraseña" name="nuevaContraseña" required minlength="4">
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div class="form-group">
            <label for="confirmarContraseña">Confirmar Nueva Contraseña:</label>
            <input type="password" class="form-control" id="confirmarContraseña" name="confirmarContraseña" required minlength="4">
        </div>

        <!-- Botón para enviar el formulario -->
        <input name="btnCambiarContraseña" type="submit" class="btn btn-primary" value="Cambiar Contraseña"/>

        <?php
            include ("../modelo/conexion.php");
            include ("../controlador/controladorCambioContraseña.php");
        ?>
    </form>
</div>
<!-- Fin del contenido principal -->

<!-- Carga el footer -->
<?php require('./layout/footer.php'); ?>
