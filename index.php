<!-- se carga el navbar -->
<?php require('vista/layout/navbar.php'); ?>
    <!-- Contenido principal -->
    <header class="bg-light text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Bienvenido a Habit+</h1>
            <p class="lead text-secondary">El lugar donde tus hábitos te llevan al éxito.</p>
            <a href="vista/login/Registro.php" class="btn btn-primary btn-lg">Comienza ahora</a>
        </div>
    </header>

    <!-- ¿Que es? -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">¿Qué es Habit+?</h2>
            <p class="colortexto text-center">
                Habit+ es tu compañero ideal para construir y mantener hábitos saludables. Te ayudamos a establecer metas, 
                seguir tus progresos y convertir tus sueños en logros reales.
            </p>
            <div class="row text-center">
                <div class="col-md-6">
                    <h4>📈 Sigue tu progreso</h4>
                    <p>Consulta tus estadísticas y mantén la motivación.</p>
                </div>
                <div class="col-md-6">
                    <h4>✨ Crea tu mejor versión</h4>
                    <p>Convierte pequeños pasos en grandes logros.</p>
                </div>
            </div>
        </div>
    </section>

<!-- Se carga el footer -->
<?php require('vista/layout/footerindex.php'); ?>
