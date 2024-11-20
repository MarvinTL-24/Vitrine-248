<?php
session_start();

// Verifique se o carrinho já existe, senão crie-o
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionando um produto ao carrinho
if (isset($_GET['add_to_cart'])) {
    $produto_id = $_GET['produto_id'];
    $quantidade = $_GET['quantidade'];

    // Verifica se o produto já está no carrinho
    if (isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
    } else {
        // Se não está no carrinho, adiciona-o
        $_SESSION['carrinho'][$produto_id] = [
            'quantidade' => $quantidade,
            'preco' => $_GET['preco'],
            'nome' => $_GET['nome'],
            'imagem' => $_GET['imagem']
        ];
    }
    
    // Redireciona o usuário para a página do carrinho
    header('Location: carrinho.php');
    exit();
}
?>
