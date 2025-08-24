<?php
// ### public/api.php (RESTful API for reports)
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['logged_in'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';

$fluxoVendaModel = new FluxoVendaModel();

if ($method === 'GET' && $path === 'propostas') {
    $propostas = $fluxoVendaModel->getAllForList();
    echo json_encode($propostas);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
?>