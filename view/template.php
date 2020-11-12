<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <link rel="shortcut icon" type="image/png" href="public/image/palette.png"/>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="public/css/addPalette.css">
    <link rel="stylesheet" type="text/css" href="public/css/getPaletteById.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <link rel="stylesheet" type="text/css" href="public/css/paletteManager.css">
    <link rel="stylesheet" type="text/css" href="public/css/template.css">
</head>
<body>

    <!-- Header -->
    <div id="header">
        <div id="blue_banner_div">
            <?php if(isset($_SESSION['warehouseman'])):?>
                <form id="searchBlock" method="POST" action="index.php?action=searchpalette">
                    <input id="shearchRefs" type="search" name="shearchRefs" placeholder="Saisissez la référence produits">
                    <input type="submit" value="Chercher" id="searchButton">
                </form>
            <?php
                else:
                endif;
            ?>
        </div>
    </div>
        
    <?php include 'include/incFlashMessage.php'; ?>
    <!-- Header -->

    <?= $content ?>

    <!-- JS -->
    
    <script type="text/javascript" src="public/js/stock.js"></script>
</body>
</html>