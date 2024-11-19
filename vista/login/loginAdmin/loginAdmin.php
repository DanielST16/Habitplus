<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../../../public/Estilos/LoginStyle.css">
    

</head>

<body>
    <div class="wrapper">
        <form action="" class="form" method="POST">
            <h1 class="tittle">Inicio</h1>
            <?php
                include ("../../../modelo/conexion.php");
                include ("../../../controlador/controladorLoginAdmin.php");
            ?>
            <div class="inp">
                <input type="text" name="usuario" class="input" placeholder="Usuario">
                <i class="fa-solid- fa-user"></i>
            </div>
            <div class="inp">
                <input type="password" name="contraseña" class="input" placeholder="Contraseña">
                <i class="fa-solid- fa-lock"></i>
            </div>
            <input type = "submit" name = "btningresarAdmin" value="Iniciar Sesion" class="submit"/>
        </form>

        <div></div>

        <div class="banner">
            <h1 class="wel_text">BIENVENIDO</br>ADMIN</h1>
            <p class="footer">¿Solo eres usuario?    <a href="../login.php" class="link">Inicia sesion aqui</a></p>
            <p class="footer">volver a la <a class="link" href="../../../index.php">Pagina principal</a></p>
        </div>
    </div>
</body>

</html>