<?php
session_start();

// Verificación de la sesión (si el usuario está logueado)
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('location:login/login.php');
    exit();
} else if ($_SESSION['IsAdmin']) {
    header('location:inicioAdmin.php');
    exit();
}

// Cargar el topbar y sidebar
require('./layout/topbar.php');
require('./layout/sidebar.php');

// Conexión a la base de datos
include "../modelo/conexion.php";

$nombre_categoria = $conexion->real_escape_string($_GET['nombre_categoria']);
$id_usuario = $_SESSION['ID'];

// Ejecutar la consulta para traer los hábitos de la categoría
$stmt = $conexion->prepare("
    SELECT h.ID_Habito, h.Nombre AS nombre_habito, h.Descripcion,
        (SELECT COUNT(*) 
            FROM Usuario_Habito uh 
            WHERE uh.ID_Habito = h.ID_Habito AND uh.ID_Usuario = ?) AS seleccionado
    FROM Habito h
    JOIN Categoria c ON h.ID_Categoria = c.ID_Categoria
    WHERE c.Nombre = ?
");
$stmt->bind_param("is", $id_usuario, $nombre_categoria);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Contenido principal -->
<div class="page-content">
  <h4 class="text-center text-secondary">LISTA DE HABITOS</h4>
  <?php
    // Verificar si la consulta trae resultados
    if ($result && $result->num_rows > 0) {
  ?>
    <table class="table table-bordered table-hover col-12" id="example">
        <thead class="table-light col-12">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
            while ($datos = $result->fetch_object()) {
        ?>
            <tr>
                <td scope="row"><?= htmlspecialchars($datos->nombre_habito) ?></td>
                <td scope="row"><?= htmlspecialchars($datos->Descripcion) ?></td>
                <td>
                    <?php if ($datos->seleccionado > 0): ?>
                        <!-- Mostrar mensaje si ya está seleccionado -->
                        <button class="btn btn-secondary" disabled>Ya seleccionado</button>
                    <?php else: ?>
                        <!-- Mostrar botón de selección si no está seleccionado -->
                        <form method="POST" action="../controlador/controladorSeleccionarNuevoHabito.php">
                            <input type="hidden" name="ID_Habito" value="<?= htmlspecialchars($datos->ID_Habito) ?>">
                            <button name="seleccionarNuevoHabito" type="submit" class="btn btn-primary">Seleccionar</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
  <?php
    } else {
        echo "<p class='text-center'>No se encontraron hábitos para esta categoría.</p>";
    }
  ?>
</div>
<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
