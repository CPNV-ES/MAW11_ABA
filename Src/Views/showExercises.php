
<header class="heading answering">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>

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
    <ul class="ansering-list">
        <!-- ** refaire au propre ** -->
        <?php foreach ($exercises as $exercise) { ?>
            <li class="row">
                <div class="column card">
                    <div class="title"><?= $exercise["title"]?></div>
                    <a class="button" href="#">Take it</a>
                </div>
            </li>
        <?php } ?>
    </ul>
    </body>
    </html>

</main>
