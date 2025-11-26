<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée | Exercise Looper</title>
    <link rel="stylesheet" media="all" href="/css/404.css" />
</head>
<body>
<div class="header">
    <p><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" alt="ExerciseLooper Logo" /></p>
    <h1>Exercise<br>Looper</h1>
</div>

<div class="container">
    <div class="error-code">404</div>
    <h2 class="error-title">Page non trouvée</h2>
    <p class="error-message">
        La page que vous recherchez n'existe pas ou a été déplacée.
    </p>

    <a href="/" class="btn">
        Retour à l'accueil
    </a>

    <?php if (isset($_SERVER['REQUEST_URI'])): ?>
        <div class="error-details">
            <strong>Détails techniques :</strong>
            <code><?= htmlspecialchars($_SERVER['REQUEST_URI']) ?></code>
        </div>
    <?php endif; ?>
</div>
</body>
</html>