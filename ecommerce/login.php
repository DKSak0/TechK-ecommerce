<?php require_once 'includes/header.php'; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0 fw-bold">Acessar Conta</h4>
            </div>
            <div class="card-body p-4">
                <?php if(isset($_GET['erro'])): ?>
                    <div class="alert alert-danger">E-mail ou senha incorretos!</div>
                <?php endif; ?>
                <form action="processa_login.php" method="POST">
                    <div class="mb-3"><label class="fw-bold">E-mail</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-4"><label class="fw-bold">Senha</label><input type="password" name="senha" class="form-control" required></div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2">Entrar</button>
                </form>
                <div class="text-center mt-3"><small>Ainda não tem conta? <a href="cadastro.php" class="text-danger fw-bold">Cadastre-se</a></small></div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>