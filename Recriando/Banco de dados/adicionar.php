<?php
session_start();

// Dados do item enviados via POST
$item = [
    'id' => $_POST['id'],
    'modelo' => $_POST['modelo'],
    'tamanho' => $_POST['tamanho'] ?? 'Padrão',
    'quantidade' => $_POST['quantidade'],
    'valor' => $_POST['valor'],
    'imagem' => $_POST['imagem'] // URL da imagem enviada
];

// Inicialize o produtos, se necessário
if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}

// Validação da quantidade total
$totalQuantidade = array_sum(array_column($_SESSION['produtos'], 'quantidade')) + $item['quantidade'];
if ($totalQuantidade > 5) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Quantidade acima do limite. Confirme pelo WhatsApp.']);
    exit;
}

// Adiciona o item ao produtos
$_SESSION['produtos'][] = $item;

echo json_encode(['status' => 'sucesso', 'mensagem' => 'Item adicionado com sucesso!']);
