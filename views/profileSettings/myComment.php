<?php require 'sideBar.php'; ?> <!-- Inclusion de la barre latérale -->

<div class="col container">
    <!-- Section pour le titre -->
    <div class="row mb-2 mt-2" id="rightSide">
        <div class="col-md-7">
            <h1>Vos Commentaires </h1> <!-- Titre de la section -->
        </div>
        <!-- Section pour le champs de recherche -->
        <div class="col-md-5 d-flex align-items-end">
            <label><input class="form-control" type="text" name="query" placeholder="Rechercher..."></label> <!-- Champ de recherche -->
        </div>
        <hr class="my-3"> <!-- Ligne de séparation -->
    </div>

    <!-- Section pour la table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th> <!-- En-tête de colonne -->
            <th scope="col">Titre</th>
            <!--<th scope="col">Status</th>-->
            <th scope="col">Dates</th>
        </tr>
        </thead>
        <tbody>
        <!-- Lignes de données -->
        <?php

        foreach ($mapView["ArrayOfComment"] as $comment) {
            echo '<tr>';
            echo '<th scope="row">' . $comment->getCommentId() . '</th>';
            echo '<td><a href="'. "/Post/Blog/".$comment->getPageId().'">' . $comment->getTextC() . '</a></td>';
            //echo '<td>' . $comment->getStatut() . '</td>';
            echo '<td>' . $comment->getDateC() . '</td>';
            //TODO ajouter les boutons pour modifier et supprimer svp a géré apres ligne 23 
            echo '</tr>';

        }

        ?>
        <!-- <tr>
            <th scope="row">1</th>
            <td>CHAPI CHAPO QUESTION ( blablabla les premières lignes ) <-- Contenu de la cellule - ->
                <br><small> -> vous à vous bonjour</small></td>
            <-- <td>Nouveau</td> - ->
            <td>2022-03-17</td>
        </tr> -->
        </tbody>
    </table>
</div>