<?php 
session_start();
require_once 'config/conexao.php';
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') { header('Location: login.php'); exit; }
require_once 'includes/header.php'; 
?>
<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <h2 class="fw-bold text-danger">Painel Administrativo</h2>
    <a href="admin_produto.php" class="btn btn-success fw-bold">+ Novo Produto</a>
</div>
<div class="card shadow border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr><th>ID</th><th>Produto</th><th>Preço</th><th>Estoque</th><th>Status</th><th class="text-center">Ações</th></tr>
            </thead>
            <tbody>
                <?php $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC"); while($p = $stmt->fetch()): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><?= $p['estoque'] ?> un.</td>
                    <td><?= $p['ativo'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-danger">Inativo</span>' ?></td>
                    <td class="text-center">
                        <a href="admin_produto.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="admin_excluir.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 mb-5">
    <a href="admin_pedidos.php" class="btn btn-outline-dark fw-bold">Ver Pedidos dos Clientes</a>
</div>
<?php require_once 'includes/footer.php'; ?>