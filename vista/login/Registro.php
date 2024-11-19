<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="../../public/Estilos/LoginStyle.css">
    <script>
        // Función para validar el formulario antes de enviarlo
        function validateForm() {
            var nombre = document.forms["registroForm"]["nombre"].value;
            var email = document.forms["registroForm"]["email"].value;
            var usuario = document.forms["registroForm"]["usuario"].value;
            var contraseña = document.forms["registroForm"]["contraseña"].value;

            // Validar nombre (mínimo 3 caracteres y solo letras)
            var nombreRegex = /^[a-zA-Z ]{3,}$/; // Permitir letras y espacios
            if (!nombre.match(nombreRegex)) {
                alert("El nombre debe tener al menos 3 caracteres y solo letras.");
                return false;
            }

            // Validar email (debe contener un "@" y un dominio válido)
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!email.match(emailRegex)) {
                alert("El correo electrónico no es válido.");
                return false;
            }

            // Validar usuario (debe contener al menos una letra y un número, no igual al nombre, sin espacios, y mínimo 3 caracteres)
            if (usuario === nombre) {
                alert("El usuario no puede ser igual al nombre.");
                return false;
            }
            var usuarioRegex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{3,}$/;  // Permite letras y números, sin espacios, mínimo 3 caracteres
            if (!usuario.match(usuarioRegex)) {
                alert("El usuario debe contener al menos una letra, un número, no puede tener espacios, y debe tener mínimo 3 caracteres.");
                return false;
            }

            // Validar contraseña (mínimo 4 caracteres)
            if (contraseña.length < 4) {
                alert("La contraseña debe tener al menos 4 caracteres.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <form name="registroForm" action="" method="POST" class="form" onsubmit="return validateForm()">
            <h1 class="tittle">Registro</h1>
            <?php
                include ("../../modelo/conexion.php");
                include ("../../controlador/controladorRegistro.php");
            ?>
            <div class="inp">
                <input type="text" name="nombre" class="input" placeholder="Nombre">
                <i class="fa-solid- fa-user"></i>
            </div>

            <div class="inp">
                <input type="text" name="email" class="input" placeholder="E-mail">
                <i class="fa-solid- fa-user"></i>
            </div>

            <div class="inp">
                <input type="text" name="usuario" class="input" placeholder="Usuario">
                <i class="fa-solid- fa-user"></i>
            </div>

            <div class="inp">
                <input type="password" name="contraseña" class="input" placeholder="Contraseña">
                <i class="fa-solid- fa-lock"></i>
            </div>

            <input type="submit" name="btnRegistrar" value="Registrarse" class="submit" />
            <p class="footer">¿Ya tienes cuenta? <a href="login.php" class="link">Inicia Sesion</a></p>
        </form>

        <div></div>

        <div class="banner">
            <h1 class="wel_text">BIENVENIDO</h1>
        </div>
    </div>
</body>

</html>
