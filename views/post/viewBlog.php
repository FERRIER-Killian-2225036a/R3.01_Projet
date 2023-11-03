<link rel="stylesheet" href="/common_styles/post.css">
<div id="postBlogContainer">
    <div class="text-left mt-4">
        <!-- Titre du post -->
        <h1><?php echo $mapView['Title'] ?></h1>
        <div class="row mb-4">
            <!-- Section d'informations sur l'auteur -->
            <div class="col-md-6 d-flex align-items-center">
                <img src="<?php echo $mapView['ImgProfil'] ?>" alt="image" class="rounded-circle mr-3">
                <div id="textUser">
                    <p class="mb-0"><?php echo $mapView['Author'] ?></p>
                    <small><?php echo $mapView['NumberOfFollower'] ?> abonnés</small>
                </div>
                <!-- Formulaire pour suivre l'auteur -->
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post" >
                    <button class="btn btn-custom-purple" name="follow" type="submit" id="followButton">Suivre</button>
                </form>
            </div>
            <!-- Section de partage et signet -->
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <label id="copyLabel"></label>
                <a href="#" title="Partager" id="lienPartager">
                    <img src="../../media/public_assets/icone/partager.png" alt="Partager" class="icon">
                </a>
                <!-- Formulaire pour ajouter aux signets -->
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post">
                    <button name="bookmark" title="Signet" type="submit" id="formSignet">
                        <!--<img src="../../media/public_assets/icone/signet.png" alt="Signet" class="icon" >-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" id="signetImg" viewBox="0 0 16 16">
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
    <script>
        // Sélectionnez le bouton par son ID
        const lienPartager = document.getElementById('lienPartager');
        // Sélectionnez le texte que vous souhaitez copier
        const texteACopier = 'https://cyphub.tech<?php echo $mapView['CurentUrlPost'] ?>';
        // Sélectionnez le label par son ID
        const copyLabel = document.getElementById('copyLabel');
        // Ajoutez un gestionnaire d'événements de clic au bouton
        lienPartager.addEventListener('click', (e) => {
            e.preventDefault(); // Empêche le formulaire de se soumettre
            // affichage du label
            copyLabel.style.display = 'flex';
            // Copiez le texte dans le presse-papiers de l'utilisateur
            navigator.clipboard.writeText(texteACopier)
                // text affiché en fonction de l'état de la copie
                .then(() => {
                    copyLabel.innerHTML = 'Texte copié avec succès !   ';
                })
                .catch((err) => {
                    copyLabel.innerHTML = 'Erreur lors de la copie : ' + err;
                });
        });

        const followedButton = document.getElementById('followButton');
        const boolIsFollowed = <?php echo $mapView['BoolIsFollowed']?>;
        if (boolIsFollowed === 1) {
            followedButton.innerHTML = 'Suivie'
            followedButton.style.backgroundColor = 'var(--purple)';
            followedButton.style.color = 'white';
        }
    </script>
</div>
