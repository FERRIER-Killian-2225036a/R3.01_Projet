<?php require 'sideBar.php' ?>
<script src="../../common_scripts/dropdown.js"></script>
<link rel="stylesheet" href="../../common_styles/dropdown.css">

<div class="col container" id="rightSide">
    <!--Pas sur que sa fonctionne à voir avec Killian et Tom -->

    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Mes Posts </h1>
        </div>
        <!-- Section pour le dropdown filtrer -->
        <div class="col-md-6 d-flex align-items-center justify-content-end">
            <div class="dropdown">
                <button type="button" class="btn btn-primary" id="filterButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-filter" viewBox="0 0 16 16">
                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                    Filtrer
                </button>
                <ul class="dropdown-menu">
                    <label><input class="form-control" id="myInput" type="text" placeholder="Search.."></label>
                    <li><a href="#">Data</a></li>
                    <li><a href="#">Cybersec</a></li>
                    <li><a href="#">IDK</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-3">
        <!--Section pour les articles enregistrer -->
        <div class="col-md-6 p-3">
            <label id="noBlogMessage" style="display: none">Vous n'avez pas d'articles</label>
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
                            <a onclick="sendPostShowOrHide('<?php echo $mapView['id'] ?>')"> <?php if ($mapView['statusP'] != "innactive") {
                                    echo ($mapView['statusP'] == "active") ? "Mettre en visibilité public" : "Mettre en visibilité privé";
                                } ?></a>
                            <!-- De toute facon on affiche pas la publication si innactive + test dans le controller pour la requete post-->

                            <a onclick="sendPostDelete('<?php echo $mapView['id'] ?>')">Supprimer</a>
                        </div>
                    </div>
                    </span>
                    <p class="lead responsive-text"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                        - Par <?php echo $mapView['blogAuthor'] ?></p>
                    <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
                </div>
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

            const divButtonRole = document.getElementById('divButtonRole');
            divButtonRole.style.display = "inherit";

            divButtonRole.addEventListener("click", function() {
                window.location.href = "<?php echo $mapView['blogPostEditUrl'] ?>";
            });
            const blogTitle = document.getElementById('responsive-title');
            const noBlogMessage = document.getElementById('noBlogMessage');

            noBlogMessage.style.display = "none";
            if (blogTitle === null) {
                divButtonRole.style.display = "none!important";
                noBlogMessage.style.display = "flex";
            }

        </script>

        </div>
    </div>
    <script src="../../common_scripts/maxTextSize.js"></script>


