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
                    <h1 class="h4 text-center mb-3">Registrácia</h1>

                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php } ?>

                    <form method="post" action="<?= $link->url('auth.register') ?>">
                        <div class="mb-3">
                            <label class="form-label">Používateľské meno</label>
                            <label>
                                <input name="username" class="form-control" required>
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email (voliteľné)</label>
                            <label>
                                <input type="email" name="email" class="form-control" placeholder="napr. ja@smartmeal.sk">
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Heslo</label>
                            <label>
                                <input type="password" name="password" class="form-control" required>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Heslo znovu</label>
                            <label>
                                <input type="password" name="password2" class="form-control" required>
                            </label>
                        </div>

                        <button class="btn btn-primary w-100" type="submit" name="submit" value="1">
                            Vytvoriť účet
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?= $link->url('auth.login') ?>">Mám účet, chcem sa prihlásiť</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
