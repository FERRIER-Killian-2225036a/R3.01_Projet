 <!-- Inclusion des feuilles de style CSS -->
 <link rel="stylesheet" href="../../common_styles/general.css">
 <link rel="stylesheet" href="../../common_styles/homeFeed.css">

<!-- Section principale avec un arrière-plan -->
<section class="background">
    <section class="padding text-left">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <?php
                if (SessionManager::isUserConnected()) {
                    // User is logged in
                    echo '<h1 class="homeTitle">Bonjour ' . $_SESSION['Username'] . ' !</h1>';
                    echo '<p class="colorText lead text-body-secondary">Que voulez-vous faire aujourd\'hui ?</p>';
                    echo '<div class="col-lg-8 col-md-8 mx-left">';
                    echo '<a href="/Post/BlogEdit" class="cta colorText noneColor text-left block">';
                    echo '<span class="visual">Créer un blog</span>';
                    echo '<svg class="svg1" width="13px" height="10px" viewBox="0 0 13 10">';
                    echo '<path d="M1,5 L11,5"></path>';
                    echo '<polyline points="8 1 12 5 8 9"></polyline>';
                    echo '</svg>';
                    echo '</a>';
                    echo '</div>';
                } else {
                    // User is not logged in
                    echo '<h1 class="homeTitle">Bienvenue chez Cyphub !</h1>';
                    echo '<p class="colorText lead text-body-secondary">Connectez-vous à l\'avenir de la cybersécurité avec CybHub : Actualités, Blogs et Forums pour les passionnés de la cybersécurité</p>';
                    echo '<div class="col-lg-8 col-md-8 mx-left">';
                    echo '<a href="/Auth/Login" class="cta colorText noneColor text-left block">';
                    echo '<span class="visual">Se connecter</span>';
                    echo '<svg class="svg1" width="13px" height="10px" viewBox="0 0 13 10">';
                    echo '<path d="M1,5 L11,5"></path>';
                    echo '<polyline points="8 1 12 5 8 9"></polyline>';
                    echo '</svg>';
                    echo '</a>';
                    echo '<a href="/Auth/SignUp" class="cta colorText noneColor text-left block">';
                    echo '<span class="visual">Créer un compte</span>';
                    echo '<svg class="svg1" width="13px" height="10px" viewBox="0 0 13 10">';
                    echo '<path d="M1,5 L11,5"></path>';
                    echo '<polyline points="8 1 12 5 8 9"></polyline>';
                    echo '</svg>';
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>



    <div class="col-lg-6 col-md-4 text-right">
                <!-- Image de décoration à droite -->
                <img src="/media/public_assets/home-font.png" id="decorationImg" alt="Logo Cyphub" class="img-fluid animated" >
            </div>
        </div>
    </section>
</section>

<section class="py-3 text-center container overlap">
    <div class="py-lg-5">
        <!-- Conteneur de boutons -->
        <div id="buttonContainer" class="row">
            <div class="col-md-4 d-flex justify-content-center">
                <!-- Bouton pour la veille technologique -->
                <a href="/Menu/ActualityFeed" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button">
                    <img class="iconSize" src="../../media/public_assets/icone/iconeTerminalWhite.png" alt="Icone Veille Technologique">
                    <p class="colorText responsiveText">Veille Technologique</p>
                </a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <!-- Bouton pour les blogs -->
                <a href="/Menu/BlogFeed" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button">
                    <img class="iconSize" src="../../media/public_assets/icone/iconeBlogWhite.png" alt="Icone Blog">
                    <p class="colorText responsiveText">Blog</p>
                </a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <!-- Bouton pour le forum -->
                <a href="forumFeed.php" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button-disabled "><!-- "disabled" grow-button Pour l'instant jusqu'à ce que la page forum fonctionne dès que ça fonctionne virer le disabled-->
                    <img class="iconSize" src="../../media/public_assets/icone/iconeForumWhite.png" alt="Icone Forum">
                    <p class="colorText responsiveText">Forum</p>
                </a>
            </div>
        </div>
    </div>
</section>