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
                    <?php if (isset($mapView["id"])){
                        if ((new Blog_Page())->doesPageIdBelongToUser($mapView["id"],$_SESSION["UserId"])){
                            echo '<div class="dropdown-content">';
                            echo '<a href="'.$mapView['blogPostEditUrl'].'">Modifier</a>';
                            echo '<a onclick="sendPostShowOrHide('.$mapView["id"].')" id="modifyVisibilityButton"> '.(($mapView['statusP'] != "innactive") ? (($mapView['statusP'] == "active") ? "Mettre en visibilité privé" : "Mettre en visibilité public") : "").'</a>';
                            echo '<a onclick="sendPostDelete('.$mapView["id"].')" id="deleteButton">Supprimer</a>';
                            echo '</div>';
                        }
                        else {
                            echo '<div class="dropdown-content">';
                            //echo '<a href="'.$mapView['blogPostUrl'].'">Signaler</a>';
                            echo '<a id="seeBlog" href="'.$mapView['blogPostUrl'].'">Voir le blog</a>';
                            echo '<a onclick="sendPostUnbookmark('.$mapView["id"].')" id="unBookmarkBlog"  >Désenregistrer</a>';
                            //todo add function js to remove bookmark
                            echo '</div>';

                        }

                    } ?>
                </div>
            </span>
            <p class="lead responsive-text"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                - Par <?php echo $mapView['blogAuthor'] ?></p>
            <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
        </div>
    </div>
</div>

