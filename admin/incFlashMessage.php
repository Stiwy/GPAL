<?php if(isset($_SESSION['error'])):?>
    <div id="bannerErrorMessage">
        <ul>
            <?php foreach($_SESSION['error'] as $type => $message):?>
                <li><?= $message ?></li>
            <?php endforeach; ?>
            <?php unset($_SESSION['error']); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])):?>
    <div id="bannerSuccessMessage">
        <ul>
            <?php foreach($_SESSION['success'] as $type => $message):?>
                <li><?= $message ?></li>
            <?php endforeach; ?>
            <?php unset($_SESSION['success']); ?>
        </ul>
    </div>
<?php endif; ?>