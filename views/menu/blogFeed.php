<link rel="stylesheet" href="../../common_styles/menu.css">
<main class="container p-5">
    <div class="p-3">
        <a href="<?php echo $mapView['blogPostUrl'] ?>">

            <div class="btn bg-body-tertiary round background grow-button" role="button">
                <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
                <div class="text-content">
                    <h1 class="responsiveTitle"><?php echo $mapView['blogTitle'] ?></h1>
                    <p class="lead"> <?php echo $mapView['blogAuthor'] ?> - <?php echo $mapView['blogDate'] ?> </p>
                    <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group align-items-center">
                            <input type="text" class="form-control custom-input inputBackground"
                                   placeholder="Commenter">
                            <div class="input-group-append">
                                <a href="bookmark">
                                    <!-- TODO : mettre le bon lien formulaire requete + input commenter-->
                                    <img src="../../media/public_assets/icone/signet.png"
                                         alt="Icon de signet pour mettre en favorie" id="signetImg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </a>
    </div>
    <script src="../../common_scripts/maxTextSize.js"></script>
</main>
