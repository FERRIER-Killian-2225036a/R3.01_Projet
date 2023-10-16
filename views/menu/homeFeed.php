<head>
    <link rel="stylesheet" href="../common_styles/homeFeedStyle.css">
</head>
<body>

<section class = "background">
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark" aria-pressed="true">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
        </ul>
    </div>
    <main>

        <section class="paddingP1 text-left container">
            <div class="col-lg-6 col-md-8 mx-left">
                <h1 class="homeTitle">Bienvenue chez Cyphub !</h1>
                <p class="colorText lead text-body-secondary">Ici est le début de la page home avec juste une phrase qui finira par être modifier </p>
                <p>
                <div class="col-lg-8 col-md-8 mx-left">
                    <a href="#" class="cta colorText noneColor text-left block">
                        <span class="visual">Se connecter</span>
                        <svg class="svg1" width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="cta colorText noneColor text-left block ">
                        <span class="visual">Créer un compte</span>
                        <svg class="svg1" width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </a>
                </div>
                </p>
            </div>
            <img src="/media/public_assets/homePicture.png" alt="Logo Cyphub" width="37" height="37">
            </div>
        </section>
</section>



<section class="py-3 text-center container ">
    <div class="py-lg-5">
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-4 shadow-gn background">
                    <a href="./../ActualityFeed/" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button">
                        <img class="sizeRs" src="../../media/public_assets/iconeTech.png"alt="Icone Veille Tehcnologique " height="150" width="150">
                        <p class="colorText">Veille Technologique</p></a>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-4 shadow-gn background">
                    <a href="blogFeed.php" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button">
                        <img class="sizeRs" src="../../media/public_assets/iconeBlog.png"alt="Icone Blog" height="150" width="150">
                        <p class="colorText">Blog</p></a>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-4 shadow-gn background">
                    <a href="forumFeed.php" type="button" class="w-20 rounded-4 btn btn-lg text-center colorButton shadow-gn grow-button">
                        <img class="sizeRs" src="../../media/public_assets/iconeForum.png"alt="Icone Forum" height="150" width="150">
                        <p class="colorText">Forum</p></a>
                </div>
            </div>
        </div>
    </div>
</section>