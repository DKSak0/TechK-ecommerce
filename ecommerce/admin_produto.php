<?php 
session_start();
require_once 'config/conexao.php';
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') { header('Location: login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produto = ['nome'=>'', 'descricao'=>'', 'preco'=>'', 'estoque'=>'', 'imagem'=>'', 'ativo'=>1];
if($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();
}
require_once 'includes/header.php'; 
?>
<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white py-3"><h4 class="mb-0 fw-bold"><?= $id ? 'Editar' : 'Novo' ?> Produto</h4></div>
            <div class="card-body p-4">
                <form action="admin_salvar.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="mb-3"><label class="fw-bold">Nome do Produto</label><input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required></div>
                    <div class="mb-3"><label class="fw-bold">Descrição</label><textarea name="descricao" class="form-control" rows="2"><?= htmlspecialchars($produto['descricao']) ?></textarea></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="fw-bold">Preço (R$)</label><input type="number" step="0.01" name="preco" class="form-control" value="<?= $produto['preco'] ?>" required></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">Estoque</label><input type="number" name="estoque" class="form-control" value="<?= $produto['estoque'] ?>" required></div>
                    </div>
                    <div class="mb-3"><label class="fw-bold">URL da Imagem</label><input type="text" name="imagem" class="form-control" value="<?= htmlspecialchars($produto['imagem']) ?>"></div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="ativo" class="form-check-input" id="ativo" <?= $produto['ativo'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="ativo">Produto Ativo</label>
                    </div>
                    <button type="submit" class="btn btn-danger fw-bold px-4">Salvar</button>
                    <a href="admin.php" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>