<?php
header("Content-Type: application/json");

try {
    $host = "127.0.0.1";
    $port = "3306";
    $dbname = "rastreamento_dispositivos";
    $user = "root";
    $pass = "";

    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass); 
   
    // Gerar um token único
    $token = bin2hex(random_bytes(16));

    // Salvar no banco de dados
    $query = $conn->prepare("INSERT INTO localizacoes (token) VALUES (:token)");
    $query->bindParam(':token', $token);
    $query->execute();

    // Criar o link de rastreamento
    $link = "http://localhost/rastreamento/capturar_localizacao.html?token=$token";

    // O JSON_UNESCAPED_SLASHES impede a barra invertida no JSON
    echo json_encode(["link" => $link], JSON_UNESCAPED_SLASHES);

} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro de conexão: " . $e->getMessage()]);
}
?>
