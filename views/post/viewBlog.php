<div class="container">
    <div class="text-left mt-4">
        <h1><?php echo $mapView['Title'] ?></h1>
        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center">
                <img src="<?php echo $mapView['ImgProfil'] ?>" alt="image" class="rounded-circle mr-3">
                <div>

                    <p class="mb-0"><?php echo $mapView['Author'] ?></p>


                    <small><?php echo $mapView['NumberOfFollower'] ?></small>
                </div>
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post" >
                <button class="btn btn-custom-purple" name="follow" type="submit">Suivre</button>
                </form>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <a href="#" title="Partager">
                    <img src="../../media/public_assets/icone/partager.png" alt="Partager" class="icon">
                </a>
                <form action="<?php echo $mapView["CurentUrlPost"]?>" method="post" id="formSignet">
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
