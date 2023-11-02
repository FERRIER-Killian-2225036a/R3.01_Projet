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
        <form action="/Post/BlogEdit<?= "/".$mapView["UrlForm"] ?>" method="post" enctype="multipart/form-data">
            <!-- Titre -->
            <label class="bg-body-tertiary round background">
                <input name="Title" type="text" class="form-control custom-input round inputBackground input"
                       placeholder="Entrez votre titre" value="<?php echo $mapView["Title"]?>">
            </label>

            <!--Categorie new -->
            <label for="tag-input1">Entrez les tags de votre publication</label>
            <input type="text" name="Tags" id="tag-input1" class="form-control custom-input round inputBackground">
            <label id="wrongInfo"></label>

            <!-- Input d'image -->
            <label for="file"  class="btn btn bg-body-tertiary round background" id="chooseFileLabel">Entrez votre miniature
                <input id="file" type="file" name="BlogPicture" accept=".jpg, .jpeg, .png, .gif" style="display: none;">
                <img src="<?= ($mapView["Img"]!=null) ? $mapView["Img"] : "../../media/public_assets/icone/iconeBlogUploadImg.png" ?>" width="260" height="300"
                     alt="logo pour l'upload d'image">
            </label>

            <!-- Texte -->
            <label class="bg-body-tertiary round background textInput">
                <textarea name="Content" class="form-control custom-input round inputBackground input"
                          placeholder="Entrez le contenue" ><?php echo $mapView["Content"]?></textarea>
            </label>

            <!-- Bouton publier -->
            <span id="publishButtonContainer">
                <button class="btn btn-outline" type="submit" id="publishButton">Publier</button>
            </span>
        </form>
    </div>
    <script src="../../common_scripts/blog.js"></script>
    <script src="../../common_scripts/simple-tags.js"></script>
    <script src="/common_scripts/showErrorMessage.js"></script>
    <script>tagInput1.addData([<?php echo $mapView["Tags"]?>])</script>


</main>

