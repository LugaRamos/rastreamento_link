<?php
header("Content-Type: application/json");

// Conexão com PostgreSQL
$conn = new PDO("pgsql:host=172.16.10.200;dbname=DBapp_rastreamento", "port=55433", "postgres", "1234");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';

if (!$token) {
    echo json_encode(["erro" => "Token inválido"]);
    exit;
}

// Deletar localização do banco de dados
$query = $conn->prepare("DELETE FROM localizacoes WHERE token = :token");
$query->bindParam(':token', $token);
$query->execute();

echo json_encode(["mensagem" => "Localização excluída com sucesso"]);
?>
