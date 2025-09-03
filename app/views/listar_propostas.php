<?php include 'app/views/layouts/main.php'; ?>
<div class="container-fluid my-4">
    <h4 class="container-fluid border rounded text-center mb-4 fw-bold bg-dark bg-opacity-10 text-dark text-opacity-50">PROPOSTAS</h4>
    <div class="table-responsive border rounded px-1" style="overflow-y: auto;">
        <table class="table table-striped small text-center" style="font-size: 0.75rem; table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>CONTA</th>
                    <th>PROPOSTA</th>
                    <th>VENDEDOR</th>
                    <th>PRODUTO</th>
                    <th>STATUS</th>
                    <th>DATA HABILITAÇÃO</th>
                    <th>DATA 1a FATURA</th>
                    <th>STATUS 1a FATURA</th>
                    <th>DATA 2a FATURA</th>
                    <th>STATUS 2a FATURA</th>
                    <th>DATA 3a FATURA</th>
                    <th>STATUS 3a FATURA</th>
                    <th>APURAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $historicoModel = new HistoricoMensagensModel();
                foreach ($propostas as $row):
                    $data_1a_style = '';
                    if ($row['data_1a_fatura']) {
                        $enviada = $historicoModel->checkEnviada($row['num_proposta'], 'STATUS_1_FATURA');
                        $days_diff = (strtotime(date('Y-m-d')) - strtotime($row['data_1a_fatura'])) / (60 * 60 * 24);
                        if ($enviada) {
                            $data_1a_style = 'background-color: green; color: white; font-weight: bold;';
                        } elseif ($row['status_1a_fatura'] == 'PAGO') {
                            $data_1a_style = 'background-color: blue; color: white; font-weight: bold;';
                        } elseif ($days_diff >= 5 && $row['status_1a_fatura'] == 'PENDENTE') {
                            $data_1a_style = 'background-color: red; color: white; font-weight: bold;';
                        } else {
                            $data_1a_style = 'background-color: yellow; color: black; font-weight: bold;';
                        }
                    }
                    $data_2a_style = '';
                    if ($row['data_2a_fatura']) {
                        $enviada = $historicoModel->checkEnviada($row['num_proposta'], 'STATUS_2_FATURA');
                        $days_diff = (strtotime(date('Y-m-d')) - strtotime($row['data_2a_fatura'])) / (60 * 60 * 24);
                        if ($enviada) {
                            $data_2a_style = 'background-color: green; color: white; font-weight: bold;';
                        } elseif ($row['status_2a_fatura'] == 'PAGO') {
                            $data_2a_style = 'background-color: blue; color: white; font-weight: bold;';
                        } elseif ($days_diff >= 2 && $row['status_2a_fatura'] == 'PENDENTE') {
                            $data_2a_style = 'background-color: red; color: white; font-weight: bold;';
                        } else {
                            $data_2a_style = 'background-color: yellow; color: black; font-weight: bold;';
                        }
                    }
                    $data_3a_style = '';
                    if ($row['data_3a_fatura']) {
                        $enviada = $historicoModel->checkEnviada($row['num_proposta'], 'STATUS_3_FATURA');
                        $days_diff = (strtotime(date('Y-m-d')) - strtotime($row['data_3a_fatura'])) / (60 * 60 * 24);
                        if ($enviada) {
                            $data_3a_style = 'background-color: green; color: white; font-weight: bold;';
                        } elseif ($row['status_3a_fatura'] == 'PAGO') {
                            $data_3a_style = 'background-color: blue; color: white; font-weight: bold;';
                        } elseif ($days_diff >= 2 && $row['status_3a_fatura'] == 'PENDENTE') {
                            $data_3a_style = 'background-color: red; color: white; font-weight: bold;';
                        } else {
                            $data_3a_style = 'background-color: yellow; color: black; font-weight: bold;';
                        }
                    }
                    $meses = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];
                    $apuracao = $row['mes_apuracao'] ? $meses[$row['mes_apuracao'] - 1] : '';
                ?>
                    <tr>
                        <td><?php echo $row['nome_cliente']; ?></td>
                        <td><?php echo $row['conta_cliente'] ?: ''; ?></td>
                        <td><a href="index.php?page=atualizar_proposta&num_proposta=<?php echo $row['num_proposta']; ?>"><?php echo $row['num_proposta']; ?></a></td>
                        <td><?php echo $row['nome_vendedor']; ?></td>
                        <td><?php echo $row['descricao_produto']; ?></td>
                        <td><?php echo $row['descricao_status_cliente']; ?></td>
                        <td><?php echo $row['data_habilitacao'] ? date('d/m/Y', strtotime($row['data_habilitacao'])) : ''; ?></td>
                        <td style="<?php echo $data_1a_style; ?>">
                            <?php if (strpos($data_1a_style, 'red') > 0) { ?>
                            <a href="./libs/wa.php?num_proposta=<?php echo $row['num_proposta']; ?>&id_tipo_status_fatura=1" target="_blank" style="<?php echo $data_1a_style; ?>">
                            <?php } ?>
                                <?php echo $row['data_1a_fatura'] ? date('d/m/Y', strtotime($row['data_1a_fatura'])) : ''; ?>
                            <?php if (strpos($data_1a_style, 'red') > 0) { ?>
                            </a>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['status_1a_fatura']; ?></td>
                        <td style="<?php echo $data_2a_style; ?>">
                            <?php if (strpos($data_2a_style, 'red') > 0) { ?>
                            <a href="./libs/wa.php?num_proposta=<?php echo $row['num_proposta']; ?>&id_tipo_status_fatura=2" target="_blank" style="<?php echo $data_2a_style; ?>">
                            <?php } ?>
                                <?php echo $row['data_2a_fatura'] ? date('d/m/Y', strtotime($row['data_2a_fatura'])) : ''; ?>
                            <?php if (strpos($data_2a_style, 'red') > 0) { ?>
                            </a>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['status_2a_fatura']; ?></td>
                        <td style="<?php echo $data_3a_style; ?>">
                            <?php if (strpos($data_3a_style, 'red') > 0) { ?>
                            <a href="./libs/wa.php?num_proposta=<?php echo $row['num_proposta']; ?>&id_tipo_status_fatura=3" target="_blank" style="<?php echo $data_3a_style; ?>">
                            <?php } ?>
                                <?php echo $row['data_3a_fatura'] ? date('d/m/Y', strtotime($row['data_3a_fatura'])) : ''; ?>
                            <?php if (strpos($data_3a_style, 'red') > 0) { ?>
                            </a>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['status_3a_fatura']; ?></td>
                        <td><?php echo $apuracao; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    // Mostrar largura total da tabela e da tela no console
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('table');
        const tableWidth = table.offsetWidth;
        const screenWidth = window.innerWidth;
        // alert('Largura da tabela: ' + tableWidth + ' px\nLargura da tela: ' + screenWidth + ' px');
    });
</script>


<?php include 'app/views/layouts/footer.php'; ?>