<header class="heading managing">
    <section class="container">
        <a href="/"><img src="../assets/logo-looper.png" /></a>
        <span class="exercise-label">New exercise</span>
    </section>
</header>

<main class="container">
    <!DOCTYPE html>
    <html>
    <head>
        <title>exerciselooper</title>
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="yfm29sav/3n4nmqcdmmsvepjs9wvuv9/twl8h+w5wbnggv6uvfv1n9uvwmoxpk++nlwlc7xmnqhma2bu2is+ia==" />

        <link rel="stylesheet" href="/css/common.css">

    </head>

    <body>
    <h1>New Exercise</h1>

    <form action="/exercises/new" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="AUxomCBAS/RkPl7DyMEqERDWGUD2ErnmgaZU6YzlI7IKynUiLtx4+EAi1HFZ3hMR1Q7PtjPp/6TyWH32tyIvMg==" />

        <div class="form-group <?= isset($data['title_error']) ? 'has-error' : '' ?>">
            <label for="exercise_title">Title</label>
            <input type="text" name="exercise_title" id="exercise_title" value="<?= htmlspecialchars($_POST['exercise_title'] ?? '') ?>" required maxlength="75" placeholder="Choisir un titre (max 75 caracters)" />

            <?php if (!empty($data['title_error'])): ?>
                <span class="help-block"><?= htmlspecialchars($data['title_error']) ?></span>
            <?php endif; ?>
        </div>
        <div class="actions">
            <input type="submit" name="commit" value="Create Exercise" data-disable-with="Create Exercise" />
        </div>
    </form>

    </body>
    </html>

</main>