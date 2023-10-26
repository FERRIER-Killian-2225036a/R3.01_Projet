<link rel="stylesheet" href="/common_styles/post.css">
<main class="container p-5">
    <div class="p-3">
        <div id="title">
            <h2>Edition nouveau blog</h2>
            <button class="btn btn-outline-danger" onclick="window.location.href='https://cyphub.tech/Menu/BlogFeed';">Quitter</button>
        </div>

        <!-- Titre -->
        <label class="bg-body-tertiary round background">
            <input type="text" class="form-control custom-input round inputBackground input" placeholder="Entrez votre titre">
        </label>

        <!-- Catégories -->
        <label class="bg-body-tertiary round background" id="categoriesLabel">
            <input type="text" class="form-control custom-input round inputBackground input" id="categoriesInput" placeholder="Entrez vos catégories">
            <p id="categoriesOutput">Vos catégories s'afficherons ici</p>
        </label>

        <!-- Input d'image -->
        <form action="/Settings/ManageAccount" method="POST" enctype="multipart/form-data" class="background round">
            <label for="file" class="btn mr-2 round" id="chooseFileLabel">
                <input id="file" type="file" name="ProfilePicture" accept=".jpg, .jpeg, .png, .gif" style="display: none;">
                <p>Entrez votre miniature</p>
                <img src="../../media/public_assets/imageTest.jpeg" width="300" height="200" alt="">
            </label>
        </form>

        <!-- Texte -->
        <label class="bg-body-tertiary round background textInput">
            <textarea class="form-control custom-input round inputBackground input" placeholder="Entrez le contenue"></textarea>
        </label>

        <!-- Bouton publier -->
        <span id="publishButtonContainer">
            <button class="btn btn-outline" id="publishButton">Publier</button>
        </span>
    </div>
    <script src="../../common_scripts/blog.js"></script>
</main>

