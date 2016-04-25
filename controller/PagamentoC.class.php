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
      //busca todas as compras no ftp
      //   $compras = $vw_pagamentoDAO->buscarTodos();

      //se achou, grava no banco as compras novas
      
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
    echo "Fim do processo.";exit;
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
      if (!$envioftp){
        //tratar erro
      }
    }//se não, é por boleto
    else {
      //só realiza o pagamento e grava
      $log = new TAB_LOG_PAGAMENTO();
      $log->setId_compra($compra->getId_compra());
      $log_atualizada = $this->criaLogBoleto($log,$modo_pagamento);
      $array_arquivo = $this->gravaResultadoPagamento($log_atualizada);
      $ftpC = new FtpC();
      $envioftp = $ftpC->enviarArquivo($array_arquivo);
      if (!$envioftp){
        //tratar erro
      }
    }
  }

  private function gravaResultadoPagamento(TAB_LOG_PAGAMENTO $log) {
    //Grava arquivo com a log do pagamento
    $texto = "id_compra:".$log->getId_compra() . ";"
            . "pago:".$log->getPago() . ";"
            . "status_pagamento:".$log->getStatus_pagamento() . ";";
            if($log->getNumero_cartao() != null){
              $texto.= "numero_cartao:".$log->getNumero_cartao() . ";";
            }
            else{
              $texto.= "cod_barras_boleto:".$log->getCod_barras_boleto() . ";";
            }
            $texto.= "valor_parcela:".$log->getValor_parcela() . ";"
            . "data_pagamento:".$log->getData_pagamento() . ";"
            . "valor_total:".$log->getValor_total()
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
  
  private function criaLogBoleto(TAB_LOG_PAGAMENTO $log,$modo_pagamento){
    $log->setData_pagamento(date("Y-m-d"));
    $log->setPago("S");
    $log->setStatus_pagamento("Pagamento efetuado");
    $log->setCod_barras_boleto($modo_pagamento->getCod_barras());
    $tabLog = new TAB_LOG_PAGAMENTO_DAO();
    $tabLog->atualizaPagamentoBoleto($log);
    $log_atualizada = $tabLog->buscaLog($log->getId_compra());
    return $log_atualizada[0];
  }

}
