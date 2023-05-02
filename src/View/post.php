<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Le blog de l'AVBN</title>
	<link href="style.css" rel="stylesheet" />
</head>

<body>
	<h1>Le super blog de l'AVBN !</h1>
	<p><a href="index.php">Retour à la liste des billets</a></p>

	<div class="news">
		<h3>
			<?= htmlspecialchars($post->getTitle()); ?>
			<em>le <?= $post->getUpdatedAt(); ?></em>
		</h3>

		<p>
			<?= nl2br(htmlspecialchars($post->getContent())); ?>
		</p>
	</div>

	<h2>Commentaires</h2>

	<form action="index.php?action=addComment&id=<?= $post->getId(); ?>" method="post">
		<div>
			<label for="author">Auteur</label><br />
			<input type="text" id="author" name="author" />
		</div>
		<div>
			<label for="comment">Commentaire</label><br />
			<textarea id="comment" name="comment"></textarea>
		</div>
		<div>
			<input type="submit" />
		</div>
	</form>

	<?php
        foreach ($comments as $comment) {
            ?>
	<p><strong><?= htmlspecialchars($comment->getUserId()); ?></strong> le <?= $comment->getCreatedAt(); ?>
		<a href="index.php?action=updateComment&id=<?= $comment->getId(); ?>">Modifier</a>
	</p>
	<p><?= nl2br(htmlspecialchars($comment->getContent())); ?></p>
	<?php
        }
			?>
</body>

</html>