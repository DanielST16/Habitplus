<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    // Consulta para eliminar las relaciones de Usuario_Habito
    $stmtEliminarRelaciones = $conexion->prepare("DELETE FROM Usuario_Habito WHERE ID_Habito = ?");
    $stmtEliminarRelaciones->bind_param("i", $id);

    if ($stmtEliminarRelaciones->execute()) {
        // Consulta para eliminar el hábito de la tabla Habito
        $stmtEliminarHabito = $conexion->prepare("DELETE FROM Habito WHERE ID_Habito = ?");
        $stmtEliminarHabito->bind_param("i", $id);

        if ($stmtEliminarHabito->execute()) { ?>
            <script>
                $(function notification() {
                    new PNotify({
                        title: "Correcto",
                        type: "success",
                        text: "Hábito eliminado correctamente",
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
                        text: "No se pudo eliminar el hábito",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php }
    } else {
        // Si no se pudo eliminar las relaciones, mostrar mensaje de error
        ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Incorrecto",
                    type: "error",
                    text: "No se pudieron eliminar las relaciones con el hábito",
                    styling: "bootstrap3"
                });
            });
        </script>
        <?php
    }

    ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>

<?php }
?>
