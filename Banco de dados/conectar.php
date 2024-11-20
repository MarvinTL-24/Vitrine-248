<?php
$servername = "localhost"; // ou o IP do seu servidor
$username = "root"; // usuário do banco de dados
$password = ""; // senha do banco de dados
$dbname = "loja"; // nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
