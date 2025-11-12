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
        <meta name="csrf-token" content="0ld8nT0XtAfXOB6bofLoeNZGfvdzqH1+nzj7sOL8PJTdJrT/r9c+SfQzIO3mp+t6C/nGKVMfFKm2WuHZ38FCBQ==" />
        <link rel="stylesheet" media="all" href="/css/manage-fields-edit.css" />
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
                            <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete" href="#"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <a data-confirm="Are you sure? You won&#39;t be able to further edit this exercise" class="button" rel="nofollow" data-method="put" href="/exercises/<?= $exercise['exercise_id'] ?>?exercise%5Bstatus%5D=answering"><i class="fa fa-comment"></i> Complete and be ready for answers</a>

        </section>
        <section class="column">
            <h1>New Field</h1>
            <form action="/exercises/<?= $exercise['exercise_id'] ?>/fields" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="Uc+qZWAtqmOJ3t9OZ7hZWX8YvRAHPCIX8DizYACNR4wRWk+H2wUN/CVObUYNzqMwJBO6njHCTfWvv3na+WvC7w==" />

                <div class="field">
                    <label for="field_label">Label</label>
                    <input type="text" name="field[label]" id="field_label" />
                </div>

                <div class="field">
                    <label for="field_value_kind">Value kind</label>
                    <select name="field[value_kind]" id="field_value_kind"><option selected="selected" value="single_line">Single line text</option>
                        <option value="single_line_list">List of single lines</option>
                        <option value="multi_line">Multi-line text</option></select>
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