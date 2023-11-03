<div class="col-md-6 p-3">
    <div class="btn bg-body-tertiary round background grow-button d-block" role="button" id="divButtonRole">
        <div class="d-flex justify-content-center mb-2">
            <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo" class="responsive-image-setting round p-1">
        </div>
        <div class="text-content">
            <span class="d-flex">
                <h1 class="responsive-title"><?php echo $mapView['blogTitle'] ?></h1>
                <div class="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                    </svg>
                    <div class="dropdown-content">
                        <a href="<?php echo $mapView['blogPostEditUrl'] ?>">Modifier</a>
                        <a id="modifyVisibilityButton"> <?php if ($mapView['statusP'] != "innactive") {
                                echo ($mapView['statusP'] == "active") ? "Mettre en visibilité privé" : "Mettre en visibilité public";
                            } ?></a>
                        <!-- De toute façon on n'affiche pas la publication si innactive + test dans le contrôleur pour la requête post -->
                        <a id="deleteButton">Supprimer</a>
                    </div>
                </div>
            </span>
            <p class="lead responsive-text"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                - Par <?php echo $mapView['blogAuthor'] ?></p>
            <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
        </div>
    </div>
</div>
</div>
</div>