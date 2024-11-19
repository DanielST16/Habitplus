<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    // Consulta para eliminar el registro en la tabla Usuario
    $stmtDeleteUsuario = $conexion->prepare("DELETE FROM Usuario WHERE ID_Usuario = ?");
    $stmtDeleteUsuario->bind_param("i", $id);

    if ($stmtDeleteUsuario->execute()) { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "Usuario eliminado correctamente",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php } else { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Incorrecto",
                    type: "error",
                    text: "No se pudo eliminar el Usuario",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php } ?>

    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>

<?php }
?>
