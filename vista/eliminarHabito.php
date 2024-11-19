<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('Location: login/login.php');
    exit();
} else if ($_SESSION['IsAdmin']) { 
    // Comprobar si la sesión activa del usuario es de administrador (según la variable IsAdmin)
    header('location:inicioAdmin.php');
}
?>

<!-- Carga el topbar -->
<?php require('./layout/topbar.php'); ?>

<!-- Carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- Contenido principal -->
<div class="page-content">
    <h1 class="text-center font-weight-bold">Eliminar Hábitos</h1>

    <!-- Script para manejar la advertencia -->
    <script>
        function confirmacionEliminar(event) {
            // Confirmar si el administrador está seguro de realizar la acción
            var not = confirm("¿Estás seguro que deseas eliminar este hábito?");
            if (!not) {
                event.preventDefault(); // Evitar que se ejecute la acción si el administrador no confirma
            }
        }
    </script>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El hábito se eliminó correctamente",
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
                    text: "No se pudo eliminar el hábito",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php endif; ?>

    <?php
    include "../modelo/conexion.php";
    $userId = $_SESSION["ID"];

    // Obtener los hábitos asociados al usuario
    $stmt = $conexion->prepare("
        SELECT uh.ID_Usuario_Habito, h.Nombre AS nombre_habito, h.Descripcion AS descripcion_habito
        FROM Habito h
        JOIN Usuario_Habito uh ON h.ID_Habito = uh.ID_Habito
        WHERE uh.ID_Usuario = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0): ?>
        <div class="row">
            <?php while ($datos = $resultado->fetch_object()): ?>
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?= htmlspecialchars($datos->nombre_habito) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($datos->descripcion_habito) ?></p>
                            <a href="../controlador/controladorEliminarhabitoUser.php?ID_Usuario_Habito=<?= $datos->ID_Usuario_Habito ?>" onclick="return confirmacionEliminar(event)" class="btn btn-warning btn-sm">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center">No tienes hábitos registrados para eliminar.</p>
    <?php endif; ?>

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
