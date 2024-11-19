<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit+ | Menú Principal</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/Estilos/indexStyle.css"> <!-- Tu archivo de estilos personalizados, opcional -->
</head>
<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <!-- Logo o nombre del proyecto -->
            <a class="navbar-brand fw-bold" href="index.php">
                Habit+
            </a>
            <!-- Botón responsive para dispositivos pequeños -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Opciones de navegación -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary mx-2" href="vista/login/login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary mx-2 text-white" href="vista/login/Registro.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary mx-2" href="vista/acerca.php">Acerca de</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
