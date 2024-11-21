<?php
session_start();

// Verifica se há mensagens de sucesso ou erro na sessão
if (isset($_SESSION["insert"])) {
    if ($_SESSION["insert"] == "1") {
        unset($_SESSION["insert"]);
        echo "<script>alert('Produto cadastrado com sucesso!');</script>";
    } elseif ($_SESSION["insert"] == "2") {
        unset($_SESSION["insert"]);
        echo "<script>alert('Erro ao tentar cadastrar!');</script>";
    }
}

include_once("head.html.php");  // Inclui o cabeçalho com o Bootstrap
include_once("conectar.php");   // Inclui a conexão com o banco de dados


// Exibe o formulário
echo "
<body>
    <div class='container mt-5'>
        <form action='adicionar.php' method='post' enctype='multipart/form-data'>
            <div class='card'>
                <div class='card-header text-center'>
                    <h2>Cadastro de Produto</h2>
                </div>
                <div class='card-body'>
                    <div class='mb-3'>
                        <label for='modelo' class='form-label'>Modelo:</label>
                        <input type='text' name='modelo' class='form-control' required>
                    </div>
                    <div class='mb-3'>
                        <label for='valor' class='form-label'>Valor:</label>
                        <input type='number' name='valor' step='0.01' class='form-control' required>
                    </div>
                    <div class='mb-3'>
                        <label for='tamanho' class='form-label'>Tamanho:</label>
                        <input type='text' name='tamanho' class='form-control' required>
                    </div>
                    
                    <div class='mb-3'>
                        <label for='imagem' class='form-label'>Escolha uma imagem:</label>
                        <input type='file' name='imagem' id='imagem' class='form-control' accept='image/*' required>
                    </div>
                    <input type='hidden' name='agir'
                    <button type='submit' class='btn btn-primary'>Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</body>
";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se a imagem foi carregada corretamente
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Define o diretório para upload
        $pasta = 'images/';
        
        // Verifica se o diretório existe, se não, cria
        if (!is_dir($pasta)) {
            if (!mkdir($pasta, 0777, true)) {
                die('Falha ao criar diretório de uploads.');
            }
        }

        // Gerar um modelo único para o arquivo
        $imagemmodelo = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $imagemPath = $pasta . $imagemmodelo;

        // Verifica se o arquivo é uma imagem válida
        $infoImagem = getimagesize($_FILES['imagem']['tmp_name']);
        if ($infoImagem !== false) {
            // Tenta mover o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
                // Recebe os dados do formulário
                $modelo = $_POST["modelo"];
                $valor = $_POST["valor"]; // Gera o hash da valor
                $tamanho = $_POST["tamanho"];
                

                // Prepara a consulta SQL para inserir no banco de dados
                $sql = "INSERT INTO Produtos (modelo, valor, tamanho, imagem) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Erro na preparação da consulta: " . $conn->error);
                }

                // Faz o bind dos parâmetros e executa a consulta
                $stmt->bind_param("ssss", $modelo, $valor, $tamanho, $imagemPath);
                if ($stmt->execute()) {
                    $_SESSION["insert"] = "1"; // Sucesso
                    header('Location: Produtos.html.php');
                    exit;
                } else {
                    $_SESSION["insert"] = "2"; // Erro
                    header('Location: Produtos.html.php');
                    exit;
                }
            } else {
                echo "Erro ao mover o arquivo para o diretório de uploads.";
            }
        } else {
            echo "O arquivo enviado não é uma imagem válida.";
        }
    } else {
        echo "Nenhum arquivo enviado ou houve erro no envio da imagem.";
    }
}
?>