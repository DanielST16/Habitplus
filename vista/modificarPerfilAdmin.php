<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('location:login/login.php');
    exit(); // Asegurarse de detener la ejecución del resto del código
} else if (!$_SESSION['IsAdmin']) {
    header('location:inicio.php');
}

$Nombre = $_SESSION['Nombre'];
?>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
<script>
    $(function notification() {
        new PNotify({
            title: "Error",
            type: "error",
            text: "Revisa los campos",
            styling: "bootstrap3"
        });
    });
</script>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 2): ?>
<script>
    $(function notification() {
        new PNotify({
            title: "Error",
            type: "error",
            text: "El usuario o el email ya están en uso",
            styling: "bootstrap3"
        });
    });
</script>
<?php endif; ?>

<!-- Cargar el topbar -->
<?php require('./layout/topbarAdmin.php'); ?>

<!-- Cargar el sidebar -->
<?php require('./layout/sidebarAdmin.php'); ?>

<!-- Contenido principal -->
<div class="page-content">

    <h4 class="text-center text-secondary">PERFIL ADMINISTRADOR</h4>
    <?php
        include "../modelo/conexion.php";
        // Trae todos los datos del administrador
        $stmt = $conexion->prepare("SELECT * FROM Administrador WHERE Nombre = ?");
        $stmt->bind_param("s", $Nombre);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>

    <div class="row">
        <form action="../controlador/controladorModificarPerfilAdmin.php" method="POST">
        <?php while ($datos = $result->fetch_object()) { ?>
            <!-- Campo ID: solo lectura -->
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="ID" class="form-control" id="id" name="txtID" 
                       value="<?= $datos->ID_Admin ?>" readonly>
            </div>

            <!-- Campo Usuario: alfanumérico sin espacios -->
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Usuario" class="input input__text" name="txtUsuario"
                       value="<?= $datos->UsuarioAdmin ?>" 
                       required 
                       pattern="[a-zA-Z0-9]{3,20}" 
                       title="El usuario debe contener entre 3 y 20 caracteres alfanuméricos sin espacios.">
            </div>

            <!-- Campo Nombre: letras y espacios permitidos -->
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Nombre" class="input input__text" name="txtNombre"
                       value="<?= $datos->Nombre ?>" 
                       required 
                       pattern="[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{3,30}" 
                       title="El nombre debe contener entre 3 y 30 caracteres, solo letras y espacios.">
            </div>

            <!-- Campo Email: formato válido de email -->
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="email" placeholder="Email" class="input input__text" name="txtEmail"
                       value="<?= $datos->Email ?>" 
                       required 
                       pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                       title="El email debe ser válido (ejemplo: usuario@dominio.com).">
            </div>

            <!-- Botón Modificar -->
            <button type="submit" value="Ok" name="btnModificar" class="btn btn-primary btn-rounded">Modificar</button>
        <?php } ?>
        </form>

    </div>
</div>
<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
