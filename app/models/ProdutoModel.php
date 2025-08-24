<?php
// ### app/models/ProdutoModel.php (similar for StatusClienteModel, StatusFaturaModel, VendedorModel)
class ProdutoModel extends BaseModel {
    public function getAll() {
        $stmt = $this->pdo->query("SELECT id_produto, descricao_produto FROM produto");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT id_produto, descricao_produto FROM produto WHERE id_produto = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class VendedorModel extends BaseModel {
    public function getAllActive() {
        $stmt = $this->pdo->query("SELECT id_vendedor, nome_vendedor FROM vendedor WHERE ativo = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class StatusClienteModel extends BaseModel {
    public function getAll() {
        $stmt = $this->pdo->query("SELECT id_status_cliente, descricao_status_cliente FROM status_cliente");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class StatusFaturaModel extends BaseModel {
    public function getAll() {
        $stmt = $this->pdo->query("SELECT id_status_fatura, descricao_status_fatura FROM status_fatura");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>