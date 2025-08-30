<?php include 'app/views/layouts/main.php'; ?>
<div class="container-fluid mt-4">
    <h4 class="container-fluid border rounded text-center mb-4 fw-bold bg-dark bg-opacity-10 text-dark text-opacity-50">CADASTRAR NOVA PROPOSTA</h4>
    <!-- <h3 class="text-center mb-4 fw-bold text-dark text-opacity-50">CADASTRAR NOVA PROPOSTA</h3> -->
    <form method="post" class="needs-validation border rounded p-4" novalidate>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nome_cliente" class="form-label"><strong>NOME DO CLIENTE</strong></label>
                    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                    <div class="invalid-feedback">Por favor, insira o nome do cliente.</div>
                </div>
                <div class="mb-3">
                    <label for="contato1" class="form-label"><strong>CONTATO 1 (CELULAR)</strong></label>
                    <input type="tel" class="form-control" id="contato1" name="contato1" pattern="\d{11}" placeholder="11912345678" required>
                    <div class="invalid-feedback">Insira um número de celular válido (11 dígitos, ex.: 11912345678).</div>
                </div>
                <div class="mb-3">
                    <label for="cpf_cliente" class="form-label"><strong>CPF DO CLIENTE</strong></label>
                    <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="123.456.789-00" required>
                    <div class="invalid-feedback">Insira um CPF válido (ex.: 123.456.789-00).</div>
                </div>
                <div class="mb-3">
                    <label for="nome_vendedor" class="form-label"><strong>NOME VENDEDOR</strong></label>
                    <select class="form-select" id="nome_vendedor" name="id_vendedor" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($vendedores as $vendedor): ?>
                            <option value="<?php echo $vendedor['id_vendedor']; ?>"><?php echo $vendedor['nome_vendedor']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecione um vendedor.</div>
                </div>
                <div class="mb-3">
                    <label for="id_status_cliente" class="form-label"><strong>STATUS CLIENTE</strong></label>
                    <select class="form-select" id="id_status_cliente" name="id_status_cliente" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($statusClientes as $status): ?>
                            <option value="<?php echo $status['id_status_cliente']; ?>"><?php echo $status['descricao_status_cliente']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecione o status do cliente.</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="num_proposta" class="form-label"><strong>NÚMERO DA PROPOSTA</strong></label>
                    <input type="number" class="form-control" id="num_proposta" name="num_proposta" min="1" required>
                    <div class="invalid-feedback">Insira um número de proposta válido.</div>
                </div>
                <div class="mb-3">
                    <label for="contato2" class="form-label"><strong>CONTATO 2 (CELULAR)</strong></label>
                    <input type="tel" class="form-control" id="contato2" name="contato2" pattern="\d{11}" placeholder="11912345678">
                    <div class="invalid-feedback">Insira um número de celular válido (11 dígitos, ex.: 11912345678).</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><strong>EMAIL DO CLIENTE</strong></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@dominio.com">
                    <div class="invalid-feedback">Insira um email válido.</div>
                </div>
                <div class="mb-3">
                    <label for="id_produto" class="form-label"><strong>PRODUTO</strong></label>
                    <select class="form-select" id="id_produto" name="id_produto" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($produtos as $produto): ?>
                            <option value="<?php echo $produto['id_produto']; ?>"><?php echo $produto['descricao_produto']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecione um produto.</div>
                </div>
                <div class="mb-3">
                    <label for="data_cadastro" class="form-label"><strong>DATA DE CADASTRO</strong></label>
                    <input type="date" class="form-control" id="data_cadastro" name="data_cadastro" required>
                    <div class="invalid-feedback">Selecione a data de cadastro.</div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success mt-3"><?php echo $success; ?></div>
        <?php endif; ?>
    </form>
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