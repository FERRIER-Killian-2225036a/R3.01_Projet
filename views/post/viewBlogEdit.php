<link rel="stylesheet" href="/common_styles/post.css">
<link rel="stylesheet" href="/common_styles/simple-tags.css" >
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



        <!--test selecteur-->
        <div class="col-md-4">
            <label for="validationTags" class="form-label">Tags</label>
            <select class="form-select" id="validationTags" name="tags[]" multiple="" style="display: none;">

                <option value="1" data-init="1">Apple</option>
                <option value="2">Banana</option>
                <option value="3">Orange</option>
            </select><div class="form-control dropdown"><div><input type="text" autocomplete="off" style="border: 0px; outline: 0px; max-width: 100%;" aria-label="Type a value" placeholder="Choose a tag..." size="15"></div><ul class="dropdown-menu p-0" style="max-height: 280px; overflow-y: auto;"><li><a class="dropdown-item" data-value="1" href="#">Apple</a></li><li><a class="dropdown-item" data-value="2" href="#">Banana</a></li><li><a class="dropdown-item" data-value="3" href="#">Orange</a></li></ul></div>
            <div class="invalid-feedback">Please select a valid tag.</div>
        </div>

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
    <script src="../../common_scripts/simple-tags.js"></script>

</main>

