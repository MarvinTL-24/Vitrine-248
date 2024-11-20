<?php
session_start();

// Dados do item enviados via POST
$item = [
    'id' => $_POST['id'],
    'nome' => $_POST['nome'],
    'tipo' => $_POST['tipo'],
    'tamanho' => $_POST['tamanho'] ?? 'Padrão',
    'quantidade' => $_POST['quantidade'],
    'preco' => $_POST['preco'],
    'imagem' => $_POST['imagem'] // URL da imagem enviada
];

// Inicialize o carrinho, se necessário
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Validação da quantidade total
$totalQuantidade = array_sum(array_column($_SESSION['carrinho'], 'quantidade')) + $item['quantidade'];
if ($totalQuantidade > 5) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Quantidade acima do limite. Confirme pelo WhatsApp.']);
    exit;
}

// Adiciona o item ao carrinho
$_SESSION['carrinho'][] = $item;

echo json_encode(['status' => 'sucesso', 'mensagem' => 'Item adicionado com sucesso!']);
