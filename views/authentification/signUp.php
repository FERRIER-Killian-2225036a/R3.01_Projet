<link rel="stylesheet" href="../../common_styles/authentification.css">
<link rel="stylesheet" href="/common_styles/password.css">
<link rel="stylesheet" href="/common_styles/wrongInfo.css">
<script src="/common_scripts/showErrorMessage.js"></script>
<script src="/common_scripts/checkPassword.js"></script>
<script src="/common_scripts/passwordVisibility.js"></script>
<!-- Section principale avec un dégradé de fond -->
<section class="h-100 gradient-form">
    <div class="container py-2">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card round text-black">
                    <div class="row g-0">
                        <!-- Colonne de gauche (Zone d'inscription) -->
                        <div class="col-lg-6" id="leftSide">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="../../media/public_assets/CyphubLogo.png" id="topImg" alt="Logo Cyphub">
                                    <h4 class="mt-1 mb-5 pb-1">Bienvenue chez Cyphub !</h4>
                                </div>

                                <!-- Formulaire d'inscription -->
                                <form action="/Auth/SignUp" method="post" name="SignUp">
                                    <!-- Champ de saisie pour le pseudo -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Pseudo
                                            <input type="text" class="form-control" placeholder="krokmou" name="pseudo" />
                                        </label>
                                    </div>

                                    <!-- Champ de saisie pour l'adresse e-mail -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Adresse mail
                                            <input type="email" class="form-control" placeholder="krokmou@exemple.fr" name="mail" />
                                        </label>
                                    </div>



                                    <!-- Champ de saisie pour le mot de passe avec vérification de la force du mot de passe -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Mot de passe
                                            <div class="input-group">
                                                <input type="password" id="form2Example22" class="form-control" placeholder="********" name="password" onkeyup="checkPasswordStrength(this.value)"/>
                                                <span class="input-group-text">
                                                    <i id="passwordToggle" class="fas fa-eye" style="cursor: pointer;"></i>
                                                    <i id="passwordToggleOff" class="fas fa-eye-slash" style="cursor: pointer; display: none;"></i>
                                                </span>
                                            </div>
                                        </label>
                                        <!-- Zone d'affichage des messages d'erreur -->
                                        <label id="wrongInfo"></label>
                                    </div>


                                    <!-- Champ de saisie pour confirmer le mot de passe avec vérification de l'égalité -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Confirmer votre mot de passe
                                            <div class="input-group">
                                                <input type="password" id="confirmPassword" class="form-control" oninput="checkPasswordsEquality()" placeholder="********" />
                                                <span class="input-group-text">
                                                    <i id="passwordToggle" class="fas fa-eye" style="cursor: pointer;"></i>
                                                    <i id="passwordToggleOff" class="fas fa-eye-slash" style="cursor: pointer; display: none;"></i>
                                                </span>
                                            </div>
                                        </label>
                                        <br>
                                        <span id="passwordFeedback"></span>
                                        <!-- Zone d'affichage des messages d'erreur -->
                                        <label id="wrongInfo"></label>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <!-- Bouton pour soumettre le formulaire d'inscription -->
                                        <button class="btn btn-primary btn-block fa-lg mb-3" id="signUpButton" type="submit">S'inscrire</button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Tu as déjà un compte ?</p>
                                        <!-- Lien vers la page de connexion -->
                                        <a href="/Auth/Login" type="button" class="btn btn-custom-purple">Connecte-toi</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Colonne de droite (Zone d'image) -->
                        <div class="col-lg-6 d-flex align-items-center removeRs" id="rightSide">
                            <div class="align-item-center px-3 py-4 p-md-5 mx-md-4">
                                <img src="../../media/public_assets/CyphubLogo.png" id="bottomImg" alt="Logo Cyphub">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
