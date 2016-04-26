<?php
ini_set('display_errors', true);

require_once 'autoload.php';

$pagamento = new PagamentoC();
$pagamento->verificaNovaCompra();