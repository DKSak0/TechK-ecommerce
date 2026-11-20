<?php require_once 'includes/header.php'; ?>
<div class="text-center mt-5">
    <h1 class="text-success fw-bold mb-4">✅ Pedido Confirmado!</h1>
    <p class="fs-5">Obrigado pela sua compra, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>!</p>
    <p>O número do seu pedido é <strong>#<?= (int)$_GET['id'] ?></strong>.</p>
    <a href="index.php" class="btn btn-danger mt-4 px-5">Voltar para a Loja</a>
</div>
<?php require_once 'includes/footer.php'; ?>