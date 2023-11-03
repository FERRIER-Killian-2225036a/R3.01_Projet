<link rel="stylesheet" href="../../common_styles/menu.css">
<!-- Élément principal de la page -->
<main class="container">
    <div class="p-3">
        <!-- Bouton avec lien vers une page externe -->
        <a class="btn bg-body-tertiary round background grow-button" role="button" href="<?php echo $mapView['actualityLien'] ?>" target="_blank">
            <!-- Image associée au bouton -->
            <img src="<?php echo $mapView['actualityUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
            <!-- Contenu textuel du bouton -->
            <div class="text-content">
                <!-- Titre de l'actualité -->
                <h1 class="responsive-title"><?php echo $mapView['actualityTitle']; ?></h1>
                <!-- Informations sur l'actualité (catégorie, date, auteur) -->
                <p class="lead responsive-text"> Catégorie - <?php echo $mapView['actualityDate']; ?> - <?php echo $mapView['actualityAuthor']; ?> </p>
                <!-- Contenu de l'actualité -->
                <p class="responsive-text"><?php echo $mapView['actualityContent']; ?></p>
            </div>
        </a>
    </div>
</main>
