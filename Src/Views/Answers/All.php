<header class="heading results">
    <section class="container">
        <a href="/"><img src="/assets/logo-looper.png" /></a>
        <?php if (!empty($data['title'])): ?>
            <span class="exercise-label">
                Exercise: <a href="/exercises/<?= $data["id"]?>/results/"><?= htmlspecialchars($data['title']) ?></a>
            </span>
        <?php endif; ?>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>ExerciseLooper</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="BXsG3Y5pcBftAp2Cra3Q6bQm828bQsdKutU1Pxa1PPSV3nsf8/34NTbrwbUyvOgQI74jNFBr4h4lCu4xOngsfA==" />
        <link rel="stylesheet" href="/css/common.css">
    </head>

    <body>
    <table>
        <thead>
        <tr>
            <th>Take</th>
            <?php foreach ($fields as $field): ?>
                <th><a href="/exercises/<?= $data["id"] ?>/results/<?= $field["field_id"] ?>"><?= htmlspecialchars($field["label"]) ?></a></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $fulfillmentId => $answerSet): ?>
            <tr>
                <td>
                    <a href="/exercises/<?= $data["id"] ?>/fulfillments/<?= $fulfillmentId ?>">
                        <?= $answerSet['date'] ?> UTC
                    </a>
                </td>

                <?php foreach ($fields as $field): ?>
                    <?php
                    $fieldId = $field['field_id'];
                    $state = $answerSet['fields'][$fieldId]['state'] ?? 'empty';

                    if ($state === 'short') {
                        $icon = '<i class="fa fa-check short"></i>';
                        $tooltip = 'Réponse courte';
                    } elseif ($state === 'long') {
                        $icon = '<i class="fa fa-check-double filled"></i>';
                        $tooltip = 'Réponse longue';
                    } else {
                        $icon = '<i class="fa fa-times empty"></i>';
                        $tooltip = 'Aucune réponse';
                    }
                    ?>
                    <td title="<?= htmlspecialchars($tooltip) ?>"><?= $icon ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </body>
    </html>
</main>