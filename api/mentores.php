<?php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();
$tipo = $_GET['tipo'] ?? 'academicos'; // academicos | ue

switch ($method) {
    case 'GET':
        if ($tipo === 'academicos') {
            $stmt = $db->query("SELECT * FROM mentores_academicos ORDER BY nombre");
        } else {
            $stmt = $db->query("
                SELECT mu.*, e.nombre AS empresa_nombre
                FROM mentores_ue mu
                LEFT JOIN empresas e ON mu.empresa_id = e.id
                ORDER BY mu.nombre
            ");
        }
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($tipo === 'academicos') {
            $stmt = $db->prepare("INSERT INTO mentores_academicos (nombre, area, telefono, correo) VALUES (:nombre, :area, :telefono, :correo)");
            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':area' => $data['area'],
                ':telefono' => $data['tel'],
                ':correo' => $data['correo']
            ]);
        } else {
            $stmt = $db->prepare("INSERT INTO mentores_ue (nombre, empresa_id, cargo, correo) VALUES (:nombre, :empresa_id, :cargo, :correo)");
            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':empresa_id' => $data['empresaId'],
                ':cargo' => $data['cargo'],
                ':correo' => $data['correo']
            ]);
        }
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Mentor registrado'], 201);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}