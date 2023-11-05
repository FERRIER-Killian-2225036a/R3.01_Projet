<?php require 'sideBar.php' ?>
<div class="col container" id="rightSide">
    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2">
        <div class="col-md-5">
            <h1>Vos Suivis </h1>
        </div>
        <!-- Section pour le champ de recherche -->
        <div class="col-md-6 d-flex align-items-end">
            <label><input class="form-control" type="text" name="query" placeholder="Rechercher..."></label>
        </div>
        <hr class="my-3">
        <!-- Section pour le nombre de personnes suivies -->
        <div class="col-md-6">
            <h1>Vous suivez 1 compte : </h1>
        </div>
        <!-- Section des personnes suivies -->
        <div class="row mb-4">
            <?php foreach ($mapView["ArrayOfFollowedUser"] as $user) {
                echo '<div class="col-md-6 d-flex align-items-center justify-content-end">';
                echo '<a href="/User/Profil/' . $user->getId() . '" >';
                echo '<img src="' . $user->getUrlPicture() . '" alt="image de profil des follows" class="rounded-circle mr-3">';
                echo '</a>';
                echo '<div>';
                echo '<p class="mb-0">' . $user->getPseudo() . '</p>';
                echo '<small>' . $user->getNumberOfFollower() . ' Abonnés - '. $user->getNumberOfFollowed() ." Abonnements - " .$user->getNumberOfPost().' Posts</small>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-6 d-flex align-items-center justify-content-center">';
                echo '<div class="btn-group">';
                echo '<form action="/User/Profil/' . $user->getId() . '" method="post">';
                echo '<button type="submit" name="follow" class="btn btn-outline-dark">Se désabonner</button>'; //si abo on supp, sinon on add
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '<hr class="my-3">';
            } ?>
            <?php ?>
        </div>
    </div>
</div>
