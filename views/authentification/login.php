<head>
    <link rel="stylesheet" href="../../common_styles/general.css">
    <link rel="stylesheet" href="../../common_styles/authentification.css">
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
                                    <img src="../../media/public_assets/CyphubLogo.png" id="topImg" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">Connexion Cyphub</h4>
                                </div>



                                <form action="/Auth/Login" method="post" name="login">
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Adresse mail
                                            <input type="email" id="form2Example11" class="form-control" placeholder="krokmou@exemple.fr" name="mail"/>
                                        </label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Mot de passe
                                            <input type="password" id="form2Example22" class="form-control" placeholder="********" name="password"/>
                                        </label>
                                        <label id="wrongInfo">L'identifiant ou le mot de passe est incorrecte</label>
                                    </div>



                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <a id="forgotPasswordSize" href="#!">Mot de passe oublié ?</a>
                                        <br>
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" id="signUpButton" type="submit" >Se connecter</button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Tu n'as pas de compte?</p>
                                        <a href="/Auth/SignUp" type="button" class="btn btn-outline-danger">Inscrit toi</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center removeRs" id="rightSide">
                            <div class="align-item-center px-3 py-4 p-md-5 mx-md-4">
                                <img src="../../media/public_assets/CyphubLogo.png"  id="bottomImg" alt="logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../common_scripts/showErrorMessage.js"></script>
    <?php echo var_dump($mapView['script'])?>
</section>
</body>