<?php 
require_once 'includes/header.php'; 

// Exigência do trabalho: Só compra se estiver logado
if(!isset($_SESSION['usuario_id'])) {
    echo "<div class='alert alert-danger text-center mt-5'>
            <h4>Você precisa estar logado para finalizar a compra!</h4>
            <a href='login.php' class='btn btn-danger mt-3'>Fazer Login</a>
          </div>";
    require_once 'includes/footer.php';
    exit;
}

if(empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php'); exit;
}

$total_geral = 0;
foreach($_SESSION['carrinho'] as $id => $qtd) {
    $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    if($p) $total_geral += ($p['preco'] * $qtd);
}
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-danger text-white py-3">
                <h4 class="mb-0 fw-bold">Finalizar Pedido</h4>
            </div>
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Total a pagar: <span class="text-danger">R$ <?= number_format($total_geral, 2, ',', '.') ?></span></h5>
                
                <form action="processa_pedido.php" method="POST">
                    <label class="fw-bold mb-2">Escolha a forma de pagamento:</label>
                    
                    <div class="form-check mb-2 p-3 border rounded bg-light">
                        <input class="form-check-input ms-0 me-2" type="radio" name="pagamento" value="pix" id="pix" checked>
                        <label class="form-check-label fw-bold" for="pix">PIX (Aprovação imediata)</label>
                    </div>
                    
                    <div class="form-check mb-2 p-3 border rounded">
                        <input class="form-check-input ms-0 me-2" type="radio" name="pagamento" value="cartao" id="cartao">
                        <label class="form-check-label fw-bold" for="cartao">Cartão de Crédito</label>
                    </div>
                    
                    <div class="form-check mb-4 p-3 border rounded">
                        <input class="form-check-input ms-0 me-2" type="radio" name="pagamento" value="boleto" id="boleto">
                        <label class="form-check-label fw-bold" for="boleto">Boleto Bancário</label>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold">Confirmar e Pagar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>