<?php
session_start();

// Verificación de la sesión (si el usuario está logueado)
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('Location: login/login.php');
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

// Preparar la consulta para obtener categorías
$stmt = $conexion->prepare("SELECT Nombre, Descripcion, Imagen FROM Categoria");
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Contenido principal -->
<div class="page-content">
  <h1 class="text-center font-weight-bold">SELECCIONAR UNA CATEGORIA</h1>

  <?php
    // Verificar si la consulta trae resultados
    if ($result && $result->num_rows > 0) {
  ?>
    <!-- Recorrer los resultados -->
    <div class="row">
    <?php
      while ($datos = $result->fetch_object()) {
        echo '<div class="col-md-4 mb-4 d-flex">';
        echo '<div class="card h-100 d-flex flex-column">';
        echo '<div class="card-body d-flex flex-column justify-content-between">';
        echo '<img src="' . htmlentities($datos->Imagen) . '" class="card-img-top img-fluid" alt="..." style="width: 120%; height: 200px; object-fit: cover;">';
        echo '<h5 class="card-title">' . htmlspecialchars($datos->Nombre) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($datos->Descripcion) . '</p>';
        echo '<a href="seleccionarNuevoHabito.php?nombre_categoria=' . urlencode($datos->Nombre) . '" class="btn btn-primary align-self-end">ELEGIR</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    ?>
    </div>
  <?php
    } else {
        echo "<p class='text-center'>No se encontraron categorías.</p>";
    }
  ?>

  <div style="position: relative; width: 100%; height: 0; padding-top: 25%; padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden; border-radius: 8px;">
    <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0; margin: 0;"
            src="https://www.canva.com/design/DAGWTrXjwbM/97ts4duZlWZbeRQ1gD9dtg/view?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
    </iframe>
  </div>
</div>
<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
