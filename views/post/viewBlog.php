<link rel="stylesheet" href="/common_styles/post.css">
<div class="container">
    <div class="text-left mt-4">
        <h1><?php echo $mapView['Title'] ?></h1>
        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center">
                <img src="<?php echo $mapView['ImgProfil'] ?>" alt="image" class="rounded-circle mr-3">
                <div id="textUser">
                    <p class="mb-0"><?php echo $mapView['Author'] ?></p>
                    <small><?php echo $mapView['NumberOfFollower'] ?> abonnés</small>
                </div>
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post" >
                    <button class="btn btn-custom-purple" name="follow" type="submit">Suivre</button>
                </form>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <label id="copyLabel" style="display: none"></label>
                <a href="#" title="Partager">
                    <img src="../../media/public_assets/icone/partager.png" alt="Partager" class="icon">
                </a>
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
                <img src="<?php echo $mapView['Img'] ?>" class="img-fluid" alt="Image du Blog">
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <p>
                    <?php echo $mapView['Content'] ?>
                </p>
            </div>
        </div>
    </div>
    <script>
        // Sélectionnez le bouton par son ID
        const boutonSignet = document.getElementById('formSignet');

        // Sélectionnez le texte que vous souhaitez copier
        const texteACopier = '<?php echo $mapView['CurentUrlPost'] ?>';

        const copyLabel = document.getElementById('copyLabel');

        // Ajoutez un gestionnaire d'événements de clic au bouton
        boutonSignet.addEventListener('click', (e) => {
            e.preventDefault(); // Empêche le formulaire de se soumettre
            copyLabel.style.display = 'flex';
            // Copiez le texte dans le presse-papiers de l'utilisateur
            navigator.clipboard.writeText(texteACopier)
                .then(() => {
                    copyLabel.innerHTML = 'Texte copié avec succès !';
                    console.log('Texte copié avec succès !');
                })
                .catch((err) => {
                    copyLabel.innerHTML = 'Erreur lors de la copie : ' + err;
                    console.error('Erreur lors de la copie :', err);
                });
        });
    </script>
</div>
