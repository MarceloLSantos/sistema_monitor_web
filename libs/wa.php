<?php
session_start();
if (!isset($_SESSION['logged_in']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}

require '../config/db.php';
require '../app/models/BaseModel.php';
require '../app/models/ClienteModel.php';
require '../app/models/FluxoVendaModel.php';
require '../app/models/HistoricoMensagensModel.php';
require '../app/models/ProdutoModel.php';
require '../app/controllers/PropostaController.php';

// ### libs/wa.php (placeholder; replace with real implementation)
function wa_send($telefone, $mensagem) {
    // Gerar URL para WhatsApp Web
    $telefone = preg_replace('/\D/', '', $telefone); // Remove caracteres não numéricos
    $mensagem = urlencode($mensagem);
    $url = "https://wa.me/{$telefone}?text={$mensagem}";

    // Retorna link HTML para abrir em nova aba
    header("Location: $url");
    exit;
}

if (isset($_GET['num_proposta'])) {
    $fluxoVendaModel = new FluxoVendaModel();
    $clienteModel = new ClienteModel();
    $propostaController = new PropostaController();
    $produtoModel = new ProdutoModel();
    $statusClienteModel = new StatusClienteModel();
    $statusFaturaModel = new StatusFaturaModel();

    $num_proposta = $_GET['num_proposta'];
    $id_produto = null;
    $proposta = null;
    $cliente = null;

    if ($num_proposta) {
        $proposta = $fluxoVendaModel->getByNum($num_proposta);
        $statusCliente = $statusClienteModel->getAll();
        $statusFatura = $statusFaturaModel->getAll();
        $post = [];
        if ($proposta) {
            $post['id_produto'] = $proposta['id_produto'];
            $cliente = $clienteModel->getById($proposta['id_cliente']);
            $post['id_status_cliente'] = $proposta['id_status_cliente'];
            $post['id_status_1a_fatura'] = $proposta['id_status_1a_fatura'];
        } else {
            $error = "Proposta não encontrada.";
        }
    }

    $mensagem = $propostaController->handleMensagens($proposta, $cliente, $post);
    $telefone = '55' . $cliente['contato1_cliente'];

    if ($mensagem) {
        wa_send($telefone, $mensagem);
    } else {
        echo "Não há mensagem para ser enviara para o cliente {$cliente["nome_cliente"]}.";
    }
}
?>