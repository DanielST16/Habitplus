<?php
session_start();

// Verificar si la sesión está iniciada
if (empty($_SESSION['Nombre']) && empty($_SESSION['Contraseña'])) {
    // Redirigir al login si no están definidas las variables de sesión
    header('location:login/login.php');
    exit(); 
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

    <h4 class="text-center text-secondary">LISTA DE CATEGORÍAS</h4>

    <?php
    // Incluir archivos de conexión y controlador
    include "../modelo/conexion.php";
    include "../controlador/controladorAgregarCategoria.php";
    include "../controlador/controladorEliminarCategoria.php";
    include "../controlador/controladorModificarCategoria.php";

    // Consulta para obtener categorías
    $stmt = $conexion->prepare("SELECT * FROM Categoria");
    $stmt->execute();
    $resultado = $stmt->get_result();
    ?>

    <!-- Botón para agregar nueva categoría -->
    <a href="Agregar_Categoria.php" class="btn btn-primary btn-rounded mb-2">
        <i class="fa-solid fa-plus"></i> &nbsp;Agregar
    </a>

    <!-- Tabla de categorías -->
    <table class="table table-bordered table-hover col-12" id="example">
        <thead class="table-light col-12">
            <tr>
                <th scope="col">ID_Categoria</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php while ($datos = $resultado->fetch_object()) { ?>
                <tr>
                    <td scope="row"><?= $datos->ID_Categoria ?></td>
                    <td scope="row"><?= $datos->Nombre ?></td>
                    <td scope="row"><?= $datos->Descripcion ?></td>
                    <td>
                        <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->ID_Categoria ?>"
                           class="btn btn-primary btn-sm">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <!-- Botón de eliminación con advertencia -->
                        <a href="AdministrarCategoria.php?id=<?= $datos->ID_Categoria ?>" onclick="advertenciaCat(event)"
                           class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>
                </tr>

                <!-- Despliegue de un Modal -->
                <div class="modal fade" id="exampleModal<?= $datos->ID_Categoria ?>" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Categoria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                        <input type="text" placeholder="ID categoria" class="input input__text"
                                               name="txtID_Categoria" value="<?= $datos->ID_Categoria ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px-2 col-12">
                                        <input type="text" placeholder="Nombre" class="input input__text"
                                               name="txtNombre" value="<?= $datos->Nombre ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px-2 col-12">
                                        <textarea placeholder="Descripcion" class="input input__text"
                                                  name="txtDescripcion" rows="3"><?= $datos->Descripcion ?></textarea>
                                    </div>
                                    <div class="text-right p-2">
                                        <a href="AdministrarCategoria.php" class="btn btn-secondary btn-rounded">Atras</a>
                                        <button type="submit" value="Ok" name="btnModificar"
                                                class="btn btn-primary btn-rounded">Modificar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </tbody>
    </table>

</div>
<!-- Fin del contenido principal -->

<!-- Cargar el footer -->
<?php require('./layout/footer.php'); ?>
