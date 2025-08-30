<?php
// ### app/models/HistoricoMensagensModel.php
class HistoricoMensagensModel extends BaseModel {
    public function checkEnviada($num_proposta, $tipo) {
        $stmt = $this->pdo->prepare("SELECT * FROM historico_mensagens WHERE num_proposta = :num AND tipo_mensagem = :tipo");
        $stmt->execute(['num' => $num_proposta, 'tipo' => $tipo]);
        return $stmt->fetch() ? true : false;
    }

    public function registrar($data) {
        $stmt = $this->pdo->prepare("INSERT INTO historico_mensagens (num_proposta, tipo_mensagem, data_envio, contato_destino, mensagem) VALUES (:num_proposta, :tipo_mensagem, CURDATE(), :contato_destino, :mensagem)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }
}
?>