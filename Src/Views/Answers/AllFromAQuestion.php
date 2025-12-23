<header class="heading results">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>

            <span class="exercise-label">
                Exercise: <a href="/exercises/<?= $data["id"]?>/results/"><?= htmlspecialchars($data['title']) ?></a>
            </span>

    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="TApu58ub6RB2WZ6DQh9HpApDI7xYQoSOp7GIOpWryY4W6TEDbod6j33bUHxy0m5XZHZmxNfcxdglc5JZRjy7Kg==" />

        <link rel="stylesheet" href="/css/common.css">
    </head>

    <body>
        <h1><?= $data["label"] ?></h1>
    <table>
        <thead>
        <tr>
            <th>Take</th>
            <th>Content</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($fields as $field): ?>
        <tr>
            <td><a href="/exercises/<?= $field["exercise_id"] ?>/fulfillments/<?= $field['fulfillment_id'] ?>"><?= $field['fulfillment_date'] ?> UTC</a></td>
            <td><?= $field["answer_text"] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    </body>
    </html>

</main>