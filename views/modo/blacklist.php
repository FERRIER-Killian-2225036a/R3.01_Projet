<?php require 'sideBarModo.php' ?>
<div class="col container" id="rightSide">

    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Blacklist</h1>
        </div>
        <!-- Section pour le dropdown filtrer -->
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
                        <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    </label>
                    <li><a href="#">IDK</a></li>
                    <li><a href="#">IDK</a></li>
                    <li><a href="#">IDK</a></li>
                </ul>
            </div>
        </div>
        <!-- Section pour la table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom d'utilisateur</th>
                <th scope="col">blacklisté depuis : </th>
                <th scope="col">Raison</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mario Bros</td>
                <td>2022-03-17</td>
                <td>Pizza trop cuite</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Luigi Bros</td>
                <td>2022-03-17</td>
                <td>A fait cuire mario</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Princesse Peach</td>
                <td>2022-03-17</td>
                <td>Racisme</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>Bowser</td>
                <td>2022-03-17</td>
                <td>Il est méchant</td>
            </tr>
            </tbody>
        </table>