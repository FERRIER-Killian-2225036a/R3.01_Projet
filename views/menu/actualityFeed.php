<link rel="stylesheet" href="../../common_styles/menu.css">
<main class="container">
    <div class="p-3">
        <a class="btn bg-body-tertiary round background grow-button" role="button" href="<?php echo $mapView['actualityLien'] ?>" target="_blank">
            <img src="<?php echo $mapView['actualityUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
            <div class="text-content">
                <h1 class="responsiveTitle"><?php echo $mapView['actualityTitle']; ?></h1>
                <p class="lead responsiveText"> Catégorie - <?php echo $mapView['actualityDate']; ?> - <?php echo $mapView['actualityAuthor']; ?> </p> <!-- TODO : catégorie -->
                <p class="responsiveText"><?php echo $mapView['actualityContent']; ?></p>
            </div>
        </a>
    </div>
    <script src="../../common_scripts/maxTextSize.js"></script>
</main>