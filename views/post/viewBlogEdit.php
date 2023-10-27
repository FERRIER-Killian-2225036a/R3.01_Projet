<link rel="stylesheet" href="/common_styles/post.css">
<link rel="stylesheet" href="/common_styles/simple-tags.css">
<main class="container p-5">
    <div class="p-3">

        <div id="title">
            <h2>Edition nouveau blog</h2>
            <button class="btn btn-outline-danger"
                    onclick="window.location.href='https://cyphub.tech/Menu/BlogFeed';">Quitter
            </button>
        </div>
        <form action="/Post/BlogEdit" method="post" enctype="multipart/form-data">
            <!-- Titre -->
            <label class="bg-body-tertiary round background">
                <input name="Title" type="text" class="form-control custom-input round inputBackground input"
                       placeholder="Entrez votre titre">
            </label>

            <!-- Catégories OLD
            <label class="bg-body-tertiary round background" id="categoriesLabel">
                <input type="text" class="form-control custom-input round inputBackground input"
                       id="categoriesInput" placeholder="Entrez vos catégories">
                <p id="categoriesOutput">Vos catégories s'afficherons ici</p>
            </label>
             -->

            <!--Categorie new -->
            <h2>Tags Input</h2>
            <label for="tag-input1">Entrez les tags de votre publication</label>
            <input type="text" name="Tags" id="tag-input1">


            <!-- Input d'image -->
            <!--<form enctype="multipart/form-data" class="background round">-->
            <button id="PictureButton" class="btn btn-outline-dark">
                <label for="file" class="btn mr-2 round" id="chooseFileLabel">Entrez votre miniature</label>
                <input id="file" type="file" name="BlogPicture" accept=".jpg, .jpeg, .png, .gif"
                       style="display: none;">

                <img src="../../media/public_assets/icone/iconeBlogUploadImg.png" width="300" height="300"
                     alt="logo pour l'upload d'image">
            </button>
            <script> //TODO déplacé le script dans un fichier js
                // Lorsque le bouton est cliqué
                document.getElementById('fileButton').addEventListener('click', function () {
                    // Clique sur le label pour ouvrir le gestionnaire de fichiers
                    document.querySelector('label[for="file"]').click();
                });

                // Lorsque le champ de fichier est modifié (un fichier est sélectionné)
                document.getElementById('file').addEventListener('change', function () {
                    // Soumet automatiquement le formulaire lorsque l'utilisateur sélectionne un fichier
                    this.parentNode.submit(); // Cela enverra le formulaire avec le fichier sélectionné
                });
            </script>
            <!--</form>-->

            <!-- Texte -->
            <label class="bg-body-tertiary round background textInput">
                <textarea name="Content" class="form-control custom-input round inputBackground input"
                          placeholder="Entrez le contenue"></textarea>
            </label>

            <!-- Bouton publier -->
            <span id="publishButtonContainer">
                <button class="btn btn-outline" type="submit" id="publishButton">Publier</button>
            </span>
        </form>
    </div>
    <script src="../../common_scripts/blog.js"></script>
    <script src="../../common_scripts/simple-tags.js"></script>

</main>

