<?php require 'sideBar.php' ?>
<div class="col container">

    <!-- Section pour le titre avec le bouton de création -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Demande de support</h1>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="btn-group">
                <button class="btn btn-outline-dark" name="createTicket" value="1" type="submit">Créer un ticket</button>
            </div>
        </div>
        <hr class="my-3">
        <!-- Section pour la table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Object</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Aliquam laoreet vitae laoreet.</td>
                <td>2022-03-17</td>
                <td>En cours de traitement</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Vestibulum ut libero nec orci.</td>
                <td>2022-03-17</td>
                <td>En attentes</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Nunc id vehicula elit gravida.</td>
                <td>2022-03-17</td>
                <td>Fermé</td>
            </tr>
            </tbody>
        </table>
        <hr class="my-3">

        <!--Section pour le signalement-->

        <div class="row mb-2">
            <div class="col-md-6">
                <h2>Signalement</h2>
            </div>
        </div>
        <div class="row mb-4">
                <label for="object-input"></label>
                <div class="col-md-12">
                    <input type="text" class="form-control inputBackground" name="username" id="object-input" placeholder="Objet">
                </div>
        </div>
        <div class="row mb-4">
            <label for="contenu-input"></label>
            <div class="col-md-12">
                <textarea class="form-control custom-form inputBackground" rows="5" id="contenu-input" placeholder="Entrez votre contenu ici..."></textarea>
            </div>
        </div>
        <div class="col-md-12 d-flex align-items-center justify-content-center">
            <div class="btn-group">
                <button class="btn btn-custom-green" name="ChangeUsername" value="1" type="submit">Envoyer</button>
            </div>
        </div>
