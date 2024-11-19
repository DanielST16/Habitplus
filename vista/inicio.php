<?php
session_start();
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('Location: login/login.php');
    exit();
} else if ($_SESSION['IsAdmin']) {
    header('location:inicioAdmin.php');
}
?>

<!-- Carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- Carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- Contenido principal -->
<div class="page-content">
  <h1 class="text-center font-weight-bold">TUS HÁBITOS</h1>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    $(function notification() {
      new PNotify({
        title: "Correcto",
        type: "success",
        text: "El hábito se realizó correctamente",
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
        text: "El hábito ya fue realizado hoy",
        styling: "bootstrap3"
      });
    });
  </script>
  <?php endif; ?>

  <?php
  include "../modelo/conexion.php";
  $userId = $_SESSION["ID"];

  // Consulta para obtener los habitos a los que esta asociado el usuario
  $stmt = $conexion->prepare("
    SELECT h.ID_Habito, h.Nombre AS nombre_habito, h.Descripcion AS descripcion_habito, 
           p.Ultima_Fecha 
    FROM Habito h
    JOIN Usuario_Habito uh ON h.ID_Habito = uh.ID_Habito
    LEFT JOIN Progreso p ON uh.ID_Usuario_Habito = p.ID_Usuario_Habito
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
              <?php 
                // Verificar si el hábito tiene progreso
                if ($datos->Ultima_Fecha) {
                    $ultimaFecha = new DateTime($datos->Ultima_Fecha);
                    $hoy = new DateTime();
                    $diferencia = $hoy->diff($ultimaFecha)->days;
                    $botonDeshabilitado = ($diferencia === 0) ? "disabled" : "";
                } else {
                    // Si no tiene progreso registrado, el botón estará habilitado
                    $botonDeshabilitado = "";
                }
              ?>
              <form action="../controlador/controladorProgreso.php" method="POST">
                <input type="hidden" name="ID_Habito" value="<?= $datos->ID_Habito ?>">
                <button type="submit" class="btn btn-primary align-self-end" <?= $botonDeshabilitado ?>>
                  <?= ($botonDeshabilitado) ? "Ya realizado hoy" : "Realizar" ?>
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-center">Aun no tienes hábitos por cumplir, por favor selecciona alguno en el menú de hábitos.</p>
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

<!-- fin del contenido principal -->

<!-- Carga el footer -->
<?php require('./layout/footer.php'); ?>
