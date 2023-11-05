<link rel="stylesheet" href="/common_styles/user.css">
<main class="container">
    <div class="row mb-4">
        <!-- Colonne de gauche -->
        <div class="col-md-6 d-flex align-items-center">
            <img src="<?= $mapView["User"]->getUrlPicture() ;?>" alt="image" class="rounded-circle mr-3" id="imgUser">
            <div>
                <p class="mb-0"><?= $mapView["User"]->getPseudo() ;?></p>
                <small><?= $mapView["User"]->getNumberOfFollower() ;?> Abonnés - <?= $mapView["User"]->getNumberOfFollowed() ;?> Abonnements - <?= $mapView["User"]->getNumberOfPost() ;?> Posts</small>
                 <form action="/User/Profil/<?= $mapView["User"]->getId() ;?>" method="post">
                    <button type="submit" name="follow" class="btn btn-outline-dark">Se désabonner</button>
                 </form>

            </div>
        </div>
        <!-- Colonne de droite TODO a reparer -->
        <div class="col-md-6 d-flex align-items-center justify-content-end">
            <div class="dropdown">
                <button type="button" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                    Filtrer
                </button>
                <ul class="dropdown-menu">
                    <label for="myInput"></label>
                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    <li><a href="#">Data</a></li>
                    <li><a href="#">Cybersec</a></li>
                    <li><a href="#">IDK</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Articles -->
    <div class="row">
        <!-- Premier élément -->
        <div class="col-md-4 p-3">
            <a class="btn bg-body-tertiary round background grow-button d-block" role="button" href="#" target="_blank">
                <div class="d-flex justify-content-center mb-2">
                    <img src="../../media/public_assets/imageTest.jpeg" alt="Logo" class="responsive-image-user round p-1">
                </div>
                <div class="text-content">
                    <h1 class="responsiveTitle">Informatique nous rend dépendant</h1>
                    <p class="lead responsiveText">Catégorie - 00-00-00 - Par l'auteur</p>
                    <p class="responsiveText">ça va parler chinois : Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit neskwik... VOIR PLUS</p>
                </div>
            </a>
        </div>
        <!-- Deuxième élément -->
        <div class="col-md-4 p-3">
            <a class="btn bg-body-tertiary round background grow-button d-block" role="button" href="#" target="_blank">
                <div class="d-flex justify-content-center mb-2">
                    <img src="../../media/public_assets/imageTest.jpeg" alt="Logo" class="responsive-image-user round p-1">
                </div>
                <div class "text-content">
                <h1 class="responsiveTitle">Informatique nous rend dépendant</h1>
                <p class="lead responsiveText">Catégorie - 00-00-00 - Par l'auteur</p>
                <p class="responsiveText">ça va parler chinois : Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit neskwik... VOIR PLUS</p>
        </div>
    </div>
    <!-- Troisième élément -->
    <div class="col-md-4 p-3">
        <a class="btn bg-body-tertiary round background grow-button d-block" role="button" href="#" target="_blank">
            <div class="d-flex justify-content-center mb-2">
                <img src="../../media/public_assets/imageTest.jpeg" alt="Logo" class="responsive-image-user round p-1">
            </div>
            <div class="text-content">
                <h1 class="responsiveTitle">Informatique nous rend dépendant</h1>
                <p class="lead responsiveText">Catégorie - 00-00-00 - Par l'auteur</p>
                <p class="responsiveText">ça va parler chinois : Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit neskwik... VOIR PLUS</p>
            </div>
        </a>
    </div>
</main>
