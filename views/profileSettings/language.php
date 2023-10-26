<?php require "sideBar.php"; ?>
<body>
<div class="col-md-6">
    <h1 class="responsive-title">Choix du language</h1>
    <br>
        <div class="col"> <!-- Ajout de la classe 'col-md-8' -->
            <p class="responsive-text">Langue actuellement sélectionnée : </p>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Langue
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Français</a>
                    <a class="dropdown-item" href="#">Anglais</a>
                </div>

            </div>
        </div>
</div>
</body>