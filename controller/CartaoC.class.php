<?php

class CartaoC {

  public function buscarCartao(VW_TAB_PAGAMENTO $compra) {
    //busca cartão na tabela
    $vw_cartoes = new TAB_PAGAMENTO_CARTOES_DAO();
    
    $cartaoObj = $vw_cartoes->buscaCartaoCompra($compra->getId_compra());
    //Valida os dados do cartão//Não precisa validar pq a tela já faz isso
//    $verificado = $this->validaCartao($cartaoObj[0]);
//    if ($verificado){//se deu tudo certo
    $resultado_pagamento = $this->realizaPagamentoCartao($compra, $cartaoObj);
    //gravo a log pra vendas o resultado
    $this->gravaResultadoPagamento($resultado_pagamento);
    echo "salvo";exit;
    //envio por ftp
//    }
//    else{//se não deu certo, cancelar compra por dados inválidos do cartão
//    }
  }

  private function realizaPagamentoCartao(VW_TAB_PAGAMENTO $compra, TAB_PAGAMENTO_CARTOES $cartaoObj) {
    //grava na log
    $log = new TAB_LOG_PAGAMENTO();
    $log->setId_compra($compra->getId_compra());
    $log->setNumero_cartao($cartaoObj->getNumero());
    $log->setStatus_pagamento("Em andamento");
    $logDAO = new TAB_LOG_PAGAMENTO_DAO();
    $logDAO->salvaLogPagCartao($log);
    
    //realizo contato para verificar se cartão está disponível
    //$paga = $this->contatoBandeira($cartaoObj, $compra);
    $log->setData_pagamento(date('Y-m-d'));
    $log->setPago('S');
    $log->setStatus_pagamento("Efetuado");
    $valor_compra = $compra->getValor_compra() - $compra->getValor_desconto();
    $valor_parcela = $valor_compra/$compra->getParcelas();
    $log->setValor_parcela($valor_parcela);
    $log->setValor_total($valor_compra);
    $logDAO->atualizaPagamento($log);
    //pagamento atualizado
    return $log;
  }

  private function contatoBandeira(VW_TAB_PAGAMENTO $compra, TAB_PAGAMENTO_CARTOES $cartaoObj) {
    //busco o contato com a operadora do cartão
    $tab_bandeira = new TAB_BANDEIRAS_DAO();
    $objBandeira = $tab_bandeira->buscaInfoBandeira($cartaoObj->getId_bandeira());
    
    
  }

  private function respostaOperadora() {
    //fazer um script que roda a cada 15 minutos que contacta a 
    //operadora e verifica se foi aprovado ou não e grava numa tabela
    //daí volta pra cá
  }
  
  private function gravaResultadoPagamento(TAB_LOG_PAGAMENTO $log){
    //Grava arquivo com a log do pagamento
    $texto = $log->getId_compra().";"
            .$log->getPago().";"
            .$log->getStatus_pagamento().";"
            .$log->getNumero_cartao().";"
            .$log->getValor_parcela().";"
            .$log->getData_pagamento().";"
            .$log->getValor_total();
    //dá pra criar direto no ftp já
    $name = "/var/www/html/Pagamento/docs/resultadoPagamento.txt";
    $file = fopen($name, 'a');
    if ($file == false) {
      die('Não foi possível criar o arquivo.');
    }
    fwrite($file, $texto);
    fclose($file);
    return true;
  }

  private function formataData($data, $formato) {
    $data_timestamp = strtotime($data);

    switch ($formato) {
      case 'Y-m-d':
        $nova_data = date("Y-m-d");
        break;
      case'd-m-Y':
        $nova_data = date('d-m-Y', $data_timestamp);
        break;
    }
    return $nova_data;
  }

//  public function validaCartao(){
//    
//  }
}
