<div class="col-md-6 p-3">
    <div class="btn bg-body-tertiary round background grow-button d-block button-role" role="button">
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
                        echo '<div class="dropdown-content exceptionButton-role">';
                        if ((new Blog_Page())->doesPageIdBelongToUser($mapView["id"],$_SESSION["UserId"])){?>
                            <a href="<?php echo $mapView['blogPostEditUrl']?>">Modifier</a>
                            <a onclick="sendPostShowOrHide(<?php echo $mapView["id"]?>)" id="modifyVisibilityButton"><?php
                                if ($mapView['statusP'] != "innactive") {
                                    echo ($mapView['statusP'] == "active") ? "Mettre en visibilité privé" : "Mettre en visibilité public";
                                }
                                ?></a>
                            <a onclick="sendPostDelete(<?php echo $mapView["id"]?>)" id="deleteButton">Supprimer</a>
                        <?php }
                        else {
                            //echo '<a href="'.$mapView['blogPostUrl'].'">Signaler</a>';?>
                            <a id="seeBlog" href="<?php echo $mapView['blogPostUrl']?>">Voir le blog</a>
                            <a onclick="sendPostUnbookmark(<?php echo $mapView["id"]?>)" id="unBookmarkBlog"  >Désenregistrer</a>
                            <?php
                            //todo add function js to remove bookmark
                        }
                        echo '</div>';

                    } ?>
                </div>
            </span>
            <p class="lead responsive-text"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                - Par <?php echo $mapView['blogAuthor'] ?></p>
            <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
        </div>
    </div>
</div>

