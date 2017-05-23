<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="style.css" rel="stylesheet" />
    <title>Blog de Jean Forteroche - Home</title>
</head>
<body>
<header>
    <h1>Billet simple pour l'Alaska</h1>
</header>
<?php foreach ($articles as $article): ?>
    <article>
        <h2><?php echo $article->getTitle() ?></h2>
        <p><?php echo $article->getContent() ?></p>
    </article>
<?php endforeach; ?>
<footer class="footer">Billet simple pour l'Alaska.</footer>
</body>
</html>