<link rel="stylesheet" href="../../common_styles/modo.css">
<div class="container-fluid">
    <div class="row" id="container">
        <div class="d-flex flex-column flex-shrink-0 shadow round mt-3 p-2" style="width: 280px;"> <!-- Ajout de la classe 'shadow' ici -->

            <!-- Mon compte -->
            <a href="/Settings/" class="align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none text-dark"> <!-- Ajout de 'text-dark' ici -->
                <p class="fs-4" id="mail">Modérateur</p>
            </a>
            <hr class="my-3">
            <ul class="nav nav-pills flex-column mb-auto align-items-center">
                <!-- Ticket -->
                <li class="nav-item">
                    <a href="/Settings/ManageAccount" class="nav-link custom-nav-link text-dark">
                        Ticket
                    </a>
                </li>
                <!-- En attentes -->
                <li>
                    <a href="/Settings/Support" class="nav-link custom-nav-link text-dark">
                        En attentes
                    </a>
                </li>
                <!-- En traitement  -->
                <li>
                    <a href="/Settings/Language" class="nav-link custom-nav-link text-dark">
                        En traitement
                    </a>
                </li>
                <!-- Fermés -->
                <li>
                    <a href="/Settings/Theme" class="nav-link custom-nav-link text-dark">
                        Fermés
                    </a>
                </li>
                <hr class="my-3">

                <!--Utilisateurs muets -->
                <li class="nav-item">
                    <a href="/Settings/Bookmark" class="nav-link custom-nav-link text-dark">
                        Utilisateurs muets
                    </a>
                </li>
                <!-- Blacklist -->
                <li>
                    <a href="/Settings/Follow" class="nav-link custom-nav-link text-dark">
                        Blacklist
                    </a>
                </li>
            <hr class="hr-color">
            <a href="/Auth/LogOut" class="d-flex align-items-center justify-content-center mb-3 link-body-emphasis text-danger text-decoration-none">
                <img src="/media/public_assets/icone/iconeSeDeconnecter.png" alt="Logo de déconnexion" class="me-2">
                Se déconnecter
            </a>

        </div>
        <script src="/common_scripts/locationInSidebar.js"></script>