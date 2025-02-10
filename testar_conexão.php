<?php
$host = '127.0.0.1';
$db   = 'rastreamento_dispositivos';
$user = 'root';
$pass = '';
$port = '3306';

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>
