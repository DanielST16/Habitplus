<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('Location: login/login.php');
    exit();
} else if ($_SESSION['IsAdmin']) { 
    // Comprobar si la sesión activa del usuario es de usuario (según la variable IsAdmin)
    header('location:inicioAdmin.php');
}
?>

<!-- Carga el topbar -->
<?php require('./layout/topbar.php'); ?>

<!-- Carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- Contenido principal -->
<div class="page-content">
    <h1 class="text-center font-weight-bold">CAMBIAR CONTRASEÑA</h1>
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

    <!-- Contenido adicional -->
    <div style="position: relative; width: 100%; height: 0; padding-top: 25.0000%; 
       padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
       border-radius: 8px; will-change: transform;">
        <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0; margin: 0;"
            src="https://www.canva.com/design/DAGWTrXjwbM/97ts4duZlWZbeRQ1gD9dtg/view?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
        </iframe>
    </div>
</div>
<!-- Fin del contenido principal -->

<!-- Carga el footer -->
<?php require('./layout/footer.php'); ?>
