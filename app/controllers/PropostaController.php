<?php
// ### app/controllers/PropostaController.php
class PropostaController {
    private $clienteModel;
    private $fluxoVendaModel;
    private $historicoModel;
    private $produtoModel;
    private $vendedorModel;
    private $statusClienteModel;
    private $statusFaturaModel;

    public function __construct() {
        $this->clienteModel = new ClienteModel();
        $this->fluxoVendaModel = new FluxoVendaModel();
        $this->historicoModel = new HistoricoMensagensModel();
        $this->produtoModel = new ProdutoModel();
        $this->vendedorModel = new VendedorModel();
        $this->statusClienteModel = new StatusClienteModel();
        $this->statusFaturaModel = new StatusFaturaModel();
    }

    public function cadastro() {
        $produtos = $this->produtoModel->getAll();
        $vendedores = $this->vendedorModel->getAllActive();
        $statusClientes = $this->statusClienteModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate inputs (add more validations as needed)
            $dataCliente = [
                'nome' => $_POST['nome_cliente'],
                'cpf' => preg_replace('/\D/', '', $_POST['cpf_cliente']),  // Strip non-digits
                'contato1' => preg_replace('/\D/', '', $_POST['contato1']),
                'contato2' => preg_replace('/\D/', '', $_POST['contato2']),
                'email' => $_POST['email'] ?? null
            ];
            $num_proposta = $_POST['num_proposta'];

            if ($this->fluxoVendaModel->exists($num_proposta)) {
                $error = "Número da proposta já cadastrado.";
            } else {
                $id_cliente = $this->clienteModel->insert($dataCliente);
                $dataFluxo = [
                    'id_cliente' => $id_cliente,
                    'num_proposta' => $num_proposta,
                    'id_produto' => $_POST['id_produto'],
                    'id_status_cliente' => $_POST['id_status_cliente'],
                    'id_vendedor' => $_POST['id_vendedor'],
                    'data_cadastro' => $_POST['data_cadastro']
                ];
                $this->fluxoVendaModel->insert($dataFluxo);
                $success = "Proposta cadastrada com sucesso!";
            }
        }
        require 'app/views/cadastro_proposta.php';
    }

    public function atualizar() {
        $produtos = $this->produtoModel->getAll();
        $vendedores = $this->vendedorModel->getAllActive();
        $statusClientes = $this->statusClienteModel->getAll();
        $statusFaturas = $this->statusFaturaModel->getAll();

        $num_proposta = $_GET['num_proposta'] ?? null;
        $proposta = null;
        $cliente = null;

        if ($num_proposta) {
            $proposta = $this->fluxoVendaModel->getByNum($num_proposta);
            if ($proposta) {
                $cliente = $this->clienteModel->getById($proposta['id_cliente']);
            } else {
                $error = "Proposta não encontrada.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $proposta) {
            // Similar validations as above
            $dataCliente = [
                // 'nome' => $_POST['nome_cliente'],
                // 'cpf' => preg_replace('/\D/', '', $_POST['cpf_cliente']),
                'contato1' => preg_replace('/\D/', '', $_POST['contato1']),
                'contato2' => preg_replace('/\D/', '', $_POST['contato2']),
                'email' => $_POST['email']
            ];
            $this->clienteModel->update($proposta['id_cliente'], $dataCliente);

            $data_habilitacao = $_POST['data_habilitacao'] ?: null;

            if ($data_habilitacao) {
                $data_1a = $this->addMonths($data_habilitacao, 1);
                $data_2a = $this->addMonths($data_habilitacao, 2);
                $data_3a = $this->addMonths($data_habilitacao, 3);
                $mes_apuracao = date('n', strtotime($this->addMonths($data_habilitacao, 4)));
            } else {
                $data_1a = null;
                $data_2a = null;
                $data_3a = null;
                $mes_apuracao = null;
            }

            $dataFluxo = [
                'conta_cliente' => $_POST['conta_cliente'],
                'id_produto' => $_POST['id_produto'],
                'id_status_cliente' => $_POST['id_status_cliente'],
                'id_vendedor' => $_POST['id_vendedor'],
                'data_habilitacao' => $data_habilitacao,
                'data_1a_fatura' => $data_1a,
                'id_status_1a_fatura' => $_POST['id_status_1a_fatura'],
                'data_2a_fatura' => $data_2a,
                'id_status_2a_fatura' => $_POST['id_status_2a_fatura'],
                'data_3a_fatura' => $data_3a,
                'id_status_3a_fatura' => $_POST['id_status_3a_fatura'],
                'mes_apuracao' => $mes_apuracao
            ];
            $this->fluxoVendaModel->update($num_proposta, $dataFluxo);

            // Mensagens logic (similar to Python)
            // $this->handleMensagens($proposta, $cliente, $_POST);

            $success = "Proposta atualizada com sucesso!";

            header("Location: index.php?page=atualizar_proposta&num_proposta={$num_proposta}&success=" . urlencode($success));
            exit; // or die();
        }

        require 'app/views/atualizar_proposta.php';
    }

    public function excluir() {
        $num_proposta = $_GET['num_proposta'] ?? null;
        $confirm = $_GET['confirm'] ?? 0;
        $error = null;
        $success = null;

        if ($num_proposta) {
            $proposta = $this->fluxoVendaModel->getByNum($num_proposta);
            if ($proposta) {
                if ($confirm == 1) {
                    try {
                        $this->fluxoVendaModel->delete($num_proposta);
                        $success = "Proposta {$num_proposta} excluída com sucesso!";
                    } catch (Exception $e) {
                        $error = "Erro ao excluir proposta: " . $e->getMessage();
                    }
                } else {
                    // Show confirmation message in the view
                }
            } else {
                $error = "Proposta não encontrada.";
            }
        } else {
            $error = "Número da proposta não fornecido.";
        }

        require 'app/views/excluir_proposta.php';
    }
    
    public function handleMensagens($proposta, $cliente, $post) {
        $num_proposta = $proposta['num_proposta'];
        $nome_cliente = $cliente['nome_cliente'];
        $contato1 = $cliente['contato1_cliente'];
        $statusClientes = $this->statusClienteModel->getAll();
        $descricao_produto = (new ProdutoModel())->getById((int)$post['id_produto'])['descricao_produto'];  // Assume getById added
        $descricao_status_cliente = $statusClientes[(int)$post['id_status_cliente'] - 1]['descricao_status_cliente'];
        $status_1a = (int)$post['id_status_1a_fatura'];  // Map to desc if needed

        if ($contato1) {
            $telefone = "55" . $contato1;
            $today = date('Y-m-d');

            // Example for "HABILITADO"
            if ($descricao_status_cliente == 'HABILITADO' && !$this->historicoModel->checkEnviada($num_proposta, 'HABILITADO')) {
                $mensagem = "Seja muito bem-vindo, {$nome_cliente}. Agora que sua instalação foi realizada esperamos que você aproveite todas as vantagens que só a nossa {$descricao_produto} pode oferecer.";
                $result = $this->historicoModel->registrar([
                        'num_proposta' => $num_proposta,
                        'tipo_mensagem' => $tipo_mensagem, //'HABILITADO',
                        'contato_destino' => $telefone,
                        'mensagem' => $mensagem
                ]);
            } else {
                $result = 0;
            }
            // Add other conditions similarly...
            return $result ? $mensagem : $result; // Return last message for testing/logging
        }
    }

    public function listar() {
        $propostas = $this->fluxoVendaModel->getAllForList();
        require 'app/views/listar_propostas.php';
    }

    private function addMonths($date, $months) {
        if (!$date) return null;
        $d = new DateTime($date);
        $d->modify("+$months month");
        return $d->format('Y-m-d');
    }
}
?>