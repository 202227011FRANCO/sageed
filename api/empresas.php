<?php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

switch ($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM empresas ORDER BY nombre");
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO empresas (nombre, giro, rfc, contacto) VALUES (:nombre, :giro, :rfc, :contacto)");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':giro' => $data['giro'],
            ':rfc' => $data['rfc'],
            ':contacto' => $data['contacto']
        ]);
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Empresa registrada'], 201);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}