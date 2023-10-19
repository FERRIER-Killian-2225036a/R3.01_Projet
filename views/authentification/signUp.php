<head xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href="../../common_styles/general.css">
    <link rel="stylesheet" href="../../common_styles/authentification.css">
    <script src="../../common_scripts/"></script>

</head>
<body>
<section class="h-100 gradient-form">
    <div class="container py-2 ">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card round text-black">
                    <div class="row g-0">
                        <div class="col-lg-6" id="leftSide">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="../../media/public_assets/CyphubLogo.png" id="topImg" alt="Logo Cyphub">
                                    <h4 class="mt-1 mb-5 pb-1">Bienvenue chez Cyphub !</h4>
                                </div>

                                <form action="/Auth/SignUp" method="post" name="SignUp">
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Pseudo</label>
                                        <input type="text" class="form-control" placeholder="krokmou" name="pseudo" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Adresse mail</label>
                                        <input type="email" class="form-control" placeholder="krokmou@exemple.fr" name = "mail"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Mot de passe</label>
                                        <input type="password" class="form-control" id="passwordStrength password" placeholder="********" name="password" onkeyup="checkPasswordStrength(this.value)" />
                                    </div>
                                    <!-- TO DO VERIFIER COTE CLIENT SI MDP 1 == MDP 2 avant  d'envoyer -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Comfirmer votre mot de passe</label>
                                        <input type="password" id="confirmPassword" class="form-control" oninput="checkPasswordsEquality()" placeholder="********"/>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg mb-3" id="signUpButton" type="submit">S'inscire</button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Tu as déjà un compte ?</p>
                                        <a href="/Auth/Login" type="button" class="btn btn-outline-danger">Connecte toi</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center removeRs" id="rightSide">
                            <div class="align-item-center px-3 py-4 p-md-5 mx-md-4" >
                                <img src="../../media/public_assets/CyphubLogo.png" id="bottomImg" alt="Logo Cyphub">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../common_scripts/checkPasswordStrength.js"></script>
</section>
</body>