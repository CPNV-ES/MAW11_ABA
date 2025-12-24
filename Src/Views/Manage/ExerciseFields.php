<header class="heading managing">
    <section class="container">
        <a href="/"><img src="/assets/logo-looper.png" /></a>
        <span class="exercise-label">Exercise: <a href="/exercises/<?= $exercise['exercise_id'] ?>/fields"><?= htmlspecialchars($exercise['title']) ?></a></span>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>ExerciseLooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="0ld8nT0XtAfXOB6bofLoeNZGfvdzqH1+nzj7sOL8PJTdJrT/r9c+SfQzIO3mp+t6C/nGKVMfFKm2WuHZ38FCBQ==" />
        <link rel="stylesheet" href="/css/common.css">
        <link rel="stylesheet" href="/css/manage-exercise-fields.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>

    <body>
    <div class="row">
        <section class="column">
            <h1>Fields</h1>
            <table class="records">
                <thead>
                <tr>
                    <th>Label</th>
                    <th>Value kind</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($fields as $field): ?>
                    <tr>
                        <td><?= htmlspecialchars($field['label']) ?></td>
                        <td><?php
                            $valueKindDisplay = [
                                    'single_line' => 'Single line text',
                                    'single_line_list' => 'List of single lines',
                                    'multi_line' => 'Multi-line text'
                            ];
                            echo htmlspecialchars($valueKindDisplay[$field['value_kind']] ?? $field['value_kind']);
                            ?></td>
                        <td>
                            <a title="Edit" href="/exercises/<?= $exercise['exercise_id'] ?>/fields/<?= $field['field_id'] ?>/edit"><i class="fa fa-edit"></i></a>
                            <a title="Destroy" rel="nofollow" data-method="delete" href="/exercises/<?= $exercise['exercise_id'] ?>/fields/<?= $field['field_id'] ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <a title="confirm" class="button" onclick="if(confirm('Are you sure? You won\'t be able to further edit this exercise')) {document.getElementById('complete-form-<?= $exercise['exercise_id'] ?>').submit();} return false;"><i class="fa fa-comment"></i> Complete and be ready for answers</a>

            <form id="complete-form-<?= $exercise['exercise_id'] ?>" method="GET" action="/exercises/<?= $exercise['exercise_id'] ?>" style="display:none;">
                <input type="hidden" name="exercise[status]" value="answering">
            </form>

        </section>
        <section class="column">
            <h1>New Field</h1>
            <form action="/exercises/<?= $exercise['exercise_id'] ?>/fields" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="Uc+qZWAtqmOJ3t9OZ7hZWX8YvRAHPCIX8DizYACNR4wRWk+H2wUN/CVObUYNzqMwJBO6njHCTfWvv3na+WvC7w==" />

                <div class="form-group <?= !empty($errors['label']) ? 'has-error' : '' ?>">
                    <label for="field_label">Label</label>
                    <input type="text" name="field[label]" id="field_label" value="<?= htmlspecialchars($old['label'] ?? '') ?>" required maxlength="255" placeholder="Choisir une question (max 255 caracters)"  />
                    <?php if (!empty($errors['label'])): ?>
                        <span class="help-block"><?= htmlspecialchars($errors['label']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?= !empty($errors['value_kind']) ? 'has-error' : '' ?>">
                    <label for="field_value_kind">Value kind</label>
                    <select name="field[value_kind]" id="field_value_kind">
                        <option <?= (!isset($old['value_kind']) || $old['value_kind'] === 'single_line') ? 'selected="selected"' : '' ?> value="single_line">Single line text</option>
                        <option <?= (isset($old['value_kind']) && $old['value_kind'] === 'single_line_list') ? 'selected="selected"' : '' ?> value="single_line_list">List of single lines</option>
                        <option <?= (isset($old['value_kind']) && $old['value_kind'] === 'multi_line') ? 'selected="selected"' : '' ?> value="multi_line">Multi-line text</option>
                    </select>
                    <?php if (!empty($errors['value_kind'])): ?>
                        <span class="help-block"><?= htmlspecialchars($errors['value_kind']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="actions">
                    <input type="submit" name="commit" value="Create Field" data-disable-with="Create Field" />
                </div>
            </form>
        </section>
    </div>

    </body>
    </html>

</main>