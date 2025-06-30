<?php require APPROOT . '/app/views/templates/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body mt-5">
            <?php flash('profile_message'); ?>
            <h2>Perfil do Usuário</h2>
            <p>Aqui você pode alterar seus dados. Deixe os campos de senha em branco para não alterá-la.</p>
            
            <form action="<?php echo URLROOT; ?>/public/index.php?url=user/profile" method="POST">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nome: <sup>*</sup></label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                    <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                </div>

                <hr>
                <p>Alterar Senha (opcional)</p>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Nova Senha:</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
                </div>
                
                <div class="form-group mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Nova Senha:</label>
                    <input type="password" name="confirm_password" class="form-control" value="">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/views/templates/footer.php'; ?>