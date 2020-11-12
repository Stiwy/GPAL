<?php
$title = 'Gestion des pallettes';
ob_start(); ?>
<button id="return_button" onclick="indexAdd()">Retour à l'accueil</button>
<section id="add_palette_section">
    <div class="add_palette_div">
        <h1>Ajouter une palette</h1>

        <p>Pour ajouter une palette au stock veuillez d'abord saisir sa référence</p>
    </div>

    <form id="form_add_palette" action="index.php?action=addpalette" method="POST">
        <div id="group_reference" class="add_palette_block">
            <label for="checkReference">Saisir la réference</label><br/>
            <input type="text" name="checkReference" id="checkReference" placeholder="Saisissez la réference" required>
        </div>
        <input type="submit" value="Enregister" id="button_add_palette">
    </form>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>