
<header class="heading results">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>
        <?php if (!empty($data['title'])): ?>
            <span class="exercise-label">Exercise: <a href="/exercises/<?= $data["id"]?>/results/"><?= htmlspecialchars($data['title']) ?></a></span>
        <?php endif; ?>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="BXsG3Y5pcBftAp2Cra3Q6bQm828bQsdKutU1Pxa1PPSV3nsf8/34NTbrwbUyvOgQI74jNFBr4h4lCu4xOngsfA==" />
        <link rel="stylesheet" href="/css/common.css">
    </head>

<body>
    <h1><?=$data["fulfillment_date"]?> UTC</h1>
    <dl class="answer">
        <?php foreach ($answers as $answer): ?>
                <dt><?=$answer["label"]?></dt>
                <dd><?=$answer["answer_text"]?></dd>
        <?php endforeach; ?>
    </dl>
</body>

