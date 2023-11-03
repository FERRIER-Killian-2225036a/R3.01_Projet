<div class="col-md-6 p-3">
    <div class="btn bg-body-tertiary round background grow-button d-block" role="button" id="divButtonRole">
        <div class="d-flex justify-content-center mb-2">
            <img src="<?php echo $mapView['blogUrlPicture'] ?>" alt="Logo" class="responsive-image-setting round p-1">
        </div>
        <div class="text-content">
            <span class="d-flex">
                <h1 class="responsive-title"><?php echo $mapView['blogTitle'] ?></h1>
                <!-- Formulaire pour ajouter aux signets -->
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post">
                    <button name="bookmark" title="Signet" type="submit" id="formSignet">
                        <svg xmlns="http://www.w3.org/2000/svg" id="svgBookmarkAdd" width="2.3em" height="2.3em" fill="currentColor" class="bi bi-bookmark-plus" viewBox="0 0 16 16">
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" id="svgBookmarkDel" width="2.3em" height="2.3em" fill="currentColor" class="bi bi-bookmark-x" viewBox="0 0 16 16" style="display: none">
                            <path fill-rule="evenodd" d="M6.146 5.146a.5.5 0 0 1 .708 0L8 6.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 7l1.147 1.146a.5.5 0 0 1-.708.708L8 7.707 6.854 8.854a.5.5 0 1 1-.708-.708L7.293 7 6.146 5.854a.5.5 0 0 1 0-.708z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                        </svg>
                    </button>
                </form>
            </span>
            <p class="lead responsive-text"><?php echo $mapView['blogTags'] ?> <?php echo $mapView['blogDate'] ?>
                - Par <?php echo $mapView['blogAuthor'] ?></p>
            <p class="responsive-text"><?php echo $mapView['blogContent'] ?></p>
        </div>
    </div>
</div>
<script src="/common_scripts/myPostDisplay.js"></script>
<script src="/common_scripts/postOptions.js"></script>
<script>
    // Script pour le changement du logo signet
    // Récupération du booleen pour savoir si le post est enregistré ou pas
    const boolIsPostBookmarked = <?php echo $mapView['BoolIsPostBookmarked'] ? 1 : 0 ?>;
    // Sélection du signet d'ajout
    const svgBookmarkAdd = document.getElementById('svgBookmarkAdd');
    // Sélection du signet de suppression
    const svgBookmarkDel = document.getElementById('svgBookmarkDel');
    // Condition si l'utilisateur a enregistré le post
    if (boolIsPostBookmarked === 1) {
        // On cache le signet d'ajout
        svgBookmarkAdd.style.display = 'none';
        // On affiche le signet de suppression
        svgBookmarkDel.style.display = 'flex';
    }
</script>
</div>
</div>