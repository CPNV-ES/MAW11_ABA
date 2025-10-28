<header class="heading managing">
    <section class="container">
        <a href="/"><img src="/assets/logo-84d7d70645fbe179ce04c983a5fae1e6cba523d7cd28e0cd49a04707ccbef56e.png" /></a>
        <span class="exercise-label">Exercise: <a href="/exercises/<?= $exercise['exercise_id'] ?>/fields"><?= htmlspecialchars($exercise['title']) ?></a></span>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="bYfrqpT/c0SOL1kp9inU7AF4WU5OduaWg3i7ybpkJBli9iPIBj/5Cq0kZ1+xfNfu3MfhkG7Bj0GqGqGgh1laiA==" />
        <link rel="stylesheet" media="all" href="/css/manageFieldsEdit.css" />
    </head>

    <body>
    <h1>Editing Field</h1>

    <form action="/exercises/<?= $exercise['exercise_id'] ?>/fields/<?= $field['field_id'] ?>/edit" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="yuzG2egQmOu2nUpcLWgbiDaiRXNOYTILoW5KeoeIUB3KZNxa7fhT+nKABG8vuSBOj8zkpP5NmULSFNktvWvVaQ==" />

        <div class="field">
            <label for="field_label">Label</label>
            <input type="text" value="<?= htmlspecialchars($field['label']) ?>" name="field[label]" id="field_label" />
        </div>

        <div class="field">
            <label for="field_value_kind">Value kind</label>
            <select name="field[value_kind]" id="field_value_kind">
                <option <?= $field['value_kind'] === 'single_line' ? 'selected="selected"' : '' ?> value="single_line">Single line text</option>
                <option <?= $field['value_kind'] === 'single_line_list' ? 'selected="selected"' : '' ?> value="single_line_list">List of single lines</option>
                <option <?= $field['value_kind'] === 'multi_line' ? 'selected="selected"' : '' ?> value="multi_line">Multi-line text</option>
            </select>
        </div>

        <div class="actions">
            <input type="submit" name="commit" value="Update Field" data-disable-with="Update Field" />
        </div>
    </form>

    </body>
    </html>

</main>