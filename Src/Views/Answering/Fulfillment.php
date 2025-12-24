<header class="heading answering">
    <section class="container">
        <a href="/"><img src="/assets/logo-looper.png" /></a>
        <span class="exercise-label">Exercise: <span class="exercise-title"><?= htmlspecialchars($exercise["title"]) ?></span></span>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>

    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="MlSnmdNEYZd/yDiHtziwuYnU2JHgwK1CLN2g3IUJoZQ5xPMUHl2roCZhl5OlI7KUw6437MWJs0EkJAXoXtG0kw==" />

        <link rel="stylesheet" href="/css/common.css">
    </head>

    <body>
    <h1>Your take</h1>
    <?php if (isset($isEdit) && $isEdit): ?>
        <p>Bookmark this page, it's yours. You'll be able to come back later to finish.</p>
    <?php else: ?>
        <p>If you'd like to come back later to finish, simply submit it with one answer or more.</p>
    <?php endif; ?>

    <?php
    $formAction = isset($isEdit) && $isEdit
            ? "/exercises/{$exercise['exercise_id']}/fulfillments/{$fulfillmentId}"
            : "/exercises/{$exercise['exercise_id']}/fulfillments/new";
    ?>

    <form action="<?= $formAction ?>" accept-charset="UTF-8" method="post">
        <input name="utf8" type="hidden" value="&#x2713;" />
        <input type="hidden" name="authenticity_token" value="wF4zYqEsIyc012LLc4RxilTULY268IW3hU0bY4ytbn5xtfExNXp3SWcZ0IXF7p23NLo6Y/2XJlJqaBV0UbrYpw==" />
        <input type="hidden" name="exercise_id" value="<?= htmlspecialchars($exercise['exercise_id']) ?>" />

        <?php if (isset($errors) && !empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="form-group has-error">
                    <span class="help-block"><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php foreach ($fields as $index => $field): ?>
            <?php
            $answerValue = '';
            $answerId = null;

            if (isset($answers) && isset($answers[$index])) {
                $answerValue = $answers[$index]['answer_text'] ?? '';
                $answerId = $answers[$index]['answer_id'] ?? null;
            }
            ?>
            <div class="field">
                <label for="answers_<?= $index ?>"><?= htmlspecialchars($field["label"]) ?></label>
                <?php if ($field["value_kind"] === 'single_line'): ?>
                    <input type="text" name="answers[<?= $index ?>]" id="answers_<?= $index ?>" value="<?= htmlspecialchars($answerValue) ?>" maxlength="1000" />
                <?php else: ?>
                    <textarea name="answers[<?= $index ?>]" id="answers_<?= $index ?>" maxlength="1000"><?= htmlspecialchars($answerValue) ?></textarea>
                <?php endif; ?>
                <input type="hidden" name="field_ids[<?= $index ?>]" id="field_ids_<?= $index ?>" value="<?= htmlspecialchars($field['field_id']) ?>" />
                <?php if ($answerId !== null): ?>
                    <input type="hidden" name="answer_ids[<?= $index ?>]" value="<?= htmlspecialchars($answerId) ?>" />
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="actions">
            <input type="submit" name="commit" value="Save" data-disable-with="Save" />
        </div>
    </form>

    </body>

    </html>

</main>