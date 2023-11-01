<link rel="stylesheet" href="../../common_styles/profileSettings.css">
<link rel="stylesheet" href="../../common_styles/general.css">
<div class="container-fluid ">
    <div class="row" id="container">
        <div class="d-flex flex-column flex-shrink-0 shadow round mt-3 p-2" style="width: 280px;"> <!-- Ajout de la classe 'shadow' ici -->

            <!-- Mon compte -->
            <a href="/Settings/" class="align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none text-dark"> <!-- Ajout de 'text-dark' ici -->
                <img src="<?= (SessionManager::isUserConnected() && $_SESSION['UrlPicture']!==null ) ? $_SESSION['UrlPicture'] : Constants::PDP_URL_DEFAULT; ?>" alt="Profil Image" width="40" height="40" class="rounded-circle me-2">
                <span class="fs-4"><?php echo $_SESSION["Username"]; ?></span>
                <p class="fs-4" id="mail"><?php echo $_SESSION['Mail'];?></p>
            </a>
            <hr class="my-3">
            <ul class="nav nav-pills flex-column mb-auto align-items-center">
                <!-- Information personnel-->
                <li class="nav-item">
                    <a href="/Settings/ManageAccount" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Informations personnelles
                    </a>
                </li>
                <!-- Support -->
                <li>
                    <a href="/Settings/Support" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Support
                    </a>
                </li>
                <!-- Langue -->
                <li>
                    <a href="/Settings/Language" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Langue
                    </a>
                </li>
                <!-- Thème -->
                <li>
                    <a href="/Settings/Theme" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Thème
                    </a>
                </li>
                <hr class="my-3">
                <!--Mes enregistrements -->
                <li class="nav-item">
                    <a href="/Settings/Bookmark" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Mes enregistrements
                    </a>
                </li>
                <!-- Personnes suivies -->
                <li>
                    <a href="/Settings/Follow" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Personnes suivies
                    </a>
                </li>
                <!-- Mes commentaires -->
                <li>
                    <a href="/Settings/MyComment" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Mes commentaires
                    </a>
                </li>
                <!-- Mes posts -->
                <li>
                    <a href="/Settings/MyPost" class="nav-link custom-nav-link text-dark"> <!-- Ajout de 'text-dark' ici -->
                        Mes posts
                    </a>
                </li>
            </ul>
            <hr class="hr-color">
            <a href="/Auth/LogOut" class="d-flex align-items-center justify-content-center mb-3 link-body-emphasis text-danger text-decoration-none">
                <img src="/media/public_assets/icone/iconeSeDeconnecter.png" alt="Logo de déconnexion" class="me-2">
                Se déconnecter
            </a>

        </div>