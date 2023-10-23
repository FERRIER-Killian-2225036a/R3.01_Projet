<body>
<main class="container">
    <div class="p-3">
        <a class="btn bg-body-tertiary round background grow-button" role="button" href="<?php echo $mapView['actualityLien'] ?>">
            <img src="<?php echo $mapView['actualityUrlPicture'] ?>" alt="Logo" class="responsive-image round p-1">
            <div class="text-content">

                <h1 class="responsiveTitle"><?php echo $mapView['actualityTitle']; ?></h1>
                <p class="lead responsiveText"> Catégorie - <?php echo $mapView['actualityDate']; ?> - <?php echo $mapView['actualityAuthor']; ?> </p> <!-- TODO : catégorie -->
                <p class="responsiveText"><?php echo $mapView['actualityContent']; ?></p>

            </div>
        </a>
    </div>
</main>

<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>