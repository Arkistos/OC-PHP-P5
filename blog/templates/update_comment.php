<form action="index.php?action=updateComment&id=<?= $comment->identifier ?>" method="post">
   <div>
  	<label for="author">Auteur</label><br />
  	<input type="text" id="author" name="author" value="<?=$comment->author?>"/>
   </div>
   <div>
  	<label for="comment">Commentaire</label><br />
  	<textarea id="comment" name="comment"><?=$comment->comment?></textarea>
   </div>
   <div>
  	<input type="submit" />
   </div>
</form>