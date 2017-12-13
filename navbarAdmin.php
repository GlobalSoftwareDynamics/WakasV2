<header class="container-fluid bg-light">
    <section class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="mainAdmin.php"><img src="img/WakasNavbar.png" height="60" width="auto" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Productos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="nuevaHE.php">Nueva Hoja de Especificaciones</a>
                            <a class="dropdown-item" href="gestionProductos.php">Listado de Productos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ventas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="nuevaCV_DatosGenerales.php">Nueva Confirmación de Venta</a>
                            <a class="dropdown-item" href="gestionCV.php">Listado de Confirmaciones de Venta</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Producción
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="nuevaOP_DatosGenerales.php">Nueva Orden de Producción</a>
                            <a class="dropdown-item" href="gestionOP.php">Listado de Órdenes de Producción</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Información Interna
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="gestionMateriales.php">Materiales</a>
                            <a class="dropdown-item" href="gestionInsumos.php">Insumos</a>
                            <a class="dropdown-item" href="gestionMaquinas.php">Máquinas</a>
                            <a class="dropdown-item" href="gestionColaboradores.php">Colaboradores</a>
                            <a class="dropdown-item" href="gestionProcedimientos.php">Procedimientos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Reportes de Producción</a>
                            <a class="dropdown-item" href="#">Reportes de Personal</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Directorio
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="gestionClientes.php">Clientes</a>
                            <a class="dropdown-item" href="gestionProveedores.php">Proveedores</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 ml-1" action="index.php" method="post">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </nav>
    </section>
</header>