<?php include 'app/views/layouts/main.php'; ?>
<div class="container-fluid my-4">
    <h4 class="container-fluid border rounded text-center mb-4 fw-bold bg-dark bg-opacity-10 text-dark text-opacity-50">ATUALIZAR PROPOSTA</h4>
    <!-- <h3 class="text-center mb-4 fw-bold text-dark text-opacity-50">ATUALIZAR PROPOSTA</h3> -->
    <?php if ($_GET['page'] == 'atualizar_proposta' && (!$num_proposta || !$proposta)): ?>
    <form method="get" class="mt-3 border rounded p-3">
        <input type="hidden" name="page" value="atualizar_proposta">
        <div class="mb-3">
            <!-- <label for="num_proposta" class="form-label"><strong>DIGITE O NÚMERO DA PROPOSTA</strong></label> -->
            <input type="number" class="form-control" id="num_proposta" name="num_proposta" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Consultar Proposta</button>
        <br><br>
    </form>
    <?php endif; ?>

    <?php if (!$num_proposta): ?>
        <div class="alert alert-info mt-3">Digite o número da proposta.</div>
    <?php elseif (!$proposta): ?>
        <div class="alert alert-danger">Proposta não encontrada.</div>
    <?php else: ?>
        <form method="post" class="needs-validation border rounded p-4" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome_cliente" class="form-label"><strong>NOME DO CLIENTE</strong></label>
                        <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo $cliente['nome_cliente']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="contato1" class="form-label"><strong>CONTATO 1 (CELULAR)</strong></label>
                        <input type="tel" class="form-control" id="contato1" name="contato1" pattern="\d{11}" value="<?php echo $cliente['contato1_cliente']; ?>" required>
                        <div class="invalid-feedback">Insira um número de celular válido (11 dígitos).</div>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_cliente" class="form-label"><strong>CPF DO CLIENTE</strong></label>
                        <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" value="<?php echo $cliente['cpf_cliente']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nome_vendedor" class="form-label"><strong>NOME VENDEDOR</strong></label>
                        <select class="form-select" id="nome_vendedor" name="id_vendedor" required>
                            <?php foreach ($vendedores as $vendedor): ?>
                                <option value="<?php echo $vendedor['id_vendedor']; ?>" <?php echo $vendedor['id_vendedor'] == $proposta['id_vendedor'] ? 'selected' : ''; ?>><?php echo $vendedor['nome_vendedor']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Selecione um vendedor.</div>
                    </div>
                    <div class="mb-3">
                        <label for="id_status_cliente" class="form-label"><strong>STATUS CLIENTE</strong></label>
                        <select class="form-select" id="id_status_cliente" name="id_status_cliente" required>
                            <?php foreach ($statusClientes as $status): ?>
                                <option value="<?php echo $status['id_status_cliente']; ?>" <?php echo $status['id_status_cliente'] == $proposta['id_status_cliente'] ? 'selected' : ''; ?>><?php echo $status['descricao_status_cliente']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Selecione o status do cliente.</div>
                        <input type="hidden" name="descricao_status_cliente" value="<?php echo $statusClientes[array_search($proposta['id_status_cliente'], array_column($statusClientes, 'id_status_cliente'))]['descricao_status_cliente']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="data_habilitacao" class="form-label"><strong>DATA DE HABILITAÇÃO</strong></label>
                        <input type="date" class="form-control" id="data_habilitacao" name="data_habilitacao" value="<?php echo $proposta['data_habilitacao'] ?: ''; ?>" <?php echo $proposta['id_status_cliente'] != 3 ? 'disabled' : ''; ?>>
                    </div>
                    <div class="mb-3">
                        <label for="data_1a_fatura" class="form-label"><strong>DATA 1a. FATURA</strong></label>
                        <input type="date" class="form-control" id="data_1a_fatura" name="data_1a_fatura" value="<?php echo $proposta['data_1a_fatura'] ?: $this->addMonths($proposta['data_habilitacao'], 1); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="data_2a_fatura" class="form-label"><strong>DATA 2a. FATURA</strong></label>
                        <input type="date" class="form-control" id="data_2a_fatura" name="data_2a_fatura" value="<?php echo $proposta['data_2a_fatura'] ?: $this->addMonths($proposta['data_habilitacao'], 2); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="data_3a_fatura" class="form-label"><strong>DATA 3a. FATURA</strong></label>
                        <input type="date" class="form-control" id="data_3a_fatura" name="data_3a_fatura" value="<?php echo $proposta['data_3a_fatura'] ?: $this->addMonths($proposta['data_habilitacao'], 3); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="mes_apuracao" class="form-label"><strong>MÊS DE APURAÇÃO</strong></label>
                        <select class="form-select" id="mes_apuracao" name="mes_apuracao" disabled>
                            <?php
                            $meses = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];
                            $selected = $proposta['mes_apuracao'] ? $meses[$proposta['mes_apuracao'] - 1] : '';
                            foreach ($meses as $index => $mes): ?>
                                <option value="<?php echo $index + 1; ?>" <?php echo $selected == $mes ? 'selected' : ''; ?>><?php echo $mes; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="num_proposta" class="form-label"><strong>NÚMERO DA PROPOSTA</strong></label>
                        <input type="number" class="form-control" id="num_proposta" name="num_proposta" value="<?php echo $proposta['num_proposta']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="contato2" class="form-label"><strong>CONTATO 2 (CELULAR)</strong></label>
                        <input type="tel" class="form-control" id="contato2" name="contato2" pattern="\d{11}" value="<?php echo $cliente['contato2_cliente']; ?>">
                        <div class="invalid-feedback">Insira um número de celular válido (11 dígitos).</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>EMAIL DO CLIENTE</strong></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $cliente['email_cliente']; ?>">
                        <div class="invalid-feedback">Insira um email válido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="id_produto" class="form-label"><strong>PRODUTO</strong></label>
                        <select class="form-select" id="id_produto" name="id_produto" required>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?php echo $produto['id_produto']; ?>" <?php echo $produto['id_produto'] == $proposta['id_produto'] ? 'selected' : ''; ?>><?php echo $produto['descricao_produto']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Selecione um produto.</div>
                    </div>
                    <div class="mb-3">
                        <label for="data_cadastro" class="form-label"><strong>DATA DE CADASTRO</strong></label>
                        <input type="date" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $proposta['data_cadastro']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="conta_cliente" class="form-label"><strong>CONTA DO CLIENTE</strong></label>
                        <input type="number" class="form-control" id="conta_cliente" name="conta_cliente" value="<?php echo $proposta['conta_cliente'] ?: 0; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="id_status_1a_fatura" class="form-label"><strong>STATUS 1a. FATURA</strong></label>
                        <select class="form-select" id="id_status_1a_fatura" name="id_status_1a_fatura">
                            <?php foreach ($statusFaturas as $status): ?>
                                <option value="<?php echo $status['id_status_fatura']; ?>" <?php echo $status['id_status_fatura'] == $proposta['id_status_1a_fatura'] ? 'selected' : ''; ?>><?php echo $status['descricao_status_fatura']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_status_2a_fatura" class="form-label"><strong>STATUS 2a. FATURA</strong></label>
                        <select class="form-select" id="id_status_2a_fatura" name="id_status_2a_fatura">
                            <?php foreach ($statusFaturas as $status): ?>
                                <option value="<?php echo $status['id_status_fatura']; ?>" <?php echo $status['id_status_fatura'] == $proposta['id_status_2a_fatura'] ? 'selected' : ''; ?>><?php echo $status['descricao_status_fatura']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_status_3a_fatura" class="form-label"><strong>STATUS 3a. FATURA</strong></label>
                        <select class="form-select" id="id_status_3a_fatura" name="id_status_3a_fatura">
                            <?php foreach ($statusFaturas as $status): ?>
                                <option value="<?php echo $status['id_status_fatura']; ?>" <?php echo $status['id_status_fatura'] == $proposta['id_status_3a_fatura'] ? 'selected' : ''; ?>><?php echo $status['descricao_status_fatura']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3" style="width: 150px;">ATUALIZAR</button>
            <button type="button" class="btn btn-primary mt-3" style="width: 150px;" onclick="javascript: location.href='index.php?page=excluir_proposta&num_proposta=<?php echo $num_proposta; ?>&confirm=1'">EXCLUIR</button>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success mt-3"><?php echo $success; ?></div>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</div>
<script>
// Bootstrap form validation
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
<?php include 'app/views/layouts/footer.php'; ?>