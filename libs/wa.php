<?php
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

if (isset($_GET['telefone']) && isset($_GET['mensagem'])) {
    $telefone = $_GET['telefone'];
    $mensagem = $_GET['mensagem'];
    wa_send($telefone, $mensagem);
}
?>