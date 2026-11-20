<?php 
session_start();
require_once 'config/conexao.php';
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') { header('Location: login.php'); exit; }
require_once 'includes/header.php'; 
?>
<h2 class="fw-bold mb-4 mt-3 text-danger">Pedidos Realizados</h2>
<a href="admin.php" class="btn btn-outline-dark mb-4">Voltar ao Painel</a>
<?php
$stmt = $pdo->query("SELECT p.*, u.nome as cliente FROM pedidos p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.id DESC");
$pedidos = $stmt->fetchAll();
if(empty($pedidos)): ?>
    <div class="alert alert-info">Nenhum pedido realizado ainda.</div>
<?php else: foreach($pedidos as $ped): ?>
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span>Pedido #<?= $ped['id'] ?> - Cliente: <strong><?= htmlspecialchars($ped['cliente']) ?></strong></span>
                <span>Total: R$ <?= number_format($ped['total'], 2, ',', '.') ?> (<?= strtoupper($ped['forma_pagamento']) ?>)</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Produto</th><th>Qtd</th><th>Preço Un.</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt_itens = $pdo->prepare("SELECT i.*, p.nome FROM pedido_itens i JOIN produtos p ON i.produto_id = p.id WHERE i.pedido_id = ?");
                        $stmt_itens->execute([$ped['id']]);
                        while($item = $stmt_itens->fetch()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome']) ?></td>
                            <td><?= $item['quantidade'] ?>x</td>
                            <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; endif; ?>
<?php require_once 'includes/footer.php'; ?>