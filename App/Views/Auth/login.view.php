<?php
/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card shadow my-5">
                <div class="card-body p-4">

                    <h1 class="h4 text-center mb-3">Prihlásenie</h1>

                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php } ?>

                    <form method="post" action="<?= $link->url('auth.login') ?>">

                        <div class="mb-3">
                            <label for="username" class="form-label">Používateľské meno</label>
                            <input name="username" type="text" id="username" class="form-control"
                                   placeholder="Zadaj používateľské meno" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Heslo</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Zadaj heslo" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit" name="submit" value="1">
                            Prihlásiť sa
                        </button>

                        <div class="text-center mt-3">
                            <a href="<?= $link->url('auth.register') ?>">Nemám účet, chcem sa zaregistrovať</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>