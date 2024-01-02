<?php $title = "Erreur"; ?>

<?php ob_start(); ?>
<h1><?= $errorMessage ?></h1>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php');