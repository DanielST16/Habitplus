<?php
if (!empty($_POST["btnModificar"])) {
    if (!empty($_POST["txtNombre"]) && !empty($_POST["txtDescripcion"])) {
        $nombre = $_POST["txtNombre"];
        $descripcion = $_POST["txtDescripcion"];
        $ID_Habito = $_POST["txtID_Habito"];

        // Consulta para verificar si el hábito ya existe
        $stmt = $conexion->prepare("SELECT COUNT(*) as 'total' FROM Habito WHERE Nombre = ? AND ID_Habito != ?");
        $stmt->bind_param("si", $nombre, $ID_Habito);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->fetch_object()->total > 0) { ?>
            <script>
                $(function notification() {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "El hábito ya existe",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php } else {
            // Consulta para actualizar el hábito
            $stmtUpdate = $conexion->prepare("UPDATE Habito SET Nombre = ?, Descripcion = ? WHERE ID_Habito = ?");
            $stmtUpdate->bind_param("ssi", $nombre, $descripcion, $ID_Habito);
            $stmtUpdate->execute();

            if ($stmtUpdate->affected_rows > 0) { ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "Correcto",
                            type: "success",
                            text: "El hábito se modificó correctamente",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else { ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "Error",
                            type: "error",
                            text: "No se realizaron cambios o los campos están vacíos",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php }

            // Redirigir para evitar el reenvío del formulario
            echo "<script>setTimeout(() => { window.history.replaceState(null, null, window.location.pathname); }, 0);</script>";
        }
    } else { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "Los campos están vacíos",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php }

    // Redirigir para evitar el reenvío del formulario
    echo "<script>setTimeout(() => { window.history.replaceState(null, null, window.location.pathname); }, 0);</script>";
}
?>
