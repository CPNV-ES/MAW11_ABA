
<header class="heading answering">
    <section class="container">
        <a href="/"><img src="/assets/logo-looper.png" /></a>

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
        <link rel="stylesheet" href="/css/home.css">
    </head>

    <body>
    <ul class="ansering-list">
        <?php foreach ($exercises as $exercise) { ?>
                <?php if($exercise['status'] === "answering") { ?>
            <li class="row">
                <div class="column card">
                    <div class="title"><?= $exercise["title"]?></div>
                    <a class="button" href="/exercises/<?= $exercise["exercise_id"] ?>/fulfillments/new">Take it</a>
                </div>
            </li>
        <?php } } ?>
    </ul>
    </body>
    </html>

</main>
