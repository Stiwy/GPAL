<?php
$title = 'Gestion des pallettes';
ob_start(); ?>
<button id="return_button" onclick="indexAdd()">Retour à l'accueil</button>
<div>
    <h2>La référence saisie n'as pas été trouvé dans la base de donnée, souhaitez-vous l'ajouter ?</h2>

    <form action="" method="POST">
        <input type="submit" name="confirm" id="confirm" value ="Confirmer">
    </form>

    <a href="http://localhost/gpal/index.php">Retour</a>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>