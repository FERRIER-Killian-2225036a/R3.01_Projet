<?php require 'sideBar.php'; ?>

<!-- Inclusion de fichiers CSS -->
<link rel="stylesheet" href="/common_styles/password.css">
<link rel="stylesheet" href="/common_styles/wrongInfo.css">
<link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css">


<!-- Conteneur principal -->
<div class="col container">

    <!-- Section pour la photo de profil -->
    <div class="row mb-2 mt-2" id="rightSide">
        <div class="col-md-6">
            <h1>Votre compte</h1>
            <h2>Photo de profil</h2>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <img id="profile-image"
                 src="<?= (SessionManager::isUserConnected() && $_SESSION['UrlPicture'] !== null) ? $_SESSION['UrlPicture'] : Constants::PDP_URL_DEFAULT; ?>"
                 alt="Photo de profil" class="img-thumbnail w-10 rounded-circle" height="150" width="150">
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end">
            <div class="btn-group">
                <form action="/Settings/ManageAccount" method="POST" enctype="multipart/form-data">
                    <label for="file" class="btn btn-outline-dark mr-2">Modifier</label>
                    <input id="file" type="file" name="ProfilePicture" accept=".jpg, .jpeg, .png, .gif"
                           style="display: none;">
                    <input type="hidden" name="ChangeProfilePicture" value="1">
                </form>
                <button id="cropButton" class="btn btn-outline-primary" style="display: none;">Recadrer</button>
                <button id="confirmButton" class="btn btn-outline-success" style="display: none;">Valider</button>
                <form action="/Settings/ManageAccount" method="POST">
                    <button class="btn btn-outline-danger" name="DeleteProfilePicture" type="submit">Supprimer</button>
                </form>
                <label id="wrongInfo"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div id="imageWrapper">
                    <img id="image" src="" alt="Image de profil">
                </div>
            </div>
            <div class="col-md-6">
                <div id="cropperWrapper">
                    <img id="croppedImage" src="" alt="Image recadrée">
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour le pseudo -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2>Changer votre pseudo</h2>
        </div>
    </div>
    <div class="row mb-4">
        <form action="/Settings/ManageAccount" method="POST" class="lineInputAndButton">
            <label for="username-input"></label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="username" id="username-input" placeholder="NouveauPseudo">
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
                <div class="btn-group">
                    <button class="btn btn-outline-dark" name="ChangeUsername" value="1" type="submit">Modifier</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Section pour l'adresse email -->
    <div class="row mb-2">
        <div class="col-md-6">
            <h2>
                <label for="email-input">
                    Modifier l'adresse mail
                </label>
            </h2>
        </div>
    </div>
    <div class="row mb-4">
        <form action="/Settings/ManageAccount" method="POST" class="lineInputAndButton">
            <div class="col-md-8">
                <input type="email" name="mail" class="form-control" id="email-input" placeholder="votre@email.com">
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
                <div class="btn-group">
                    <button class="btn btn-outline-dark" name="ChangeMail" type="submit">Modifier</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Section pour le mot de passe -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2>Modifier le mot de passe</h2>
            <label for="password-input"></label>
        </div>
    </div>
    <div class="row mb-2">
        <form action="/Settings/ManageAccount" method="POST" class="lineInputAndButton">
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="oldPassword" id="password-input" placeholder="Ancien mot de passe">
                </div>
                <label for="passwordStrength"></label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="passwordStrength" placeholder="********" name="newPassword"
                           onkeyup="checkPasswordStrength(this.value)"/>
                    <span class="input-group-text">
                        <i id="passwordToggle" class="fas fa-eye" style="cursor: pointer;"></i>
                        <i id="passwordToggleOff" class="fas fa-eye-slash" style="cursor: pointer; display: none;"></i>
                    </span>
                </div>
                <label for="confirmPassword"></label>
                <div class="input-group">
                    <input type="password" id="confirmPassword" class="form-control" oninput="checkPasswordsEquality()"
                           placeholder="********"/>
                </div>
                <span id="passwordFeedback"></span>
            </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end">
                <button class="btn btn-custom" name="ChangePassword" type="submit" onclick="updatePassword()">Modifier</button>
            </div>
        </form>
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
<!-- Inclusion du script JavaScript pour la gestion du compte -->
<script src="/common_scripts/manageAccount.js"></script>
<!-- Inclusion de scripts JavaScript -->
<script src="/common_scripts/showErrorMessage.js"></script>
<script src="/common_scripts/checkPassword.js"></script>
<script src="/common_scripts/passwordVisibility.js"></script>
<script src="/common_scripts/cropPicture.js"></script>
<script src="https://kit.fontawesome.com/f8a6cc215e.js" crossorigin="anonymous"></script><!--Pour ajouter des icones -->
<script src="https://unpkg.com/cropperjs/dist/cropper.js"></script>
