<body>

<div class="modal fade" id="passwordModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header de la modale -->
            <div class="modal-header">
                <h4 class="modal-title">Mot de passe oublié</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Corps de la modale -->
            <div class="modal-body">
                <p>Entrez l'adresse e-mail associée à votre compte, et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
                <form action="/path-to-your-handler" method="POST">
                    <!-- Adresse e-mail -->
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Bouton pour valider -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>
                    </div>
                </form>
            </div>

            <!-- Footer de la modale -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>
</body>
