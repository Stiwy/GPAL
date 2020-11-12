
<?php 
$title = 'Gestion des pallettes';
ob_start(); ?>
    <button id="return_button" onclick="indexAdd()">Retour à l'accueil</button>
    <h1 class="notFoundH1">Erreur 404</h1><br>
    <h2 class="notFoundH2"><?= $notFound->getMessage();?></h2>

<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>