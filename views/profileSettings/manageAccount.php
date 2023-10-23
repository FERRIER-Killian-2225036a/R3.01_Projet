<head>
    <link rel="stylesheet" href="../../common_styles/manageAccount.css">
</head>
<body>
<div class="container-fluid ">
    <div class="row">
        <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary sidebar-padding" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-4">Sidebar</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                        Products
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                        Customers
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="col container">

            <!-- Section pour la photo de profil -->
            <div class="row mb-2">
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
                        <button class="btn btn-primary mr-2" onclick="updateImage()">Modifier</button>
                        <button class="btn btn-danger" onclick="deleteImage()">Supprimer</button>
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
                        <button class="btn btn-success" onclick="updateUsername()">Modifier</button>
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
                        <button class="btn btn-success" onclick="updateEmail()">Modifier</button>
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
                    <button class="btn btn-success" onclick="updatePassword()">Modifier</button>
                </div>
            </div>


            <!-- Section pour supprimer le compte -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h2 class="text-danger">Supprimer le compte</h2>
                    <p>Attention, cette action est irréversible.</p>
                    <button class="btn btn-danger" onclick="deleteAccount()">Supprimer le compte</button>
                </div>
            </div>


        </div>

    </div>
</div>
</body>
