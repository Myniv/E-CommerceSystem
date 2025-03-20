<?= $this->extend('layout/master'); ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h3><?= lang('Auth.forgotPassword') ?></h3>
                </div>
                <div class="card-body">
                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <p><?= lang('Auth.enterEmailForInstructions') ?></p>

                    <form action="<?= url_to('forgot') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label"><?= lang('Auth.emailAddress') ?></label>
                            <input type="email"
                                class="form-control <?php if (session('errors.email')): ?>is-invalid<?php endif ?>"
                                name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>