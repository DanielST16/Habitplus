<?php
session_start();

// Verificación de la sesión (si el usuario está logueado)
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('Location: login/login.php');
    exit();
} else if ($_SESSION['IsAdmin']) {
    header('location:inicioAdmin.php');
}

// Cargar el topbar y sidebar
require('./layout/topbar.php');
require('./layout/sidebar.php');

// Conexión a la base de datos
include "../modelo/conexion.php";
$userId = $_SESSION["ID"];

// Consulta para obtener el progreso de los hábitos
$stmt = $conexion->prepare("
  SELECT p.Progreso_Total, p.Progreso_Mensual, p.Mejor_Racha, p.Racha_Actual, h.Nombre AS nombre_habito
  FROM Progreso p
  JOIN Usuario_Habito uh ON p.ID_Usuario_Habito = uh.ID_Usuario_Habito
  JOIN Habito h ON uh.ID_Habito = h.ID_Habito
  WHERE uh.ID_Usuario = ?
");

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!-- Contenido principal -->
<div class="page-content">
  <h1 class="text-center font-weight-bold">Progreso</h1>

  <?php
    if ($result && $result->num_rows > 0) {
  ?>
    <!-- Recorrer los resultados -->
    <div class="row">
    <?php
    while ($datos = $result->fetch_object()) {
        echo '<div class="col-lg-3 mb-4 d-flex">';
        echo '<div class="card h-100 d-flex flex-column shadow-sm" style="width: 100%;">';
        echo '<div class="card-body d-flex flex-column justify-content-between">';
        echo '<h5 class="card-title">' . htmlspecialchars($datos->nombre_habito) . '</h5>';
        echo '<hr class="my-3" style="border: 3px solid #007bff;">';
        echo '<ul class="list-group list-group-flush">';
        echo '<li class="list-group-item"><i class="fas fa-calendar-check text-primary me-2"></i><strong>Progreso Total:</strong> ' . htmlspecialchars($datos->Progreso_Total) . ' días</li>';
        echo '<li class="list-group-item"><i class="fas fa-calendar-day text-success me-2"></i><strong>Progreso Mensual:</strong> ' . htmlspecialchars($datos->Progreso_Mensual) . ' días</li>';
        echo '<li class="list-group-item"><i class="fas fa-trophy text-warning me-2"></i><strong>Mejor Racha:</strong> ' . htmlspecialchars($datos->Mejor_Racha) . ' días</li>';
        echo '<li class="list-group-item"><i class="fas fa-fire text-danger me-2"></i><strong>Racha Actual:</strong> ' . htmlspecialchars($datos->Racha_Actual) . ' días</li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    </div>
  <?php
    } else { 
  ?>
    <p class="text-center">Aún no tienes ningún progreso de un hábito, por favor realiza alguno en el menú de inicio.</p>
  <?php
    }
  ?>

  <div style="position: relative; width: 100%; height: 0; padding-top: 25.0000%;
       padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
       border-radius: 8px; will-change: transform;">
    <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0; margin: 0;"
            src="https://www.canva.com/design/DAGWTrXjwbM/97ts4duZlWZbeRQ1gD9dtg/view?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
    </iframe>
  </div>
</div>

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
