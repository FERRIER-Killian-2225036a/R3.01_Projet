<link rel="stylesheet" href="/common_styles/user.css">
<link rel="stylesheet" href="/common_styles/post.css">
<script src="/common_scripts/dropdown.js"></script> <!-- Inclusion du script de dropdown -->
<link rel="stylesheet" href="/common_styles/dropdown.css"> <!-- Inclusion de la feuille de style pour le dropdown -->
<div class="col container" id="rightSide">
    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2">
        <!-- Colonne de gauche -->
        <div class="col-md-6 d-flex">
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
                    <label for="myInput">
                    <input class="form-control" id="myInput" type="text" placeholder="Search.."></label>
                    <li><a href="#">Data</a></li>
                    <li><a href="#">Cybersec</a></li>
                    <li><a href="#">IDK</a></li>
                </ul>
            </div>
        </div>
    </div>
    <label id="noPost">Pas de post</label> <!-- Étiquette pour afficher "Pas de post" -->

