<div class="container">
    <div class="text-left mt-4">
        <h1><?php echo $mapView['Title'] ?></h1>
        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center">
                <img src="<?php echo $mapView['ImgProfil'] ?>" alt="image" class="rounded-circle mr-3">
                <div>

                    <form action="  CURRENT URL EN JS STP (avec l'id) " method="post" >
                    <p class="mb-0"><?php echo $mapView['Author'] ?>
                        <button type="submit" name="Follow" class="btn btn-custom-purple">Suivre</button>
                    </p>
                    </form>

                    <small><?php echo $mapView['NumberOfFollower'] ?></small>
                    <a class="btn btn-custom-purple">Suivre</a>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <a href="#" title="Partager">
                    <img src="../../media/public_assets/icone/partager.png" alt="Partager" class="icon">
                </a>
                <form action="  CURRENT URL EN JS STP (avec l'id) " method="post">
                <button name="bookmark" title="Signet" type="submit">
                    <img src="../../media/public_assets/icone/signet.png" alt="Signet" class="icon">
                </button>
                </form>
            </div>
        </div>
        <hr>

        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <img src="<?php echo $mapView['Img'] ?>" class="img-fluid" alt="Image du Blog">
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-8">
                <p>
                    <?php echo $mapView['Content'] ?>
                </p>
            </div>
        </div>
    </div>
</div>
