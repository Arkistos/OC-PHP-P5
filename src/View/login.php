<?php $title = 'Login'; ?>

<?php ob_start(); ?>

<form action="index.php?action=login" method="post">
    <label for="email">Email</label>
    <input type="text" id='email' name='email' />

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" />
    <input type="submit" />
</form>

<?= isset($message) ? $message : ''; ?>

<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>