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
            <th>Take</th>
            <?php foreach ($fields as $field): ?>
                <th><a href="#"><?= htmlspecialchars($field["label"]) ?></a></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $date => $answerSet): ?>
            <tr>
                <td><a href="/exercises/<?= $data["id"]?>/results/<?= $data["fulfillment_id"]?>"><?= $date ?></a></td>
                <?php foreach ($fields as $field): ?>
                    <?php
                    $fieldId = $field['field_id'];
                    $state = $answerSet[$fieldId]['state'] ?? 'empty';

                    if ($state === 'short') {
                        $image = '/img/trick.png';
                        $tooltip = 'Réponse courte';
                    } elseif ($state === 'long') {
                        $image = '/img/doubletrick.png';
                        $tooltip = 'Réponse longue';
                    } else {
                        $image = '/img/cross.png';
                        $tooltip = 'Aucune réponse';
                    }
                    ?>
                    <td title="<?= htmlspecialchars($tooltip) ?>">
                        <img class="imgstate" src="<?= htmlspecialchars($image) ?>"
                             alt="<?= htmlspecialchars($tooltip) ?>"
                             class="answer-icon">
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    </body>
    </html>
</main>
