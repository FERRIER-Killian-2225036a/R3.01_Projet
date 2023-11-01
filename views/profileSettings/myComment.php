<?php require 'sideBar.php'; ?>
<div class="col container">
    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2" id="rightSide">
        <div class="col-md-5">
            <h1>Vos Commentaires </h1>
        </div>
        <!-- Section pour le champs de recherche -->
        <div class="col-md-6 d-flex align-items-end">
            <label><input class="form-control" type="text" name="query" placeholder="Rechercher..."></label>
        </div>
        <hr class="my-3">
        <!-- Section pour la table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Status</th>
                <th scope="col">Dates</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>CHAPI CHAPO QUESTION ( blablabla les premieres lignes )
                <br><small> -> vous à vous bonjour</small></td>
                <td>Nouveau</td>
                <td>2022-03-17</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>CHAPI CHAPO QUESTION ( blablabla les premieres lignes )</td>
                <td>Ancien</td>
                <td>2022-03-17</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>CHAPI CHAPO QUESTION ( blablabla les premieres lignes )</td>
                <td>Ancien</td>
                <td>2022-03-17</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>CHAPI CHAPO QUESTION ( blablabla les premieres lignes )</td>
                <td>Ancien</td>
                <td>2022-03-17</td>
            </tr>
            </tbody>
        </table>
