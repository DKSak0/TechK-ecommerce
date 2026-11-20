<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $qtd = (int)$_POST['qtd'];
    
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] += $qtd;
    } else {
        $_SESSION['carrinho'][$id] = $qtd;
    }
}
header('Location: index.php');
exit;
?>