<?php
session_start();

// Exemplo de como o carrinho poderia ser estruturado (geralmente, seria preenchido por algum processo de adicionar ao carrinho)
if (empty($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>
    <?php if (empty($_SESSION['produtos'])): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Tamanho</th>
                <th>Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['produtos'] as $produto_id => $produto):
                $subtotal = $produto['quantidade'] * $produto['valor'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $produto['modelo']; ?></td>
                    <td>R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['tamanho']; ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
    <?php endif; ?>
</body>
</html>
