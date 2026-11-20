<?php
session_start();
require_once 'config/conexao.php';
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') { exit; }
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);
header('Location: admin.php'); exit;
?>