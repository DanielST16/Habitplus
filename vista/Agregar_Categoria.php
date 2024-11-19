<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('location:login/login.php');
    exit(); // Asegurarse de detener la ejecución del resto del código
} else if (!$_SESSION['IsAdmin']) { 
    // Comprobar si la sesión activa del usuario no tiene privilegios de administrador
    header('location:inicio.php');
}
?>

<script>
    function advertenciaCat(event) {
        // Confirmar si el usuario está seguro de eliminar
        var not = confirm("¿Estás seguro que deseas eliminar?");
        if (!not) {
            event.preventDefault(); // Evitar que se ejecute la acción si el usuario no confirma
        }
    }
</script>

<!-- Cargar el topbar -->
<?php require('./layout/topbarAdmin.php'); ?>

<!-- Cargar el sidebar -->
<?php require('./layout/sidebarAdmin.php'); ?>

<!-- Contenido principal -->
<div class="page-content">

    <h4 class="text-center text-secondary">AGREGAR CATEGORÍAS</h4>

    <?php
    include "../modelo/conexion.php";
    include "../controlador/controladorAgregarCategoria.php";
    ?>

    <div class="row">
        <form action="" method="POST">
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Nombre" class="input input__text" name="txtNombre" required>
            </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <textarea placeholder="Descripcion" class="input input__text" name="txtDescripcion" rows="3" required></textarea>
            </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="URL de la imagen" class="input input__text" name="txtImagen" required>
            </div>

            <div class="text-right p-2">
                <a href="AdministrarCategoria.php" class="btn btn-secondary btn-rounded">Atras</a>
                <button type="submit" value="Ok" name="btnAgregar" class="btn btn-primary btn-rounded">Agregar</button>
            </div>
        </form>
    </div>

</div>
<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
