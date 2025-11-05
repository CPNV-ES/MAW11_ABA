
<header class="heading results">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>
        <?php if (!empty($data['title'])): ?>
            <span class="exercise-label">Exercise: <?= htmlspecialchars($data['title']) ?></span>
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
        <link rel="stylesheet" media="all" href="/css/home.css" />
    </head>

    <body>
    <table>
        <thead>
        <tr>
            <th>Réponse</th>
            <?php foreach ($fields as $field): ?>
                <th><?= htmlspecialchars($field["label"]) ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $date => $answerSet): ?>
            <tr>
                <td><?= $date ?></td>
                <?php foreach ($fields as $field): ?>
                    <?php
                    $fieldId = $field['field_id'];
                    $answered = isset($answerSet[$fieldId]) && $answerSet[$fieldId]['answered'];
                    ?>
                    <td><?= $answered ? '✓' : '✗' ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    </body>
    </html>

</main>