<?php ob_start(); ?>
    
    <div class="my-5">

        <h1 class="primary_h1 mb-5">Ajouter un nouveau membre</h1>
        <h3 class="primary_h3 mb-5">Ajouter un nouveau membre à l'espace extranet</h3>

        <form method="POST" action="index.php?action=addmember">

            <div>
                <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" minlength="3" maxlength="25" required>
            </div>

            <div>
                <input type="password" name="password" id="password" placeholder="Mot de passe">
            </div>

            <div id="button_login">
                <button class="btn btn-success" type="submit">Ajouter</button>
            </div> 
        </form>
    </div>
    
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>