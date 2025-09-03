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
    $tipoStatusFaturaModel = new TipoStatusFaturaModel();

    $num_proposta = $_GET['num_proposta'];
    $id_tipo_status_fatura = $_GET['id_tipo_status_fatura'];
    $tipo_status_fatura = $tipoStatusFaturaModel->getAll($id_tipo_status_fatura);
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
            $post['id_tipo_status_fatura'] = $id_tipo_status_fatura;
            $post['id_status_' . $id_tipo_status_fatura . 'a_fatura'] = $proposta['id_status_' . $id_tipo_status_fatura . 'a_fatura'];
            $post['data_' . $id_tipo_status_fatura . 'a_fatura'] = $proposta['data_' . $id_tipo_status_fatura . 'a_fatura'];
            $post['descricao_tipo_status_fatura'] = $tipo_status_fatura[0]['descricao_tipo_status_fatura'];
        } else {
            $error = "Proposta não encontrada.";
        }
    }

    echo (int)$post['id_status_2a_fatura'];
    die();

    $mensagem = $propostaController->handleMensagens($proposta, $cliente, $post);
    $telefone = '55' . $cliente['contato1_cliente'];

    if ($mensagem != '') {
        wa_send($telefone, $mensagem);
    } else {
        echo "Não há mensagem para ser enviara para o cliente {$cliente["nome_cliente"]}.";
    }
}
?>