<?php
session_start();
require_once 'config/conexao.php';
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') { exit; }
$id = (int)$_POST['id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = (float)$_POST['preco'];
$estoque = (int)$_POST['estoque'];
$imagem = $_POST['imagem'];
$ativo = isset($_POST['ativo']) ? 1 : 0;
if($id > 0) {
    $stmt = $pdo->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, imagem=?, ativo=? WHERE id=?");
    $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem, $ativo, $id]);
} else {
    $stmt = $pdo->prepare("INSERT INTO produtos (categoria_id, nome, descricao, preco, estoque, imagem, ativo) VALUES (1, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem, $ativo]);
}
header('Location: admin.php'); exit;
?>