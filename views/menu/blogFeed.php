<!-- Inclusion de la feuille de style CSS -->
<link rel="stylesheet" href="../../common_styles/menu.css">

<!-- Élément principal de la page -->
<main class="container">
    <div class="p-3">
        <!-- Conteneur du bouton avec rôle de bouton -->
        <div class="btn bg-body-tertiary round background grow-button" id="divButtonRole" role="button">
            <!-- Image associée au bouton -->
            <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
            <!-- Contenu textuel du bouton -->
            <div class="text-content">
                <!-- Titre du blog -->
                <h1 class="responsive-title"><?php echo $mapView['blogTitle'] ?></h1>
                <!-- Informations sur le blog (tags, auteur, date) -->
                <p class="lead responsive-text"><?php echo $mapView['Tags'] ?> <?php echo $mapView['blogAuthor'] ?> - <?php echo $mapView['blogDate'] ?> </p>
                <!-- Contenu du blog -->
                <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
                <!-- Début de la section commentaire -->
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group align-items-center">
                            <label>
                                <input type="text" class="form-control custom-input inputBackground" placeholder="Commenter">
                            </label>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-save">#blog</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin de la section commentaire -->
            </div>
        </div>
    </div>

    <!-- Script JavaScript pour gérer le comportement du bouton avec rôle de bouton -->
    <script>
        document.getElementById("divButtonRole").addEventListener("click", function() {
            const isInput = event.target.closest('.input-group');
            const isCustomInput = event.target.classList.contains('custom-input');

            if (!isInput && !isCustomInput) {
                window.location.href = "<?php echo $mapView['blogPostUrl'] ?>";
            }
        });
    </script>

    <!-- Inclusion d'un script JavaScript externe -->
    <script src="/common_scripts/maxTextSize.js"></script>
</main>
