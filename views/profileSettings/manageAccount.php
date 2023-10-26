<?php require 'sideBar.php'; ?>
<link rel="stylesheet" href="../../common_styles/authentification.css"
<script src="/common_scripts/showErrorMessage.js"></script>
<script src="/common_scripts/checkPassword.js"></script>
<div class="col container">

    <!-- Section pour la photo de profil -->
    <div class="row mb-2 mt-2">
        <div class="col-md-6">
            <h1>Votre compte</h1>
            <h2>Photo de profil</h2>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <img id="profile-image"
                 src="<?= (SessionManager::isUserConnected() && $_SESSION['UrlPicture'] !== null) ? $_SESSION['UrlPicture'] : Constants::PDP_URL_DEFAULT; ?>"
                 alt="Photo de profil" class="img-thumbnail w-10">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->

            <div class="btn-group">
                <form action="/Settings/ManageAccount" method="POST" enctype="multipart/form-data">
                    <label for="file" class="btn btn-outline-dark mr-2">Modifier</label>
                    <input id="file" type="file" name="ProfilePicture" accept=".jpg, .jpeg, .png, .gif"
                           style="display: none;">
                    <input type="hidden" name="ChangeProfilePicture" value="1">
                </form>

                <script> //TODO déplacé le script dans un fichier js
                    // Lorsque le label "Modifier" est cliqué
                    document.querySelector('label[for="file"]').addEventListener('click', function () {
                        // Clique sur l'input de fichier caché pour permettre à l'utilisateur de choisir un fichier
                        document.getElementById('file').click();
                    });

                    // Lorsque le champ de fichier est modifié (un fichier est sélectionné)
                    document.getElementById('file').addEventListener('change', function () {
                        // Soumet automatiquement le formulaire lorsque l'utilisateur sélectionne un fichier
                        this.parentNode.submit(); // Cela enverra le formulaire avec le fichier sélectionné
                    });
                </script>
                <form action="/Settings/ManageAccount" method="POST">
                    <button class="btn btn-outline-danger" name="DeleteProfilePicture" type="submit">Supprimer</button>
                </form>
                <label id="wrongInfo"></label>
            </div>
        </div>
    </div>
    <!-- Section pour le pseudo -->

    <div class="row mb-2">
        <div class="col-md-6">
            <h2>Changer votre pseudo</h2>
        </div>
    </div>
    <div class="row mb-4">
        <form action="/Settings/ManageAccount" method="POST">
            <label for="username-input"></label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="username" id="username-input" placeholder="NouveauPseudo">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->
                <div class="btn-group">
                    <button class="btn btn-outline-dark" name="ChangeUsername" value="1" type="submit">Modifier</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Section pour l'adresse email -->

    <div class="row mb-2">
        <div class="col-md-6">
            <h2>Modifier l'adresse mail</h2>
            <label for="email-input"></label>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="email" class="form-control" id="email-input" placeholder="votre@email.com">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->
            <div class="btn-group">
                <button class="btn btn-outline-dark">Modifier</button>
            </div>
        </div>
    </div>

    <!-- Section pour le mot de passe -->
    <div class="row mb-2">
        <div class="col-md-6">
            <h2>Modifier le mot de passe</h2>
            <label for="password-input"></label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="password-input" placeholder="Ancien mot de passe">
            </div>
            <label for="passwordStrength"></label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="passwordStrength" placeholder="********" name="password"
                       onkeyup="checkPasswordStrength(this.value)"/>
            </div>
            <label for="confirmPassword"></label>
            <div class="input-group">
                <input type="password" id="confirmPassword" class="form-control" oninput="checkPasswordsEquality()"
                       placeholder="********"/>
            </div>
            <span id="passwordFeedback"></span>
        </div>
        <div class="col-md-6 d-flex align-items-end justify-content-start">
            <button class="btn btn-custom" onclick="updatePassword()">Modifier</button>
        </div>
    </div>
    <hr class="hr-custom hr-color">
    <!-- Section pour supprimer le compte -->
    <div class="row mt-4">
        <div class="col-md-6">
            <h2 class="text-danger">Supprimer le compte</h2>
            <p>Attention, cette action est irréversible.</p>
            <button class="btn btn-outline-danger" onclick="deleteAccount()">Supprimer le compte</button>
        </div>
    </div>
</div>
