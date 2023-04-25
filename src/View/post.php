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
			<?= htmlspecialchars($post->title); ?>
			<em>le <?= $post->updatedAt; ?></em>
		</h3>

		<p>
			<?= nl2br(htmlspecialchars($post->content)); ?>
		</p>
	</div>

	<h2>Commentaires</h2>

	<form action="index.php?action=addComment&id=<?= $post->id; ?>" method="post">
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
	<p><strong><?= htmlspecialchars($comment->user_id); ?></strong> le <?= $comment->createdAt; ?>
		<a href="index.php?action=updateComment&id=<?= $comment->id; ?>">Modifier</a>
	</p>
	<p><?= nl2br(htmlspecialchars($comment->content)); ?></p>
	<?php
        }
			?>
</body>

</html>