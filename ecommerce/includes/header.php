<?php 
session_start();
require_once __DIR__ . '/../config/conexao.php';
$total_carrinho = isset($_SESSION['carrinho']) ? array_sum($_SESSION['carrinho']) : 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>TechK | Sua loja de tecnologia</title>
    
    <!-- Ícone da loja (um microchip/tecnologia) -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1055/1055666.png" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        
        /* Barra superior preta */
        .navbar { background-color: #0d0d0d; border-bottom: 3px solid #dc3545; }
        
        /* Efeito dos cards */
        .card-produto { transition: 0.3s; border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-produto:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(220, 53, 69, 0.3); border-color: #dc3545; }
        
        /* Botão de comprar vermelho */
        .btn-comprar { background-color: #dc3545; color: white; border: none; font-weight: bold; }
        .btn-comprar:hover { background-color: #a71d2a; color: white; }
        
        /* Preço em destaque */
        .preco { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/1055/1055666.png" alt="Logo" width="30" height="30">
            TechK
        </a>
        <div class="ms-auto text-white align-items-center d-flex gap-3">
            <?php if(isset($_SESSION['usuario_nome'])): ?>
                <span>Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>!</span>
                <?php if(isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'admin'): ?>
                    <a href="admin.php" class="btn btn-outline-light btn-sm fw-bold border-2">Painel Admin</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Sair</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light btn-sm">Entrar</a>
            <?php endif; ?>
            <a href="carrinho.php" class="btn btn-danger btn-sm fw-bold">🛍️ Carrinho (<?= $total_carrinho ?>)</a>
        </div>
    </div>
</nav>
<div class="container pb-5">