<?php require 'sideBar.php' ?>
<script src="../../common_scripts/dropdown.js"></script>
<div class="col container">

    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Mes enregistrements </h1>
        </div>
        <!-- Section pour le dropdown filtrer -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="dropdown">
                <button type="button" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                    Filtrer
                </button>
                <ul class="dropdown-menu">
                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    <li><a href="#">Data</a></li>
                    <li><a href="#">Cybersec</a></li>
                    <li><a href="#">IDK</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-3">
        <!--Section pour les articles enregistrer -->
        <main class="container">
            <div class="row">
                <!-- Premier élément -->
                <div class="col-md-6 p-3">
                    <a class="btn bg-body-tertiary round background grow-button" role="button" href="<?php echo $mapView['actualityLien'] ?>" target="_blank">
                        <img src="<?php echo $mapView['actualityUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
                        <div class="text-content">
                            <h1 class="responsiveTitle"><?php echo $mapView['actualityTitle']; ?></h1>
                            <p class="lead responsiveText"> Catégorie - <?php echo $mapView['actualityDate']; ?> - <?php echo $mapView['actualityAuthor']; ?> </p>
                            <p class="responsiveText"><?php echo $mapView['actualityContent']; ?></p>
                        </div>
                    </a>
                </div>

                <!-- Deuxième élément (Dupliquez ce bloc pour chaque élément supplémentaire) -->
                <div class="col-md-6 p-3">
                    <a class="btn bg-body-tertiary round background grow-button" role="button" href="<?php echo $mapView['actualityLien'] ?>" target="_blank">
                        <img src="<?php echo $mapView['actualityUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
                        <div class="text-content">
                            <h1 class="responsiveTitle"><?php echo $mapView['actualityTitle']; ?></h1>
                            <p class="lead responsiveText"> Catégorie - <?php echo $mapView['actualityDate']; ?> - <?php echo $mapView['actualityAuthor']; ?> </p>
                            <p class="responsiveText"><?php echo $mapView['actualityContent']; ?></p>
                        </div>
                    </a>
                </div>
            </div>

            <script src="../../common_scripts/maxTextSize.js"></script>
        </main>

