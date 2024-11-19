MiApp.component("sidebar", {
    template:/*html*/
        `
    <nav class="side-menu">
    <ul class="side-menu-list p-0">

        <li class="red">
            <a href="index.html">
                <i class="fas fa-house-user"></i>
                <span class="lbl">INICIO</span>
            </a>
        </li>

        <li class="grey with-sub">
            <span>
                <i class="fas fa-user"></i>
                <span class="lbl">USUARIOS</span>
            </span>
            <ul>
                <li>
                    <a href="usuario.html">
                        <i class="fas fa-users icono-submenu"></i>
                        <span class="lbl">Todos los usuarios</span>
                    </a>
                </li>
                <li><a href="#">
                        <i class="fas fa-plus icono-submenu"></i>
                        <span class="lbl">Nuevo usuario</span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>

    <section>
        <header class="side-menu-title">Etiquetas</header>
        <ul class="side-menu-list p-0">
            <li>
                <a href="#">
                    <i class="fas fa-info-circle"></i>
                    <span class="lbl">ACERCA DE...</span>
                </a>
            </li>
        </ul>
    </section>
</nav>
    `
});