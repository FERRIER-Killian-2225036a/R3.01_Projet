<head>
    <link rel="stylesheet" href="../../common_styles/authentification.css">
    <link rel="stylesheet" href="../../common_styles/general.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3 p-5 shadow-lg round">
            <h2 class="text-center responsive-title">Mot de passe oublié</h2>
            <br>
            <p class="responsive-text">Entrez l'adresse e-mail associée à votre compte, et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            <form action="/path-to-your-handler" method="POST">
                <!-- Adresse e-mail -->
                <div class="form-group responsive-text">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'adresse mail associée au compte" required>
                </div>
                <!-- Bouton pour valider -->
                <div class="form-group pt-2">
                    <button type="submit" class="btn btn-outline-danger btn-custom-border ">Envoyer le lien de réinitialisation</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
