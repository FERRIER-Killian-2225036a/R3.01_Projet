<main class="container">
            <div class="row">
                <!-- Premier élément -->
                <div class="col-md-6 p-3">
                    <a class="btn bg-body-tertiary round background grow-button d-block" role="button" href="<?php echo $mapView['blogPostEditUrl'] ?>"
                       target="_blank">
                        <div class="d-flex justify-content-center mb-2">
                            <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo"
                                 class="responsive-image-setting round p-1">
                        </div>
                        <div class="text-content">
                            <h1 class="responsiveTitle"><?php echo $mapView['blogTitle'] ?></h1>
                            <p class="lead responsiveText"><?php echo $mapView['blogTags']?> <?php echo $mapView['blogDate'] ?> - Par <?php echo $mapView['blogAuthor'] ?></p>
                            <p class="responsiveText"><?php echo $mapView['blogContent'] ?></p> <!-- ajouté categories-->
                        </div>
                    </a>
                </div>

            <script src="../../common_scripts/maxTextSize.js"></script>
        </main>

