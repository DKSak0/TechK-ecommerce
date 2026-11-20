<?php
session_start();
require_once 'config/conexao.php';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();
if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['perfil'] = $usuario['perfil'];
    header('Location: index.php'); exit;
} else {
    header('Location: login.php?erro=1'); exit;
}
?>