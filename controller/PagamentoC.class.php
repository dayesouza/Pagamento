<?php
/**
 * Description of PagamentoC
 *
 * @author day
 */
class PagamentoC {

  public function verificaNovaCompra() {
    //Verifica se tem arquivos novos com informacoes da compra
    $ftpc = new FtpC();
    $ftpdata = new FTPData();
    $ftpdata->setFtp_pasta("/ArqPagamentos/");
    $arquivos = $ftpc->listaArquivos($ftpdata);
    print_r($arquivos);exit;

    //se existir arquivos; já ta em obj?
    if($arquivos != null){
      foreach ($arquivos as $compra) {
        //gravo em tabela
        //
        //retorno o objeto
        //Verifico o tipo do pagamento com o objeto compra
        $this->verificaTipoPagamento($compraObj);
      }
    }
    echo "Fim do processo.";exit;
  }

  private function verificaTipoPagamento(VW_TAB_PAGAMENTO $compra) {
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
