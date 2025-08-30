<?php
// ### public/index.php (router)
session_start();
if (!isset($_SESSION['logged_in']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}

require 'config/db.php';
require 'app/models/BaseModel.php';  // Autoload if possible
require 'app/models/ClienteModel.php';
require 'app/models/FluxoVendaModel.php';
require 'app/models/HistoricoMensagensModel.php';
require 'app/models/ProdutoModel.php';
require 'app/models/UsuarioModel.php';
require 'app/controllers/AuthController.php';
require 'app/controllers/PropostaController.php';
// require 'libs/wa.php';  // WhatsApp library (placeholder)
// Require other models and controllers as needed

$page = $_GET['page'] ?? 'listar_propostas';

$authController = new AuthController();
$propostaController = new PropostaController();

switch ($page) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'cadastro_proposta':
        $propostaController->cadastro();
        break;
    case 'atualizar_proposta':
        $propostaController->atualizar();
        break;
    case 'listar_propostas':
        $propostaController->listar();
        break;
    case 'excluir_proposta':
        $propostaController->excluir();
        break;
    default:
        echo "Página não encontrada";
}
?>