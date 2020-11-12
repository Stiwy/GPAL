<?php
if (session_status() == PHP_SESSION_NONE){session_start();} 
require_once 'AdminGPALManager.php';
if ($_POST){
    $adminGPALManager = new AdminGPALManager();
    $adminGPALManager->registerMember($_POST['username'], $_POST['password'], $_POST['password_confirm']);
}?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajouter un membre</title>
	
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
	<div id="header">
        <div id="center_block">
            <img id="logo_robe_medical" src="public/image/logo_robe_medical.png">
            <div id="text_header">
                <div>
                    <span style="color:#f2771a;">Votre partenaire de la santé depuis 1887</span>
                </div>  
            </div>
        </div>
        <div id="blue_banner">
            <div id="blue_banner_div">
            </div>
        </div>
    </div>
    <section id="add_memeber_section">
    	<div class="add_member_div">
            <?php include 'incFlashMessage.php'; ?>
    		<h1>Ajouter un membre</h1>
    		<p>Ajouter un utilisateur, pour l'application de gestion des palettes</p>
    	</div>

    	<form id="form_add_member" action="" method="POST"><br/>
    		<div class="add_member_block">
    			<label>Identifiant :</label><br> 
    			<input type="text" name="username" id="username" placeholder="Saisir l'identifiant">
    		</div>
			<div class="add_member_block">
    			<label>Mot de passe :</label><br/>
    			<input type="password" name="password" id="password" placeholder="Saisir le mot de passe">
    		</div>
			<div class="add_member_block">
    			<label>Confirmer le mot de passe :</label><br/>
    			<input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmer le mot de passe">
    		</div>
			<input type="submit" id="button_add_member" value="Enregister">
    	</form>
    </section>
</body>
</html>