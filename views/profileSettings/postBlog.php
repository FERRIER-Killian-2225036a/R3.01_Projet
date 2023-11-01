<main class="container">
    <div class="row">
        <!-- Premier élément -->
        <div class="col-md-6 p-3" id="rightSide">

            <a class="btn bg-body-tertiary round background grow-button d-block" role="button"
               href="<?php echo $mapView['blogPostEditUrl'] ?>"
               target="_blank">
                <div class="d-flex justify-content-center mb-2">
                    <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo"
                         class="responsive-image-setting round p-1">
                </div>
                <div class="text-content">
                    <h1 class="responsiveTitle"><?php echo $mapView['blogTitle'] ?></h1>
                    <p class="lead responsiveText"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                        - Par <?php echo $mapView['blogAuthor'] ?></p>
                    <p class="responsiveText"><?php echo $mapView['blogContent'] ?></p> <!-- ajouté categories-->
                </div>
            </a>
            <div class="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                </svg>
                <div class="dropdown-content">
                    <a href="<?php echo $mapView['blogPostEditUrl'] ?>">Modifier</a>
                    <a onclick="sendPostShowOrHide('<?php echo $mapView['id'] ?>')"> <?php if ($mapView['statusP'] != "innactive") {
                            echo ($mapView['statusP'] == "active") ? "Mettre en visibilité public" : "Mettre en visibilité privé";
                        } ?></a>
                    <!-- De toute facon on affiche pas la publication si innactive + test dans le controller pour la requete post-->

                    <a onclick="sendPostDelete('<?php echo $mapView['id'] ?>')">Supprimer</a>
                </div>
            </div>
            <script>
                function sendPostShowOrHide(id) {
                    fetch('/Post/BlogEdit/' + id, {
                        method: 'POST',
                        body: 'ChangeVisibilityBlog',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    });
                }

                function sendPostDelete(id) {
                    fetch('/Post/BlogEdit/' + id, {
                        method: 'POST',
                        body: 'DeleteBlog',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    });
                }
            </script>

        </div>
        <script src="../../common_scripts/maxTextSize.js"></script>
</main>

