<link rel="stylesheet" href="../../common_styles/menu.css">
<main class="container">
<<<<<<< HEAD
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
                                </button><?php echo $mapView['blogPostUrl'] ?>
=======
    <div class="col-md-6 p-3">
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
>>>>>>> fc721335854bf912df23033258cedbc0fdd85d78
                            </div>
                        </div>
                    </div>
                    <!-- Fin de la section commentaire -->
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("divButtonRole").addEventListener("click", function() {
            const isInput = event.target.closest('.input-group');
            const isCustomInput = event.target.classList.contains('custom-input');

            if (!isInput && !isCustomInput) {
                window.location.href = "<?php echo $mapView['blogPostUrl'] ?>";
            }
        });
    </script>
    <script src="/common_scripts/maxTextSize.js"></script>
</main>
