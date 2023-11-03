<!doctype html>
<html lang="fr">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cyphub</title>
        <link rel="stylesheet" href="/common_styles/header.css">
        <link rel="stylesheet" href="/common_styles/main.css">
        <link rel="stylesheet" href="/common_styles/bouee.css">
        <link rel="stylesheet" href="/common_styles/general.css">
        <link rel="icon" href="/media/public_assets/favicon.png">
    </head>
    <body>
        <?php
            MotorView::show('common/header');
            MotorView::show('common/help');
            echo $mapView['body'];
            MotorView::show('common/footer');
            require 'common_scripts/general_scripts.php';
        ?>
        <script src="/common_scripts/maxTextSize.js"></script>
    </body>
</html>
