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
?>
<!-- Cargar el topbar -->
<?php require('./layout/topbarAdmin.php'); ?>

<!-- Cargar el sidebar -->
<?php require('./layout/sidebarAdmin.php'); ?>

<div class="page-content">
    <?php
    include "../modelo/conexion.php";

    // Consulta para obtener los progresos de todos los usuarios en cada uno de sus hábitos
    $stmt = $conexion->prepare("
        SELECT 
            u.Nombre AS Usuario, 
            h.Nombre AS Habito, 
            p.Progreso_Total, 
            p.Progreso_Mensual, 
            p.Mejor_Racha, 
            p.Racha_Actual
        FROM Progreso p
        JOIN Usuario_Habito uh ON p.ID_Usuario_Habito = uh.ID_Usuario_Habito
        JOIN Usuario u ON uh.ID_Usuario = u.ID_Usuario
        JOIN Habito h ON uh.ID_Habito = h.ID_Habito
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <table class="table table-bordered table-hover col-12" id="example">
        <thead class="table-light col-12">
            <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Hábito</th>
                <th scope="col">Progreso Total</th>
                <th scope="col">Progreso Mensual</th>
                <th scope="col">Mejor Racha</th>
                <th scope="col">Racha Actual</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            // Mostrar los datos de los usuarios en la tabla
            while ($datos = $result->fetch_object()) { ?>
                <tr>
                    <td><?= htmlspecialchars($datos->Usuario) ?></td>
                    <td><?= htmlspecialchars($datos->Habito) ?></td>
                    <td><?= htmlspecialchars($datos->Progreso_Total) ?></td>
                    <td><?= htmlspecialchars($datos->Progreso_Mensual) ?></td>
                    <td><?= htmlspecialchars($datos->Mejor_Racha) ?></td>
                    <td><?= htmlspecialchars($datos->Racha_Actual) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>    

</div>

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
