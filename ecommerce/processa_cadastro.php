<?php
require_once 'config/conexao.php';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, 'cliente')");
    $stmt->execute([$nome, $email, $senha_hash]);
    header('Location: login.php'); exit;
} catch (PDOException $e) {
    echo "<script>alert('E-mail já cadastrado!'); window.location='cadastro.php';</script>"; exit;
}
?>