<?php
session_start();
require_once 'config/conexao.php';

if(!isset($_SESSION['usuario_id']) || empty($_SESSION['carrinho'])) {
    header('Location: index.php'); exit;
}

$usuario_id = $_SESSION['usuario_id'];
$forma_pagamento = $_POST['pagamento'] ?? 'pix';

try {
    // Inicia a transação no banco (se der erro no meio, cancela tudo)
    $pdo->beginTransaction();

    // 1. Calcula o total novamente por segurança
    $total = 0;
    foreach($_SESSION['carrinho'] as $id => $qtd) {
        $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch();
        $total += ($p['preco'] * $qtd);
    }

    // 2. Cria o Pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, forma_pagamento, total) VALUES (?, ?, ?)");
    $stmt->execute([$usuario_id, $forma_pagamento, $total]);
    $pedido_id = $pdo->lastInsertId();

    // 3. Salva os itens do pedido e dá baixa no estoque
    foreach($_SESSION['carrinho'] as $id => $qtd) {
        $stmt = $pdo->prepare("SELECT preco, estoque FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch();

        // Salva o item (congelando o preço unitário)
        $stmt_item = $pdo->prepare("INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmt_item->execute([$pedido_id, $id, $qtd, $p['preco']]);

        // Baixa no estoque
        $novo_estoque = $p['estoque'] - $qtd;
        $stmt_estoque = $pdo->prepare("UPDATE produtos SET estoque = ? WHERE id = ?");
        $stmt_estoque->execute([$novo_estoque, $id]);
    }

    // Confirma tudo no banco
    $pdo->commit();

    // Limpa o carrinho
    unset($_SESSION['carrinho']);

    // Redireciona para a tela de sucesso
    header('Location: sucesso.php?id=' . $pedido_id);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro ao processar pedido: " . $e->getMessage();
}
?>