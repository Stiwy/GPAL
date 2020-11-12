<?php $title = 'Robé Médical | Se connecter'; ?>

<?php ob_start(); ?>
<div id="login">
    <h1>Se connecter</h1>
    <p>Espace de gestion des stock</p>

    <form action="index.php?action=login" method="POST">
        <div id="warehousemanUsernameBlock" class="loginBlock">
            <label for="warehousemanUsername">Votre identifiant : </label>
            <input type="text" name="warehousemanUsername" id="warehousemanUsername" placeholder="Saisissez votre identifiant" require>
        </div>
        <div id="warehousemanPasswordBlock" class="loginBlock">
            <label for="warehousemanPassword">Votre mot de passe : </label>
            <input type="password" name="warehousemanUsername" id="warehousemanUsername" placeholder="Saisissez votre mot de passe" require>
        </div>

        <input id="button_login" type="submit" value="Se connecter">
    </form>
</div>

    
    <!-- <a href="index.php?action=addmember">register (dev)</a> -->
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>