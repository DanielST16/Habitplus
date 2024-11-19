<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('location:login/login.php');
    exit(); // Asegurarse de detener la ejecución del resto del código
} else if (!$_SESSION['IsAdmin']){
    header('location:inicio.php');
}
?>

<script>
    function advertencia(event) {
        // Confirmar si el usuario está seguro de eliminar
        var not = confirm("¿Estás seguro que deseas eliminar?");
        if (!not) {
            event.preventDefault(); // Evitar que se ejecute la acción si el usuario no confirma
        }
    }

    function confirmacionVolverAdmin(event) {
        // Confirmar si el administrador está seguro de realizar la acción
        var not = confirm("¿Estás seguro que deseas volver a este usuario administrador?");
        if (!not) {
            event.preventDefault(); // Evitar que se ejecute la acción si el administrador no confirma
        }
    }
</script>

<!-- Cargar el topbar -->
<?php require('./layout/topbarAdmin.php'); ?>

<!-- Cargar el sidebar -->
<?php require('./layout/sidebarAdmin.php'); ?>

<!-- Contenido principal -->
<div class="page-content">
    <h4 class="text-center text-secondary">LISTA DE USUARIOS</h4>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "Al usuario se le asignó rol de administrador correctamente",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php endif; ?>
    
    <?php
    // Archivos de conexión y controlador
    include "../modelo/conexion.php";
    include "../controlador/controladorEliminarUsuario.php";

    // Consulta para obtener usuarios
    $stmt = $conexion->prepare("SELECT * FROM Usuario");
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-hover col-12" id="example">
        <thead class="table-light col-12">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Usuario</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de creación</th>
                <th scope="col">Último Acceso</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
        // Mostrar los datos de los usuarios en la tabla
        while ($datos = $result->fetch_object()) { ?>
            <tr>
                <td scope="row"><?= $datos->ID_Usuario ?></td>
                <td scope="row"><?= $datos->Usuario ?></td>
                <td scope="row"><?= $datos->Nombre ?></td>
                <td scope="row"><?= $datos->Email ?></td>
                <td scope="row"><?= $datos->Fecha_Creacion_Cuenta ?></td>
                <td scope="row"><?= $datos->Fecha_Ultimo_Acceso ?></td>
                <td>
                    <!-- Botón de eliminación con advertencia -->
                    <a href="inicioAdmin.php?id=<?= $datos->ID_Usuario ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm">
                        <i class="fa-regular fa-trash-can"></i>
                    </a>

                    <!-- Botón "Volver Administrador" con confirmación -->
                    <a href="../controlador/controladorVolverAdmin.php?id=<?= $datos->ID_Usuario ?>" onclick="return confirmacionVolverAdmin(event)" class="btn btn-warning btn-sm">
                        Volver Administrador
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
