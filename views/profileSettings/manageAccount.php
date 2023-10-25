<?php require 'sideBar.php'; ?>
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
                    <img id="profile-image" src="../../media/public_assets/favicon.png" alt="Photo de profil" class="img-thumbnail w-10">
                </div>
                <div class="col-md-6 d-flex align-items-center"> <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->

                    <div class="btn-group">
                        <form action="/Settings/ManageAccount" method="POST" enctype="multipart/form-data">

                            <input id="file" class="hiddenInput" type="file" name="ProfilePicture"  accept=".jpg, .jpeg, .png, .gif">
                            <button class="btn btn-outline-dark mr-2" name="ChangeProfilePicture" type="submit">Modifier</button>
                            <!--
                            <label for="fileInput">Modifier</label> (moche)
                            <input type="file" name="ProfilePicture" id="fileInput">
                            <input type="submit" name="ChangeProfilePicture" value="Envoyer">
                            -->
                        </form>
                        <script>
                            // Lorsque le bouton "Modifier" est cliqué
                            document.querySelector('.btn[name="ChangeProfilePicture"]').addEventListener('click', function (event) { //TODO a mettre dans un fichier js
                                // Empêche le comportement par défaut du bouton
                                event.preventDefault();
                                // Clique sur l'input de fichier caché pour validé l'envoi du fichier
                                document.getElementById('file').click();
                            });
                        </script>
                        <button class="btn btn-outline-danger" type="submit">Supprimer</button>
                    </div>
                </div>
            </div>
            <!-- Section pour le pseudo -->

            <div class="row mb-2">
                <div class="col-md-6">
                    <h2>Pseudo</h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="username-input" value="VotrePseudo">
                </div>
                <div class="col-md-6 d-flex align-items-center"> <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->
                    <div class="btn-group">
                        <button class="btn btn-outline-dark" onclick="updateUsername()">Modifier</button>
                    </div>
                </div>
            </div>

            <!-- Section pour l'adresse email -->

            <div class="row mb-2">
                <div class="col-md-6">
                    <h2>Modifier l'adresse mail</h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="email" class="form-control" id="email-input" value="votre@email.com">
                </div>
                <div class="col-md-6 d-flex align-items-center"> <!-- Notez ici que nous utilisons align-items-center pour centrer les boutons verticalement -->
                    <div class="btn-group">
                        <button class="btn btn-outline-dark" onclick="updateEmail()">Modifier</button>
                    </div>
                </div>
            </div>
            <!-- Section pour le mot de passe -->

            <div class="row mb-2">
                <div class="col-md-12">
                    <h2>Modifier le mot de passe</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password-input" placeholder="Ancien mot de passe">
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="new-password-input" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm-new-password-input" placeholder="Confirmer le nouveau mot de passe">
                    </div>
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
