<?php
include 'conectar.php';

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

$produtos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    echo "0 resultados";
}

$conn->close();
?>
