<?php
$title = 'Gestion des pallettes';
ob_start(); ?>
<button id="return_button" onclick="indexAdd()">Retour à l'accueil</button>
<section id="add_palette_section">
    <div class="add_palette_div">
        <h1>Ajouter une palette</h1>

        <p>Completer l'ensemble champs ci-dessous pour ajouter une nouvelle palette</p>
    </div>

    <form id="form_add_palette" action="index.php?action=addpalette&amp;reference=<?=$reference?>" method="POST">
        <div id="group_reference" class="add_palette_block">
            <label for="reference">Référence de la palette</label><br/>
            <input type="text" name="reference" id="reference" value="<?=$reference?>" readonly >
        </div>
        <div id="group_location" class="add_palette_block">
            <label for="location">Ajouter l'emplacement</label><br>
            <select name="weg" id="weg" class="weg" onclick="getValueSelctWeg()">
                <option>A1</option>
                <option>A2</option>
                <option>A3</option>
                <option>A4</option>
                <option>A5</option>
                <option>A6</option>
                <option>A7</option>
                <option>A8</option>
                <option>A9</option>
                <option>A10</option>
                <option>A11</option>
                <option>A12</option>
                <option>A13</option>
                <option>A14</option>
            </select>
            <select name="shelf" id="shelf" class="shelf" onclick="getValueSelctWeg()">
                <option>R1</option>
                <option>R2</option>
                <option>R3</option>
                <option>R4</option>
                <option>R5</option>
                <option>R6</option>
                <option>R7</option>
                <option>R8</option>
                <option>R9</option>
                <option>R10</option>
                <option>R11</option>
                <option>R12</option>
                <option>R13</option>
                <option>R14</option>
                <option>R15</option>
                <option>R16</option>
                <option>R17</option>
                <option>R18</option>
                <option>R19</option>
                <option>R20</option>
                <option>R21</option>
                <option>R22</option>
                <option id="r23">R23</option>
                <option id="r24">R24</option>
            </select>
        </div>
        <div id="group_quantity" class="add_palette_block">
            <label for="quanity">Ajouter la quantitée de produits</label><br/>
            <input type="number" inputmode="numeric" name="quantity" id="quantity" placeholder="Saisissez la quantitée">
        </div>
        <input type="submit" value="Enregister" id="button_add_palette">
    </form>
</section>
<?php $content = ob_get_clean(); ?>

<?php require 'view/template.php'; ?>