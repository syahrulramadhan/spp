<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
    $session = session();
    $errors = $session->getFlashdata('errors');
    
    $hassErrorUsername = $validation->hasError('username') ? 'is-invalid' : '';
    $hassErrorPassword = ($validation->hasError('password') || $errors) ? 'is-invalid' : '';

	$username = [
		'name' => 'username',
		'id' => 'username',
		'value' =>  old('username'),
		'class' => "form-control $hassErrorUsername"
	];

		$password = [
		'name' => 'password',
		'id' => 'password',
		'class' => "form-control $hassErrorPassword"
	];
?>


<div class="card mb-3 mt-2">
    <div class="row">
        <div class="col-md-4">
            <div class="card-body">
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Login Form</h6>
                    </div>
                </div>
                <?= form_open('Auth/login') ?>
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <?= form_label("Username/Email", "username") ?>
                        <?= form_input($username) ?>
                        <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Password", "password") ?>
                        <?= form_password($password) ?>
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                        <div class="invalid-feedback"><?= session()->getFlashdata('error'); ?></div>
                        <input type="checkbox" onclick="show_password()" class="mt-2"> Tampilkan Kata Sandi
                    </div>
                    <div class="text-right">
                        <?= form_submit('submit', 'Submit',['class'=>'btn btn-info']) ?>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Tentang Kami</h6>
                    </div>
                </div>

                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_password() {
        var password = $("#password").val();

        if ($("#password").attr('type') === "password") {
            $("#password").attr('type', "text")
        } else {
            $("#password").attr('type', "password")
        }
    }
</script>

<?= $this->endSection() ?>