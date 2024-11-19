<?php
session_start();
include "../modelo/conexion.php";

$id_usuario = $_SESSION['ID']; 
$ID_Habito = $_POST['ID_Habito']; 

// Obtener el ID de Usuario_Habito
$sql_usuario_habito = "
    SELECT ID_Usuario_Habito 
    FROM Usuario_Habito 
    WHERE ID_Usuario = ? AND ID_Habito = ?
";

$stmt = $conexion->prepare($sql_usuario_habito);
$stmt->bind_param("ii", $id_usuario, $ID_Habito);
$stmt->execute();
$resultado_usuario_habito = $stmt->get_result();

if ($resultado_usuario_habito && $usuario_habito = $resultado_usuario_habito->fetch_object()) {
    $ID_Usuario_Habito = $usuario_habito->ID_Usuario_Habito;

    // Obtener los datos actuales del progreso de manera segura
    $sql_progreso = "
        SELECT Progreso_Total, Progreso_Mensual, Racha_Actual, Mejor_Racha, Ultima_Fecha 
        FROM Progreso 
        WHERE ID_Usuario_Habito = ?
    ";

    $stmt_progreso = $conexion->prepare($sql_progreso);
    $stmt_progreso->bind_param("i", $ID_Usuario_Habito);
    $stmt_progreso->execute();
    $resultado_progreso = $stmt_progreso->get_result();
    $hoy = new DateTime();

    if ($resultado_progreso && $progreso = $resultado_progreso->fetch_object()) {
        // Validar si ya se registró progreso hoy
        $ultima_fecha = new DateTime($progreso->Ultima_Fecha);

        if ($ultima_fecha->format('Y-m-d') === $hoy->format('Y-m-d')) {
            // Ya se realizó el hábito hoy
            header('Location: ../vista/inicio.php?error=1');
            exit();
        }

        // Calcular nueva racha
        $intervalo = $hoy->diff($ultima_fecha);
        $nueva_racha = ($intervalo->days == 1) ? $progreso->Racha_Actual + 1 : 1;

        // Verificar si es un nuevo mes
        $nuevo_progreso_mensual = ($hoy->format('Y-m') !== $ultima_fecha->format('Y-m')) 
            ? 1 
            : $progreso->Progreso_Mensual + 1;

        // Actualizar el mejor progreso
        $nuevo_mejor_racha = max($nueva_racha, $progreso->Mejor_Racha);

        // Incrementar progreso total
        $nuevo_progreso_total = $progreso->Progreso_Total + 1;

        // Actualizar los valores en la base de datos
        $sql_update = "
            UPDATE Progreso 
            SET Progreso_Total = ?, 
                Progreso_Mensual = ?, 
                Racha_Actual = ?, 
                Mejor_Racha = ?,
                Ultima_Fecha = NOW() 
            WHERE ID_Usuario_Habito = ?
        ";

        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("iiiii", $nuevo_progreso_total, $nuevo_progreso_mensual, $nueva_racha, $nuevo_mejor_racha, $ID_Usuario_Habito);

        if ($stmt_update->execute()) {
            header('Location: ../vista/inicio.php?success=1');
            exit();
        } else {
            echo "Error al actualizar el progreso.";
        }
    } else {
        // Insertar nuevo registro de progreso si no existe
        $sql_insert = "
            INSERT INTO Progreso (ID_Usuario_Habito, Progreso_Total, Progreso_Mensual, Racha_Actual, Mejor_Racha, Ultima_Fecha)
            VALUES (?, 1, 1, 1, 1, NOW())
        ";

        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("i", $ID_Usuario_Habito);

        if ($stmt_insert->execute()) {
            header('Location: ../vista/inicio.php?success=1');
            exit();
        } else {
            echo "Error al registrar el progreso inicial.";
        }
    }
} else {
    echo "No se encontró el registro de Usuario_Habito.";
}
?>
