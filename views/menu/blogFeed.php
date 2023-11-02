<link rel="stylesheet" href="../../common_styles/menu.css">
<main class="container">
    <div class="p-3">
        <div class="btn bg-body-tertiary round background grow-button" id="divButtonRole" role="button">
            <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
            <div class="text-content">
                <h1 class="responsive-title"><?php echo $mapView['blogTitle'] ?></h1>
                <p class="lead responsive-text"><?php echo $mapView['Tags'] ?> <?php echo $mapView['blogAuthor'] ?> - <?php echo $mapView['blogDate'] ?> </p>
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
    <script src="/common_scripts/maxTextSize.js"></script>
    <script src="/common_scripts/divClickable.js"></script>
</main>
