<link rel="stylesheet" href="/common_styles/post.css">
<div id="postBlogContainer">
    <div class="text-left mt-4">
        <!-- Titre du post -->
        <h1><?php echo $mapView['Title'] ?></h1>
        <div class="row mb-4">
            <!-- Section d'informations sur l'auteur -->
            <div class="col-md-6 d-flex align-items-center">
                <img src="<?php echo $mapView['ImgProfil'] ?>" alt="image" class="rounded-circle mr-3" height="45px">
                <div id="textUser">
                    <p class="mb-0"><?php echo $mapView['Author'] ?></p>
                    <small><?php echo $mapView['NumberOfFollower'] ?> abonnés</small>
                </div>
                <!-- Formulaire pour suivre l'auteur -->
                <form action="<?php echo $mapView["CurentUrlPost"] ?>" method="post">
                    <button class="btn btn-custom-purple followButton" name="follow" type="submit">Suivre</button>
                </form>
            </div>
            <!-- Section de partage et signet -->
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <label id="copyLabel"></label>
                <a href="" title="Partager" id="lienPartager">
                    <img src="../../media/public_assets/icone/partager.png" alt="Partager" class="icon">
                </a>
                <!-- Formulaire pour ajouter aux signets -->
                <form action="<?php echo $mapView["CurentUrlPost"] ?>" method="post">
                    <button name="bookmark" title="Signet" type="submit" id="formSignet">
                        <svg xmlns="http://www.w3.org/2000/svg" id="svgBookmarkAdd" width="2.3em" height="2.3em"
                             fill="currentColor" class="bi bi-bookmark-plus" viewBox="0 0 16 16">
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" id="svgBookmarkDel" width="2.3em" height="2.3em"
                             fill="currentColor" class="bi bi-bookmark-x" viewBox="0 0 16 16" style="display: none">
                            <path fill-rule="evenodd"
                                  d="M6.146 5.146a.5.5 0 0 1 .708 0L8 6.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 7l1.147 1.146a.5.5 0 0 1-.708.708L8 7.707 6.854 8.854a.5.5 0 1 1-.708-.708L7.293 7 6.146 5.854a.5.5 0 0 1 0-.708z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <img src="<?php echo $mapView['Img'] ?>" class="img-fluid" alt="Image du Blog" id="imgBlog">
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <!-- Contenu du post -->
                <p style="text-align: justify;">
                    <?php echo $mapView['Content'] ?>
                </p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center mt-4">
        <div class="col-8">
            <div class="input-group align-items-center">
                <form action="<?php echo $mapView["CurentUrlPost"] ?>" method ="POST" id="formCommentEnter">
                    <label>
                        <input type="text" name="Comment" class="form-control custom-input inputBackground" placeholder="Commenter">
                    </label>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center mt-4">
        <div class="col-8">
            <?php

            foreach ($mapView['Comments'] as $comment) {
                $picture = $comment->getUser()->getUrlPicture();
                if ($picture == null) {
                    $picture = "/media/users/Profil.png";
                }
                echo '<div class="col-md-6 d-flex align-items-center">';
                echo '<img src="' . $picture . '" alt="image" class="rounded-circle mr-3" height="45px">';
                echo '<div id="textUser">';
                echo '<p class="mb-0">' . $comment->getUser()->getPseudo() . '</p>';
                echo '<small>' . $comment->getUser()->getNumberOfFollower() . ' abonnés</small>';
                echo '</div>';
                //<!-- Formulaire pour suivre l'auteur /!\ potentiel bug revoir controlleur User pour géré les abos aussi pour l'auteur -->
                echo '<form action="' . "/User/Profil/". $comment->getUser()->getId() . '" method="post" >';
                echo '<button class="btn btn-custom-purple followButton" name="follow" type="submit">Suivre</button>';
                echo '</form>';
                if ($comment->getUser()->getId() == $_SESSION["UserId"]) {
                    echo '<form action="' . $mapView["CurentUrlPost"] . '" method ="POST" >';
                    echo '<button class="btn btn-custom-purple deleteComment" name="DeleteComment" value="'.$comment->getCommentId() .'" type="submit">Supprimer</button>';
                    echo '</form>';
                }
                else if ($comment->getUser()->getId() == $comment->getBlogPage()->getUserId()) {
                    echo '<form action="' . $mapView["CurentUrlPost"] . '" method ="POST" >';
                    echo '<button class="btn btn-custom-purple deleteComment" name="DeleteComment" value="'.$comment->getCommentId() .'" type="submit">Supprimer</button>';
                    echo '</form>';
                }
                echo '</div>';
                echo '<p>' . $comment->getTextC() . '</p>';
                echo "<hr>";

            } ?>
        </div>
    </div>

</div>
<script>
    // Script pour le bouton de partage
    // Sélection du bouton par son ID
    const lienPartager = document.getElementById('lienPartager');
    // Sélection du texte qu'on souhaite copier
    const texteACopier = 'https://cyphub.tech<?php echo $mapView['CurentUrlPost'] ?>';
    // Sélection du label par son ID
    const copyLabel = document.getElementById('copyLabel');
    // Ajoutez un gestionnaire d'événements de clic au bouton
    lienPartager.addEventListener('click', (e) => {
        e.preventDefault(); // Empêche le formulaire de se soumettre
        copyLabel.style.display = 'flex';
        // Copiez le texte dans le presse-papiers de l'utilisateur
        navigator.clipboard.writeText(texteACopier)
            .then(() => {
                copyLabel.innerHTML = 'Texte copié avec succès !   ';
            })
            .catch((err) => {
                copyLabel.innerHTML = 'Erreur lors de la copie : ' + err;
            });
    });

    // Script pour le changement du bouton suivre
    // Sélection du bouton suivre
    const followedButton = document.getElementsByClassName('followButton');
    // Récupération du boolen pour savoir si on suit l'utilisateur qui a posté
    let boolIsFollowed = <?php echo $mapView['BoolIsFollowed'] ? 1 : 0 ?>; // TODO php mauvais user, a changer (author au lieu de user) pas sure a verif ?
    // Condition si l'utilisateur est suivi
    if (boolIsFollowed === 1) {
        for (let i = 0; i < followedButton.length; ++i) {
            // On change le texte du bouton
            followedButton[i].innerHTML = 'Suivi';
            // On met le fond en violet
            followedButton[i].style.backgroundColor = 'var(--purple)';
            // On met le texte en blanc
            followedButton[i].style.color = 'white';
        }
    }

    // Script pour le changement du logo signet
    // Récupération du booleen pour savoir si le post est enregistré ou pas
    let boolIsPostBookmarked = <?php echo $mapView['BoolIsPostBookmarked'] ? 1 : 0 ?>; //TODO same ici mais pas sure
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