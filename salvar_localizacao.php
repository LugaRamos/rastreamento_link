<?php
header("Content-Type: application/json");

try {
    // Conexão correta com Banco de dados
    $conn = new PDO("mysql:host=127.0.0.1;port=3306;dbname=rastreamento_dispositivos", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Receber os dados JSON enviados via POST
    $data = json_decode(file_get_contents("php://input"), true);
    $token = $data['token'] ?? '';
    $latitude = $data['latitude'] ?? '';
    $longitude = $data['longitude'] ?? '';

    // Verificar se os dados foram recebidos corretamente
    if (!$token || !$latitude || !$longitude) {
        echo json_encode(["erro" => "Dados inválidos"]);
        exit;
    }

    // Verificar se o token existe no banco
    $query = $conn->prepare("SELECT * FROM localizacoes WHERE token = :token");
    $query->bindParam(':token', $token);
    $query->execute();

    if ($query->rowCount() === 0) {
        echo json_encode(["erro" => "Token não encontrado"]);
        exit;
    }

    var_dump($latitude);

    // Atualizar a localização do usuário no banco
    $query = $conn->prepare("UPDATE localizacoes SET latitude = :latitude, longitude = :longitude, data_captura = NOW() WHERE token = :token");
    $query->bindParam(':latitude', $latitude);
    $query->bindParam(':longitude', $longitude);
    $query->bindParam(':token', $token);
    $query->execute();

    echo json_encode(["mensagem" => "Localização salva com sucesso"]);
} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
}
?>
