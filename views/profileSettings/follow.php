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
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <img src="../../media/public_assets/favicon.png" alt="image" class="rounded-circle mr-3">
                <div>
                    <p class="mb-0">KrokmouLeFurynocturne</p>
                    <small>99 Abonnés     99 Abonnements     1K Posts</small>
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="btn-group">
                    <button class="btn btn-outline-dark">Se désabonner</button>
                </div>
            </div>
            <hr class="my-3">
        </div>
    </div>
</div>
