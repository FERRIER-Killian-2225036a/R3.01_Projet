<?php require 'sideBar.php' ?>
<div class="col container">

    <!-- Section pour le titre avec le bouton de création -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Demande de support</h1>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="btn-group">
                <button class="btn btn-outline-dark" name="createTicket" value="1" type="submit">Créer un ticket
                </button>
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
            <?php foreach ($mapView["ArrayOfTicket"] as $obj) {
                echo "<tr>";
                echo "<th scope=\"row\">" . $obj->getTicketId() . "</th>";
                echo "<td>" . $obj->getSubject() . "</td>";
                echo "<td>" . $obj->getDate() . "</td>";
                echo "<td>" . $obj->getStatus() . "</td>";
                echo "</tr>";
            }
                ?>
            </tbody>
        </table>
        <hr class="my-3">

        <!--Section pour le signalement-->

        <div class="row mb-2">
            <div class="col-md-6">
                <h2>Signalement</h2>
            </div>
        </div>
        <form method="post" action="/Settings/Support">
            <div class="row mb-4">
                <label for="object-input"></label>
                <div class="col-md-12">
                    <input type="text" class="form-control inputBackground" name="Subject" id="object-input"
                           placeholder="Objet">
                </div>
            </div>
            <div class="row mb-4">
                <label for="contenu-input"></label>
                <div class="col-md-12">
                    <textarea class="form-control custom-form inputBackground" name="Content" rows="5" id="contenu-input"
                              placeholder="Entrez votre contenu ici..."></textarea>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                <div class="btn-group">
                    <button class="btn btn-custom-green" name="SubmitSupport" value="1" type="submit">Envoyer</button>
                </div>
            </div>
        </form>
