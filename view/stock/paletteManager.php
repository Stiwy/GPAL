<?php 
$title = 'Gestion des pallettes';
$count = 0;
 ob_start(); 
        while($data = $getPalette->fetch()): ?>
            <tr id="line_table_palette" class="palette_result " onclick="getPalette(<?=$data['id']?>)">
                <td><?= $data['reference'] ?></td>
                <td>A<?= $data['weg'] ?> | R<?= $data['shelf'] ?></td>
                <td><?= $data['quantity'] ?></td>
            </tr>
        <?php 
            $count++;
            endwhile;
        ?>
<?php $palette_list = ob_get_clean(); ?>

<?php ob_start(); ?>

<button id="add_palette" class="add_palette" onclick="buttonAdd()">Nouvelle palette</button>

<section id="palette_section">
    <p class="pm_title_section">Liste des palettes</p>

    <div id="palette_banner">
        <div id="headerpalettePage">
            <?php if($count === 0){echo '<p></p>Aucun résultat trouvé</p>';}else {echo "<p class='headerpaletteText'> $count résultat(s) trouvé(s)</p>";}?>
        </div>
    </div>

    <table id="table_list_palette">
        <thead>
            <tr id="tr_table">
                <th>Ref</th>
                <th>Emplacement</th>
                <th>Qte produits</th>
            </tr>
        </thead>
        <tbody>
            <?= $palette_list; ?>
        </tbody>
    </table>
	
	<a class="guid_link" href="http://bor.santedistri.com/gpal/guide.pdf">Accerder au guide d'utilisation</a>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>