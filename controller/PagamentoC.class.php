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
    $ftpdata->setFtp_pasta("/ArqVendas/");
    $arquivos = $ftpc->listaArquivos($ftpdata);
    
    //se existir arquivos; já ta em obj?
    if ($arquivos != null) {
      foreach ($arquivos as $compra) {
        //baixa o arquivo
        $array = explode("/", $compra);
        $ftpdata->setFtp_arquivo($array[2]);
        $ftpdata->setLocal_arquivo("/var/www/html/Pagamento/docs/".$array[2]);
        $ftpc->baixaArquivo($ftpdata);
        //le e coloca no objeto
        
        $linha = $this->leArqCompra($ftpdata);
        $obj_venda = $this->criaObjetoVenda($linha);
        
        //verifica se é cartao ou boleto
        if ($obj_venda->getTipo_pagamento() == 1) {
          $modo_pagamento = $this->criaObjetoCartao($linha);
        }
        else {
          $boletoc = new BoletoC();
          $modo_pagamento = $boletoc->criaInfoBoleto($obj_venda);
        }
      $this->realizaPagamento($modo_pagamento, $obj_venda);
      
      //exclui o arquivo
      $ftpc->excluiArquivo($ftpdata);
      }
    }
    exit;
//    $parametros["view"]= "telaHome";
//    $parametros["msg"]="Processo finalizado.";
//    return $parametros;
  }

  private function leArqCompra($ftpdata) {
    //abrir arquivo
    $arquivo = fopen($ftpdata->getLocal_arquivo(), 'r');
    $linha = fgets($arquivo);
    return $linha;
  }

  private function criaObjetoVenda($linha) {
    $array_venda = explode(";", $linha);
    $objVenda = new TAB_PAGAMENTO();
    $objVenda->setId_compra($array_venda[0]);
    $objVenda->setValor_compra($array_venda[1]);
    $objVenda->setData_compra($array_venda[2]);
    if($array_venda[3] == 'cartao'){
      $objVenda->setTipo_pagamento(1);
    }
    else{
      $objVenda->setTipo_pagamento(2);
    }
    $objVenda->setParcelas($array_venda[4]);
    $objVenda->setValor_desconto($array_venda[5]);
    $objVenda->setId_cliente($array_venda[6]);
    return $objVenda;
  }

  private function criaObjetoCartao($linha) {
    $array_venda = explode(";", $linha);
    $objCartao = new TAB_PAGAMENTO_CARTOES();
    $objCartao->setNome_no_cartao($array_venda[7]);
    $objCartao->setNumero($array_venda[8]);
    $objCartao->setBandeira($array_venda[9]);
    $objCartao->setId_compra($array_venda[0]);
    $objCartao->setId_tipo_pagamento(1);
    return $objCartao;
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
    }//se não, é por boleto
    else {
      //só realiza o pagamento e grava
      $log = new TAB_LOG_PAGAMENTO();
      $log->setId_compra($compra->getId_compra());
      $log_atualizada = $this->criaLogBoleto($log, $modo_pagamento);
      $array_arquivo = $this->gravaResultadoPagamento($log_atualizada);
      $ftpC = new FtpC();
      $envioftp = $ftpC->enviarArquivo($array_arquivo);
    }
    return true;
  }

  private function gravaResultadoPagamento(TAB_LOG_PAGAMENTO $log) {
    //Grava arquivo com a log do pagamento
    $texto = "id_compra:" . $log->getId_compra() . ";"
            . "pago:" . $log->getPago() . ";"
            . "status_pagamento:" . $log->getStatus_pagamento() . ";";
    if ($log->getNumero_cartao() != null) {
      $texto.= "numero_cartao:" . $log->getNumero_cartao() . ";";
    }
    else {
      $texto.= "cod_barras_boleto:" . $log->getCod_barras_boleto() . ";";
    }
    $texto.= "valor_parcela:" . $log->getValor_parcela() . ";"
            . "data_pagamento:" . $log->getData_pagamento() . ";"
            . "valor_total:" . $log->getValor_total()
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

  private function criaLogBoleto(TAB_LOG_PAGAMENTO $log, $modo_pagamento) {
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
