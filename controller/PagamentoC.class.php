<?php

/**
 * Description of PagamentoC
 *
 * @author day
 */
class PagamentoC {

  public function verificaNovaCompra() {
    $vw_pagamentoDAO = new VW_TAB_PAGAMENTO_DAO();
    //vai na tab_log_pagamento
    $logPagamentoDAO = new TAB_LOG_PAGAMENTO_DAO();
    $ultimo_codigo = $logPagamentoDAO->buscarUltimoCodigo();

    //se for nulo não existem logs, buscar todos os registros de compra
    if ($ultimo_codigo[0] == null) {
      //busca todas as compras
      $compras = $vw_pagamentoDAO->buscarTodos();

      //Se for diferente de null, é porque existe compra
      if ($compras != null) {//Para cada compra encontrada, ir para o tipo de pagamento
        foreach ($compras as $compra) {
          $this->verificaTipoPagamento($compra);
        }
      }
    }//se não, pega esse ultimo id
    else {
      //procura na view tab_pagamento se tem alguma compra dps desse id
      $proximos_codigos = $vw_pagamentoDAO->buscarApartirDe($ultimo_codigo[0]);
      if ($proximos_codigos != null) {
        foreach ($proximos_codigos as $proxima_compra) {
          $this->verificaTipoPagamento($proxima_compra);
        }
      }
    }
    echo "fim";
    //se não, finalizar
    //se sim, ir para o método de buscar compras.
  }

  public function buscaUltimasCompras($parametros) {
    //Pegar todo mundo pra frente do codigo recebido
    //para cada dado, verificar o tipo de pagamento
    //Se 1, então cartao de credito
    //se 2, então boleto
  }

  public function verificaTipoPagamento(VW_TAB_PAGAMENTO $compra) {
    $tipo_pagamento = $compra->getTipo_pagamento();
    switch ($tipo_pagamento) {
      case 1://Se for 1, é cartao de credito
        $cartaoc = new CartaoC();
        $modo_pagamento = $cartaoc->buscarCartao($compra);
        break;
      case 2://se for 2, é boleto
        $boletoc = new BoletoC();
        $modo_pagamento = $boletoc->criaInfoBoleto($compra);
        break;
    }
    $this->realizaPagamento($modo_pagamento, $compra);
  }

  public function realizaPagamento($modo_pagamento, $compra) {
    //se o pagamento for por cartões
    if ($modo_pagamento instanceof TAB_PAGAMENTO_CARTOES) {
      $cartaoc = new CartaoC();
      //realiza a tentativa de pagamento e já grava os dados
      $resultado_pagamento = $cartaoc->realizaPagamentoCartao($compra, $modo_pagamento);
      //grava o resultado no txt
      $array_arquivo = $this->gravaResultadoPagamento($resultado_pagamento);
      //envia o arquivo por ftp
      $Ftpc = new FtpC();
      $envioftp = $Ftpc->enviarArquivo($array_arquivo);
    }//se não é por boleto
    else {
      
    }
  }

  private function gravaResultadoPagamento(TAB_LOG_PAGAMENTO $log) {
    //Grava arquivo com a log do pagamento
    $texto = $log->getId_compra() . ";"
            . $log->getPago() . ";"
            . $log->getStatus_pagamento() . ";"
            . $log->getNumero_cartao() . ";"
            . $log->getValor_parcela() . ";"
            . $log->getData_pagamento() . ";"
            . $log->getValor_total()
            . "\n";
    //dá pra criar direto no ftp já
    $arquivo = "/var/www/html/Pagamento/docs/";
    $name = "resultadoPagamento_" . $log->getId_compra() . ".txt";
    $file = fopen($arquivo . $name, 'a');
    if ($file == false) {
      die('Não foi possível criar o arquivo.');
    }
    fwrite($file, $texto);
    fclose($file);
    $array_arquivo = array($arquivo, $name);
    return $array_arquivo;
  }

}
