<?php $title = "Le blog de l'AVBN"; ?>

<?php ob_start(); ?>

<h1>Le super blog de l'AVBN !</h1>
<p>Derniers billets du blog :</p>

<?php
foreach ($posts as $post) {
    ?>
<div class="news">
	<h3>
		<?= htmlspecialchars($post->getContent()); ?>
		<em>le <?= $post->getUpdatedAt(); ?></em>
	</h3>
	<p>
		<?= nl2br(htmlspecialchars($post->getContent())); ?>
		<br />
		<em><a href="?id=<?= urlencode($post->getId()); ?>&action=post">Commentaires</a></em>
	</p>
</div>
<?php
} // The end of the posts loop.
?>

<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>