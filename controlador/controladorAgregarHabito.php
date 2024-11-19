<?php
if (!empty($_POST["btnAgregar"])) {
    if (!empty($_POST["txtNombre"]) && !empty($_POST["txtDescripcion"]) && !empty($_POST["selectCategoria"])) {
        $nombre = $_POST["txtNombre"];
        $descripcion = $_POST["txtDescripcion"];
        $categoria = $_POST["selectCategoria"];

        // Consulta para verificar si el hábito ya existe
        $stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM Habito WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();

        if ($total > 0) { ?>
            <script>
                $(function notification() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "El hábito '<?=$nombre?>' ya existe",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php } else {
            // Consulta para insertar el hábito
            $stmt = $conexion->prepare("INSERT INTO Habito (Nombre, Descripcion, ID_Categoria) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nombre, $descripcion, $categoria);
            if ($stmt->execute()) { ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "Correcto",
                            type: "success",
                            text: "El hábito '<?=$nombre?>' se agregó correctamente",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else { ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "El hábito '<?=$nombre?>' no se pudo agregar",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php }
        }
    } else { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Todos los campos son obligatorios",
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
