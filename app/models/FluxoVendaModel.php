<?php
// ### app/models/FluxoVendaModel.php
class FluxoVendaModel extends BaseModel {
    public function exists($num_proposta) {
        $stmt = $this->pdo->prepare("SELECT * FROM fluxo_venda WHERE num_proposta = :num");
        $stmt->execute(['num' => $num_proposta]);
        return $stmt->fetch() ? true : false;
    }

    public function getByNum($num_proposta) {
        $stmt = $this->pdo->prepare("SELECT * FROM fluxo_venda WHERE num_proposta = :num");
        $stmt->execute(['num' => $num_proposta]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare("INSERT INTO fluxo_venda (id_cliente, num_proposta, id_produto, id_status_cliente, id_vendedor, data_cadastro, id_status_1a_fatura, id_status_2a_fatura, id_status_3a_fatura) VALUES (:id_cliente, :num_proposta, :id_produto, :id_status_cliente, :id_vendedor, :data_cadastro, 1, 1, 1)");
        $stmt->execute($data);
    }

    public function update($num_proposta, $data) {
        // $stmt = $this->pdo->prepare("UPDATE fluxo_venda SET conta_cliente = :conta_cliente, id_produto = :id_produto, id_status_cliente = :id_status_cliente, id_vendedor = :id_vendedor, data_cadastro = :data_cadastro, data_habilitacao = :data_habilitacao, data_1a_fatura = :data_1a_fatura, id_status_1a_fatura = :id_status_1a_fatura, data_2a_fatura = :data_2a_fatura, id_status_2a_fatura = :id_status_2a_fatura, data_3a_fatura = :data_3a_fatura, id_status_3a_fatura = :id_status_3a_fatura, mes_apuracao = :mes_apuracao WHERE num_proposta = :num_proposta");
        $stmt = $this->pdo->prepare("UPDATE fluxo_venda SET conta_cliente = :conta_cliente, id_produto = :id_produto, id_status_cliente = :id_status_cliente, id_vendedor = :id_vendedor, data_habilitacao = :data_habilitacao, id_status_1a_fatura = :id_status_1a_fatura, id_status_2a_fatura = :id_status_2a_fatura, id_status_3a_fatura = :id_status_3a_fatura, mes_apuracao = :mes_apuracao WHERE num_proposta = :num_proposta");
        $data['num_proposta'] = $num_proposta;
        $stmt->execute($data);
    }

    public function delete($num_proposta) {
        $stmt = $this->pdo->prepare("DELETE FROM fluxo_venda WHERE num_proposta = :num");
        $stmt->execute(['num' => $num_proposta]);
    }

    public function getAllForList() {
        $stmt = $this->pdo->query("SELECT 
            c.nome_cliente, c.contato1_cliente, fv.conta_cliente, fv.num_proposta, v.nome_vendedor, p.descricao_produto, sc.descricao_status_cliente, fv.data_habilitacao, fv.data_1a_fatura, sf1.descricao_status_fatura AS status_1a_fatura, fv.data_2a_fatura, sf2.descricao_status_fatura AS status_2a_fatura, fv.data_3a_fatura, sf3.descricao_status_fatura AS status_3a_fatura, fv.mes_apuracao
            FROM fluxo_venda fv
            JOIN cliente c ON fv.id_cliente = c.id_cliente
            JOIN vendedor v ON fv.id_vendedor = v.id_vendedor
            JOIN produto p ON fv.id_produto = p.id_produto
            JOIN status_cliente sc ON fv.id_status_cliente = sc.id_status_cliente
            JOIN status_fatura sf1 ON fv.id_status_1a_fatura = sf1.id_status_fatura
            JOIN status_fatura sf2 ON fv.id_status_2a_fatura = sf2.id_status_fatura
            JOIN status_fatura sf3 ON fv.id_status_3a_fatura = sf3.id_status_fatura
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>