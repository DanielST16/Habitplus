<?php
session_start();

// Verificación de la sesión (si el usuario está logueado)
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('Location: login/login.php');
    exit();
} else if (!$_SESSION['IsAdmin']) {
    header('location:inicio.php');
}

// Incluir la conexión a la base de datos
include "../modelo/conexion.php";

// Obtener los datos del administrador logueado
$usuarioId = $_SESSION['ID'];
$stmt = $conexion->prepare("SELECT * FROM Administrador WHERE ID_Admin = ?");
$stmt->bind_param('i', $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "No se encontraron datos del administrador.";
    exit();
}
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    $(function notification() {
      new PNotify({
        title: "Correcto",
        type: "success",
        text: "Información actualizada exitosamente",
        styling: "bootstrap3"
      });
    });
  </script>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
  <script>
    $(function notification() {
      new PNotify({
        title: "Error",
        type: "error",
        text: "Hubo un error al actualizar la información",
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
    <h1 class="text-center font-weight-bold">Perfil de Administrador</h1>

    <!-- Tarjeta de perfil -->
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <!-- Foto de perfil -->
            <div class="text-center mb-4">
                <?php if (!empty($admin['Foto_Perfil'])): ?>
                    <img src="<?= htmlspecialchars($admin['Foto_Perfil']) ?>" alt="Foto de perfil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <img src="../public/app/publico/img/user.svg" alt="Foto de perfil predeterminada" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                <?php endif; ?>
            </div>

            <!-- Información del administrador -->
            <h3 class="card-title text-center">Nombre: <?= htmlspecialchars($admin['Nombre']) ?></h3>
            <p class="text-center">Correo: <?= htmlspecialchars($admin['Email']) ?></p>

            <!-- Botón para modificar perfil -->
            <div class="text-center mt-4">
                <a href="modificarPerfilAdmin.php" class="btn btn-primary">Modificar Perfil</a>
            </div>
        </div>
    </div>
</div>

<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
