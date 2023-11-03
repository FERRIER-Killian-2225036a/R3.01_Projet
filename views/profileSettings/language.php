<?php require "sideBar.php"; ?>

<!-- Début du corps du document -->
<body>
<!-- Conteneur principal pour la partie droite de la page -->
<div class="col-md-6" id="rightSide">
    <!-- Titre de la section -->
    <h1 class="responsive-title">Choix du langage</h1>
    <br>
    <!-- Conteneur pour le choix de la langue -->
    <div class="col"> <!-- Ajout de la classe 'col-md-8' -->
        <!-- Texte indiquant la langue actuellement sélectionnée -->
        <p class="responsive-text">Langue actuellement sélectionnée : </p>
        <!-- Menu déroulant pour le choix de la langue -->
        <div class="dropdown">
            <!-- Bouton déclenchant le menu déroulant -->
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Langue
            </button>
            <!-- Contenu du menu déroulant -->
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- Options de langue (exemple : Français) -->
                <a class="dropdown-item" href="#">Français</a>
                <a class="dropdown-item" href="#">Anglais</a>
            </div>
        </div>
    </div>
</div>
</body>
<!-- Fin du corps du document -->
