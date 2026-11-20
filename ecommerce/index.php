<?php require_once 'includes/header.php'; ?>

<?php
$stmt = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 ORDER BY id DESC");
$produtos = $stmt->fetchAll();
?>

<h2 class="mb-4 fw-bold text-danger">Nossos Produtos</h2>
<div class="row g-4">
    <?php foreach($produtos as $p): ?>
        <div class="col-md-4">
            <div class="card card-produto h-100">
                <img src="<?= htmlspecialchars($p['imagem']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="...">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold"><?= htmlspecialchars($p['nome']) ?></h5>
                    <p class="card-text text-muted small"><?= htmlspecialchars($p['descricao']) ?></p>
                    <h4 class="preco mt-auto">R$ <?= number_format($p['preco'], 2, ',', '.') ?></h4>
                    <p class="text-muted small mb-2">Estoque: <?= $p['estoque'] ?> un.</p>
                    
                    <form action="adicionar_carrinho.php" method="POST" class="d-flex gap-2">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="number" name="qtd" value="1" min="1" max="<?= $p['estoque'] ?>" class="form-control w-25">
                        <button type="submit" class="btn btn-comprar w-100">Comprar</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/footer.php'; ?>