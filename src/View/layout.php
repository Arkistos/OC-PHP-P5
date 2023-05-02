<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8" />
   <title><?= $title; ?></title>
   <link href="style.css" rel="stylesheet" />
</head>

<body>
   <?php if($_SESSION['logged']) : ?>
   <a href="/index.php?action=logout">logout</a>
   <?php else: ?>
   <a href="/index.php?action=login">login</a>
   <?php endif; ?>
   <?= $content; ?>
</body>

</html>