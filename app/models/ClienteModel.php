<?php
// ### app/models/ClienteModel.php
class ClienteModel extends BaseModel {
    public function insert($data) {
        $stmt = $this->pdo->prepare("INSERT INTO cliente (nome_cliente, cpf_cliente, contato1_cliente, contato2_cliente, email_cliente) VALUES (:nome, :cpf, :contato1, :contato2, :email)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        // $stmt = $this->pdo->prepare("UPDATE cliente SET nome_cliente = :nome, cpf_cliente = :cpf, contato1_cliente = :contato1, contato2_cliente = :contato2, email_cliente = :email WHERE id_cliente = :id");
        $stmt = $this->pdo->prepare("UPDATE cliente SET contato1_cliente = :contato1, contato2_cliente = :contato2, email_cliente = :email WHERE id_cliente = :id");
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>