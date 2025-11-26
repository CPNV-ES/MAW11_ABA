<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée | Exercise Looper</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #9b4dca 0%, #8a3fb8 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 300;
            line-height: 1.3;
        }

        .container {
            max-width: 800px;
            margin: 80px auto;
            padding: 0 20px;
            text-align: center;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #9b4dca;
            line-height: 1;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .error-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 50px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 3px;
            transition: opacity 0.2s;
            background-color: #9b4dca;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error-details {
            margin-top: 60px;
            padding: 20px;
            background-color: #fff;
            border-left: 4px solid #9b4dca;
            text-align: left;
            border-radius: 3px;
        }

        .error-details strong {
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .error-details code {
            background-color: #f5f5f5;
            padding: 4px 8px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e74c3c;
            font-size: 14px;
        }
    </style>
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