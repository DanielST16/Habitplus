<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    // Consulta preparada para eliminar una categoria
    $stmt = $conexion->prepare("DELETE FROM Categoria WHERE ID_Categoria = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "Categoría eliminada correctamente",
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
                    text: "No se pudo eliminar la categoría",
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
