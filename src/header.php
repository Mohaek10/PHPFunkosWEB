<header>
    <h1>Funkos</h1>
</header>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark gradient-custom">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="#">FunkoLandia</a>

        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars text-light"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left links -->
            <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link active" aria-current="page" href="#!">

                        Inicio
                    </a>
                </li>
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="#!">
                        Categorias
                    </a>
                </li>
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link disabled" aria-disabled="true" href="#!">
                        Admin
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex flex-row mt-3 mt-lg-0">
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="#!">
                        <div>
                            <i class="fas fa-bell fa-lg mb-1"></i>
                            <span class="badge rounded-pill badge-notification bg-dark">11</span>
                        </div>
                        Messages
                    </a>
                </li>
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="#!">
                        <div>
                            <i class="fas fa-globe-americas fa-lg mb-1"></i>
                            <span class="badge rounded-pill badge-notification bg-dark">11</span>
                        </div>
                        News
                    </a>
                </li>
            </ul>

            <form class="d-flex input-group w-auto ms-lg-3 my-3 my-lg-0">
                <input type="search" class="form-control" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-primary" type="button" data-mdb-ripple-color="dark">
                    Search
                </button>
            </form>
        </div>
    </div>
</nav>
<style>
    .btn {
        padding: .45rem 1.5rem .35rem;
    }

    .gradient-custom {
        background: #9b2a2a;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgb(43, 45, 129), rgb(133, 4, 4));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(43, 45, 129, 1), rgb(134, 7, 7))
    }
</style>