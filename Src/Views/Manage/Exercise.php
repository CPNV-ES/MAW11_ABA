<header class="heading results">
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
        <meta name="csrf-token" content="WfvLG3l6aozgVBEFX1OGsQGwC1vggPUAScJh6xelh5ZWigN567rgwsNfL3MYBoWz3A+zhcA3nNdgoHuCKpj5Bw==" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="/css/common.css">
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
                <?php foreach ($exercises as $exercise) {
                        if (isset($exercise["status"]) && $exercise["status"] === 'building') {
                    ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <?php if ($exercise['isfield'] === true) { ?>
                                 <a title="confirm" onclick="if(confirm('Are you sure? You won\'t be able to further edit this exercise')) {document.getElementById('complete-form-<?= $exercise['exercise_id'] ?>').submit();} return false;"><i class="fa fa-comment"></i></a>
                                 <form id="complete-form-<?= $exercise['exercise_id'] ?>" method="GET" action="/exercises/<?= $exercise['exercise_id'] ?>" style="display:none;">
                                    <input type="hidden" name="exercise[status]" value="answering">
                                </form>
                            <?php } ?>
                            <a title="Manage fields" href="/exercises/<?= $exercise["exercise_id"]?>/fields"><i class="fa fa-edit"></i></a>
                            <a title="delete" href="#" onclick="if(confirm('Are you sure?')){document.getElementById('delete-form-<?= $exercise["exercise_id"] ?>').submit();} return false;"><i class="fa fa-trash"></i></a>
                            <form id="delete-form-<?= $exercise["exercise_id"] ?>" method="POST" action="/exercises/delete" style="display:none;">
                                <input type="hidden" name="exercise_id" value="<?= $exercise["exercise_id"]?>">
                            </form>
                        </td>
                    </tr>
                <?php } } ?>
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
                <?php foreach ($exercises as $exercise) { 
                    if (isset($exercise["status"]) && $exercise["status"] === 'answering') {
                        ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <a title="Show results" href="/exercises/<?= $exercise["exercise_id"] ?>/results"><i class="fa fa-chart-bar"></i></a>
                            <a title="close" rel="nofollow" data-method="put" href="#" onclick="if(confirm('Are you sure?')){document.getElementById('close-form-<?= $exercise["exercise_id"] ?>').submit();} return false;"><i class="fa fa-minus-circle"></i></a>
                            <form id="close-form-<?= $exercise["exercise_id"] ?>" method="POST" action="/exercises/close" style="display:none;">
                                <input type="hidden" name="exercise_id" value="<?= $exercise["exercise_id"]?>">
                            </form>
                        </td>
                    </tr>
                <?php } } ?>
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
                <?php foreach ($exercises as $exercise) { 
                        if (isset($exercise["status"]) && $exercise["status"] === "closed") {                    
                    ?>
                    <tr>
                        <td><?= $exercise["title"]?></td>
                        <td>
                            <a title="Show results" href="/exercises/<?= $exercise["exercise_id"] ?>/results"><i class="fa fa-chart-bar"></i></a>
                            <a title="delete" href="#" onclick="if(confirm('Are you sure?')){document.getElementById('delete-form-closed-<?= $exercise["exercise_id"] ?>').submit();} return false;"><i class="fa fa-trash"></i></a>
                            <form id="delete-form-closed-<?= $exercise["exercise_id"] ?>" method="POST" action="/exercises/delete" style="display:none;">
                                <input type="hidden" name="exercise_id" value="<?= $exercise["exercise_id"] ?>">
                            </form>
                        </td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </section>
    </div>
    </body>
    </html>
</main>