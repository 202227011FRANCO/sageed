<?php
// api/mentores_academicos.php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

switch ($method) {
    case 'GET':
        // Devuelve la lista para llenar la barra desplegable
        $stmt = $db->query("SELECT * FROM mentores_academicos ORDER BY nombre ASC");
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        // Guarda un mentor nuevo si usan el botón "+"
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO mentores_academicos (nombre, area, telefono, correo) VALUES (:nombre, :area, :telefono, :correo)");
        $stmt->execute([
            ':nombre'   => $data['nombre'],
            ':area'     => $data['area'],
            ':telefono' => $data['tel'] ?? $data['telefono'], 
            ':correo'   => $data['correo']
        ]);
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Mentor Académico registrado'], 201);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}