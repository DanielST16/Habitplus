<?php
session_start();
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    header('Location: login/login.php');
    exit();
} else if (!$_SESSION['IsAdmin']) {
    header('location:inicioAdmin.php');
}

// Incluir el topbar y sidebar
require('./layout/topbarAdmin.php');
require('./layout/sidebarAdmin.php');

// Incluir conexión a la base de datos
include "../modelo/conexion.php";

// Consulta de hábitos más elegidos
$stmt1 = $conexion->prepare("
    SELECT h.Nombre AS nombre_habito, COUNT(uh.ID_Habito) AS total_usuarios
    FROM Habito h
    JOIN Usuario_Habito uh ON h.ID_Habito = uh.ID_Habito
    GROUP BY uh.ID_Habito
    ORDER BY total_usuarios DESC
    LIMIT 5
");
$stmt1->execute();
$habitosMasElegidos = $stmt1->get_result();

// Consulta de usuarios con más hábitos
$stmt2 = $conexion->prepare("
    SELECT u.Nombre AS nombre_usuario, COUNT(uh.ID_Usuario_Habito) AS total_habitos
    FROM Usuario u
    JOIN Usuario_Habito uh ON u.ID_Usuario = uh.ID_Usuario
    GROUP BY uh.ID_Usuario
    ORDER BY total_habitos DESC
    LIMIT 5
");
$stmt2->execute();
$usuariosConMasHabitos = $stmt2->get_result();

// Consulta de usuarios con mayor racha
$stmt3 = $conexion->prepare("
    SELECT u.Nombre AS nombre_usuario, MAX(p.Mejor_Racha) AS mejor_racha
    FROM Usuario u
    JOIN Usuario_Habito uh ON u.ID_Usuario = uh.ID_Usuario
    JOIN Progreso p ON uh.ID_Usuario_Habito = p.ID_Usuario_Habito
    GROUP BY u.ID_Usuario
    ORDER BY mejor_racha DESC
    LIMIT 5
");
$stmt3->execute();
$usuariosConMayorRacha = $stmt3->get_result();

?>

<div class="page-content">
    <h1 class="text-center font-weight-bold">Estadísticas</h1>

    <!-- Contenedor para las gráficas -->
    <div class="row">
        <!-- Hábitos más elegidos -->
        <div class="col-md-12 mb-4">
            <div class="card" style="max-height: 450px;">
                <div class="card-header">
                    <h3 class="card-title text-center">Hábitos más elegidos</h3>
                </div>
                <div class="card-body" style="padding: 0; overflow: hidden;">
                    <canvas id="graficaHabitos" style="height: 250px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Usuarios con más hábitos -->
        <div class="col-md-12 mb-4">
            <div class="card" style="max-height: 450px;">
                <div class="card-header">
                    <h3 class="card-title text-center">Usuarios con más hábitos</h3>
                </div>
                <div class="card-body" style="padding: 0; overflow: hidden;">
                    <canvas id="graficaUsuariosHabitos" style="height: 250px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Usuarios con mayor racha -->
        <div class="col-md-12 mb-4">
            <div class="card" style="max-height: 450px;">
                <div class="card-header">
                    <h3 class="card-title text-center">Usuarios con mayor racha</h3>
                </div>
                <div class="card-body" style="padding: 0; overflow: hidden;">
                    <canvas id="graficaMayorRacha" style="height: 250px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir librería de Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos para la gráfica de hábitos más elegidos
    const datosHabitos = {
        labels: [
            <?php while ($fila = $habitosMasElegidos->fetch_assoc()): ?>
                "<?= $fila['nombre_habito'] ?>",
            <?php endwhile; ?>
        ],
        datasets: [{
            label: 'Usuarios que eligieron el hábito',
            data: [
                <?php 
                $habitosMasElegidos->data_seek(0); // Resetear puntero
                while ($fila = $habitosMasElegidos->fetch_assoc()): ?>
                    <?= $fila['total_usuarios'] ?>,
                <?php endwhile; ?>
            ],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    // Datos para la gráfica de usuarios con más hábitos
    const datosUsuariosHabitos = {
        labels: [
            <?php while ($fila = $usuariosConMasHabitos->fetch_assoc()): ?>
                "<?= $fila['nombre_usuario'] ?>",
            <?php endwhile; ?>
        ],
        datasets: [{
            label: 'Cantidad de hábitos',
            data: [
                <?php 
                $usuariosConMasHabitos->data_seek(0);
                while ($fila = $usuariosConMasHabitos->fetch_assoc()): ?>
                    <?= $fila['total_habitos'] ?>,
                <?php endwhile; ?>
            ],
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    };

    // Datos para la gráfica de usuarios con mayor racha
    const datosMayorRacha = {
        labels: [
            <?php while ($fila = $usuariosConMayorRacha->fetch_assoc()): ?>
                "<?= $fila['nombre_usuario'] ?>",
            <?php endwhile; ?>
        ],
        datasets: [{
            label: 'Mayor racha',
            data: [
                <?php 
                $usuariosConMayorRacha->data_seek(0);
                while ($fila = $usuariosConMayorRacha->fetch_assoc()): ?>
                    <?= $fila['mejor_racha'] ?>,
                <?php endwhile; ?>
            ],
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        }]
    };

    // Opciones de configuración para las gráficas
    const configHabitos = { type: 'bar', data: datosHabitos, options: { responsive: true } };
    const configUsuariosHabitos = { type: 'bar', data: datosUsuariosHabitos, options: { responsive: true } };
    const configMayorRacha = { type: 'bar', data: datosMayorRacha, options: { responsive: true } };

    // Renderizar las gráficas
    new Chart(document.getElementById('graficaHabitos'), configHabitos);
    new Chart(document.getElementById('graficaUsuariosHabitos'), configUsuariosHabitos);
    new Chart(document.getElementById('graficaMayorRacha'), configMayorRacha);
</script>

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
