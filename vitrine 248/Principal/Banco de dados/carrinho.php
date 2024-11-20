<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>
    <?php if (empty($_SESSION['carrinho'])): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['carrinho'] as $produto_id => $produto):
                $subtotal = $produto['quantidade'] * $produto['preco'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
    <?php endif; ?>
</body>
</html>
