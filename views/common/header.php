<!-- Barre de navigation supérieure -->
<nav class="navbar navbar-top navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <!-- Logo de Cyphub -->
            <img src="/media/public_assets/CyphubLogo.png" alt="Logo Cyphub" id="logoImg" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav responsive-menu ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <form action="/Menu/Search" method="POST" class="d-flex">
                        <!-- Barre de recherche -->

                        <input class="form-control" name="Search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </li>
                <li class="nav-item">
                    <?php if (SessionManager::isUserConnected()) : ?>
                        <a href="/Settings/ManageAccount">
                            <!-- Image de profil -->
                            <img src="<?= ($_SESSION['UrlPicture'] !== null) ? $_SESSION['UrlPicture'] : Constants::PDP_URL_DEFAULT; ?>"
                                 alt="Logo profil" class="menu-img" id="profileImg">
                        </a>
                    <?php else : ?>
                        <a href="/Auth/Login">
                            <!-- Bouton de connexion -->
                            <button class="btn btn-outline-dark ml-3">Se connecter</button>
                        </a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (SessionManager::isUserConnected()) : ?>
                        <a href="/Auth/LogOut">
                            <!-- Bouton de déconnexion -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="2.3em" height="2.3em" fill="black" class="bi bi-box-arrow-right" viewBox="0 0 16 16" style="margin-left: 0.8em;">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Barre de navigation inférieure -->
<nav class="navbar navbar-bottom navbar-expand navbar-light <?php echo ($_SERVER['REQUEST_URI'] === "/") ? 'bg-custom-purple' : 'bg-light'; ?>">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav subNavbar">
                <!-- Liens de navigation -->
                <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/") ? 'text-white' : ''; ?>" aria-current="page" href="/">Home</a>
                <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/") ? 'text-white' : ''; ?>" href="/Menu/ActualityFeed">Veille Tech</a>
                <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/") ? 'text-white' : ''; ?>" href="/Menu/BlogFeed">Blogs</a>
                <!--
                <a class="nav-link" href="/Menu/ForumFeed">Forum</a>
                -->
                <?php // Si l'utilisateur est connecté et sur la page Blog, vous pouvez générer des liens spécifiques ici
                if (SessionManager::isUserConnected() && $_SERVER['REQUEST_URI'] === "/Menu/BlogFeed") {
                    echo '<a class="btn btn-custom-purple ms-auto" href="/Post/BlogEdit">Nouveau Blog</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<!-- Script pour la gestion des liens de navigation -->
<script src="../../common_scripts/navLinks.js"></script>