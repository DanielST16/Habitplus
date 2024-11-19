<?php
if (!empty($_POST["btnAgregar"])) {
    // Verificamos si los campos no están vacíos
    if (!empty($_POST["txtNombre"]) && !empty($_POST["txtDescripcion"]) && !empty($_POST["txtImagen"])) {
        $nombre = $_POST["txtNombre"];
        $descripcion = $_POST["txtDescripcion"];
        $imagen = $_POST["txtImagen"];

        // Consulta para verificar si la categoría ya existe
        $stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM Categoria WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();

        if ($total > 0) {
            // Si la categoría ya existe, mostramos el error
            ?>
            <script>
                $(function notification() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "La categoría <?=$nombre?> ya existe",
                        styling: "bootstrap3"
                    });
                });
            </script>
            <?php
        } else {
            // Si no existe, insertamos la nueva categoría
            $stmt = $conexion->prepare("INSERT INTO Categoria (Nombre, Descripcion, Imagen) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $descripcion, $imagen);
            if ($stmt->execute()) {
                // Si la inserción fue exitosa
                ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "Correcto",
                            type: "success",
                            text: "La categoría <?=$nombre?> se agregó correctamente",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php
            } else {
                // Si hubo un error al insertar
                ?>
                <script>
                    $(function notification() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "La categoría <?=$nombre?> no se pudo agregar",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php
            }
        }
    } else {
        // Si los campos están vacíos
        ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Los campos están vacíos",
                    styling: "bootstrap3"
                });
            });
        </script>
        <?php
    }
}
?>

<script>
    // Recarga la página después de un tiempo
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 0);
</script>
