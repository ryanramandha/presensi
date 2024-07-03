<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger" role="alert">
        <?= implode("<br>", $errors) ?>
    </div>
<?php endif ?>