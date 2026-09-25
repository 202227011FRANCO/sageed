<?php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

switch ($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM competencias ORDER BY created_at DESC");
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO competencias (carrera, codigo, descripcion) VALUES (:carrera, :codigo, :descripcion)");
        $stmt->execute([
            ':carrera' => $data['carrera'],
            ':codigo' => $data['codigo'],
            ':descripcion' => $data['descripcion']
        ]);
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Competencia registrada'], 201);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}