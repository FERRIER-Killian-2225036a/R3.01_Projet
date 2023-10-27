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
            <label for="tag-input1">Entrez les tags de votre publication</label>
            <input type="text" name="Tags" id="tag-input1">


            <!-- Input d'image -->
            <!--<form enctype="multipart/form-data" class="background round">-->
                <label for="file"  class="btn btn-outline-dark mr-2 round" id="chooseFileLabel">Entrez votre miniature

                    <input id="file" type="file" name="BlogPicture" accept=".jpg, .jpeg, .png, .gif"
                           style="display: none;">

                    <img src="../../media/public_assets/icone/iconeBlogUploadImg.png" width="300" height="300"
                         alt="logo pour l'upload d'image">
                </label>


            <script> //TODO déplacé le script dans un fichier js
                // Lorsque le bouton est cliqué
                document.querySelector('label[for="file"]').addEventListener('click', function () {
                    // Clique sur l'input de fichier caché pour permettre à l'utilisateur de choisir un fichier
                    document.getElementById('file').click();
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

