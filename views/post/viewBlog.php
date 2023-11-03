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
                    <button class="btn btn-custom-purple" name="follow" type="submit">Suivre</button>
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
                        <img src="../../media/public_assets/icone/signet.png" alt="Signet" class="icon" id="signetImg">
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
    </script>
</div>
