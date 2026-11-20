<?php require_once 'includes/header.php'; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0 fw-bold">Criar Conta</h4>
            </div>
            <div class="card-body p-4">
                <form action="processa_cadastro.php" method="POST">
                    <div class="mb-3"><label class="fw-bold">Nome Completo</label><input type="text" name="nome" class="form-control" required></div>
                    <div class="mb-3"><label class="fw-bold">E-mail</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-4"><label class="fw-bold">Senha</label><input type="password" name="senha" class="form-control" minlength="4" required></div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>