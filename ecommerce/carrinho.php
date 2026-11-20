<?php require_once 'includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger">Seu Carrinho</h2>
    <a href="index.php" class="btn btn-outline-dark">Continuar Comprando</a>
</div>

<?php if(empty($_SESSION['carrinho'])): ?>
    <div class="alert alert-warning text-center p-5">
        <h4>Seu carrinho está vazio!</h4>
        <br>
        <a href="index.php" class="btn btn-danger px-4">Ver Produtos</a>
    </div>
<?php else: ?>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Qtd</th>
                        <th>Subtotal</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_geral = 0;
                    foreach($_SESSION['carrinho'] as $id => $qtd): 
                        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
                        $stmt->execute([$id]);
                        $p = $stmt->fetch();
                        
                        if(!$p) continue;
                        
                        $subtotal = $p['preco'] * $qtd;
                        $total_geral += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= htmlspecialchars($p['imagem']) ?>" width="60" class="rounded border">
                                <strong><?= htmlspecialchars($p['nome']) ?></strong>
                            </div>
                        </td>
                        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td><?= $qtd ?>x</td>
                        <td class="fw-bold text-danger">R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="remover_carrinho.php?id=<?= $id ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold fs-5">Total Geral:</td>
                        <td colspan="2" class="fw-bold fs-3 text-danger">R$ <?= number_format($total_geral, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-end mt-4">
        <a href="checkout.php" class="btn btn-danger btn-lg px-5 fw-bold shadow">Finalizar Compra</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>