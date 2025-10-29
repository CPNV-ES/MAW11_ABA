<header class="heading results">
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
        <meta name="csrf-token" content="WfvLG3l6aozgVBEFX1OGsQGwC1vggPUAScJh6xelh5ZWigN567rgwsNfL3MYBoWz3A+zhcA3nNdgoHuCKpj5Bw==" />


        <link rel="stylesheet" media="all" href="/css/manage-exercise.css" />
    </head>

    <body>
    <div class="row">
        <section class="column">
            <h1>Building</h1>
            <table class="records">
                <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($exercises as $exercise) { ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <a title="Manage fields" href="/exercises/<?= $exercise["exercise_id"] ?>/fields"><img src="/img/edit.png" class="fa fa-trash"></a>
                            <a title="delete" href="#" onclick="if(confirm('Are you sure?')){document.getElementById('delete-form-<?= $exercise["exercise_id"] ?>').submit();} return false;"><img src="/img/trash.png" class="fa fa-trash"></a>
                            <form id="delete-form-<?= $exercise["exercise_id"] ?>" method="POST" action="/exercises/delete" style="display:none;">
                                <input type="hidden" name="exercise_id" value="<?= $exercise["exercise_id"] ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>

        <section class="column">
            <h1>Answering</h1>
            <table class="records">
                <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($exercises as $exercise) { ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <a title="Show results" href="#"><img class="fa fa-edit" src="/img/stats.png"></a>
                            <a title="Close" rel="nofollow" data-method="put" href="#"><img src="/img/close.png" class="fa fa-trash"></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>

        <section class="column">
            <h1>Closed</h1>
            <table class="records">
                <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($exercises as $exercise) { ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <a title="Manage fields" href="/exercises/<?= $exercise["exercise_id"] ?>/fields"><img src="/img/stats.png" class="fa fa-edit"></a>
                            <a title="delete" href="#" onclick="if(confirm('Are you sure?')){document.getElementById('delete-form-closed-<?= $exercise["exercise_id"] ?>').submit();} return false;"><img src="/img/trash.png" class="fa fa-trash"></a>
                            <form id="delete-form-closed-<?= $exercise["exercise_id"] ?>" method="POST" action="/exercises/delete" style="display:none;">
                                <input type="hidden" name="exercise_id" value="<?= $exercise["exercise_id"] ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
    </body>
    </html>
</main>