<link rel="stylesheet" href="/common_styles/authentification.css">
<link rel="stylesheet" href="/common_styles/wrongInfo.css">
<script src="/common_scripts/showErrorMessage.js"></script>
<!-- Section principale avec un dégradé de fond -->
<!-- Section principale avec un dégradé de fond -->
<section class="h-100 gradient-form">
    <div class="container py-2">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card round text-black">
                    <div class="row g-0">
                        <!-- Colonne de gauche (Zone de connexion) -->
                        <div class="col-lg-6" id="leftSide">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="../../media/public_assets/CyphubLogo.png" id="topImg" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">Connexion Cyphub</h4>
                                </div>

                                <!-- Formulaire de connexion -->
                                <form action="/Auth/Login" method="post" name="login">
                                    <!-- Champ de saisie pour l'adresse e-mail -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Adresse mail
                                            <input type="email" id="form2Example11" class="form-control"
                                                   placeholder="krokmou@exemple.fr" name="mail"/>
                                        </label>
                                    </div>

                                    <!-- Champ de saisie pour le mot de passe -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Mot de passe
                                            <input type="password" id="form2Example22" class="form-control"
                                                   placeholder="********" name="password"/>
                                        </label>
                                        <i id="passwordToggle" class="fas fa-eye" style="position: absolute; top: 50%; right: 10px; cursor: pointer;"></i>
                                        <!-- Zone d'affichage des messages d'erreur -->
                                        <label id="wrongInfo"></label>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <!-- Lien vers la réinitialisation du mot de passe -->
                                        <a id="forgotPasswordSize" href="forgotPassword.php">Mot de passe oublié ?</a>
                                        <br>
                                        <!-- Bouton pour soumettre le formulaire de connexion -->
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                id="signUpButton" type="submit">Se connecter
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Tu n'as pas de compte?</p>
                                        <!-- Lien vers la page d'inscription -->
                                        <a href="/Auth/SignUp" type="button" class="btn btn-custom-purple">Inscris-toi</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Colonne de droite (Zone d'image) -->
                        <div class="col-lg-6 d-flex align-items-center removeRs" id="rightSide">
                            <div class="align-item-center px-3 py-4 p-md-5 mx-md-4">
                                <img src="../../media/public_assets/CyphubLogo.png" id="bottomImg" alt="logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
