<link rel="stylesheet" href="../../common_styles/authentification.css">
<link rel="stylesheet" href="../../common_styles/general.css">
<div class="container mt-5">
    <div class="row">
        <!-- Section de contenu centrée -->
        <div class="col-md-6 offset-md-3 p-5 shadow-lg round">
            <!-- Titre principal -->
            <h1 class="text-center responsive-title">Mot de passe oublié</h1>
            <!-- Description du formulaire -->
            <p class="responsive-text">Entrez l'adresse e-mail associée à votre compte, et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            <!-- Formulaire pour la réinitialisation de mot de passe -->
            <form action="/path-to-your-handler" method="POST">
                <!-- Groupe de formulaire pour l'adresse e-mail -->
                <div class="form-group responsive-text">
                    <!-- Étiquette pour le champ de saisie -->
                    <label for="email">Adresse e-mail</label>
                    <!-- Champ de saisie de l'adresse e-mail -->
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'adresse mail associée au compte" required>
                </div>
                <!-- Bouton pour soumettre le formulaire -->
                <div class="form-group pt-2">
                    <button type="submit" class="btn btn-outline-danger btn-custom-border">Envoyer le lien de réinitialisation</button>
                </div>
            </form>
        </div>
    </div>
</div>
