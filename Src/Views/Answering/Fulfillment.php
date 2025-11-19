<header class="heading answering">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>
        <span class="exercise-label">Exercise: <span class="exercise-title"><?= $exercise["title"] ?></span></span>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>

    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="MlSnmdNEYZd/yDiHtziwuYnU2JHgwK1CLN2g3IUJoZQ5xPMUHl2roCZhl5OlI7KUw6437MWJs0EkJAXoXtG0kw==" />


        <link rel="stylesheet" media="all" href="/css/home.css" />
    </head>

    <body>
        <h1>Your take</h1>
        <p>If you'd like to come back later to finish, simply submit it with blanks</p>

        <form action="/exercises/<?= $exercise["exercise_id"] ?>/fulfillments/new" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="wF4zYqEsIyc012LLc4RxilTULY268IW3hU0bY4ytbn5xtfExNXp3SWcZ0IXF7p23NLo6Y/2XJlJqaBV0UbrYpw==" />

            <?php foreach ($fields as $field) { ?>
                <div class="field">
                    <label for="fulfillment_answers_attributes__value"><?= $field["label"] ?></label>
                    <?php if ($field["value_kind"] === 'single_line') { ?>
                        <input type="text" name="answers[<?= $field['field_id'] ?>]" id="answers[<?= $field['field_id'] ?>]" value="<?= htmlspecialchars($_POST['answer_text'] ?? '') ?>" />
                        <input type="hidden" name="field_ids[<?= $field['field_id'] ?>]" id="field_ids[<?= $field['field_id'] ?>]" value="<?= $field['field_id'] ?>"/>
                    <?php }

                    else { ?>
                    <textarea name="answers[<?= $field['field_id'] ?>]" id="answers[<?= $field['field_id'] ?>]" value="<?= htmlspecialchars($_POST['answer_text'] ?? '') ?>"></textarea>
                    <input type="hidden" name="field_ids[<?= $field['field_id'] ?>]" id="field_ids[<?= $field['field_id'] ?>]" value="<?= $field['field_id'] ?>"/>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="actions">
                <input type="submit" name="commit" value="Save" data-disable-with="Save" />
            </div>
        </form>

    </body>

    </html>

</main>