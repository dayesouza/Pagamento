<?php

class CartaoC {

  public function buscarCartao(VW_TAB_PAGAMENTO $compra) {
    //busca cartão na tabela
    $vw_cartoes = new TAB_PAGAMENTO_CARTOES_DAO();
    
    $cartaoObj = $vw_cartoes->buscaCartaoCompra($compra->getId_compra());
    return $cartaoObj;
  }

  public function realizaPagamentoCartao(VW_TAB_PAGAMENTO $compra, TAB_PAGAMENTO_CARTOES $cartaoObj) {
    //grava na log
    $log = new TAB_LOG_PAGAMENTO();
    $log->setId_compra($compra->getId_compra());
    $log->setNumero_cartao($cartaoObj->getNumero());
    $log->setStatus_pagamento("Em andamento");
    $logDAO = new TAB_LOG_PAGAMENTO_DAO();
    $logDAO->salvaLogPagCartao($log);
    
    //Verifica se a compra foi aprovada
    $situacao_compra = $this->analisarCompra();
    if($situacao_compra){
      $log->setPago('S');
      $log->setStatus_pagamento("Pagamento efetuado");
    }
    else{
      $log->setPago('N');
      $log->setStatus_pagamento("Pagamento não realizado. Verifique junto a sua operadora.");
    }
    $log->setData_pagamento(date('Y-m-d'));
    $valor_compra = $compra->getValor_compra() - $compra->getValor_desconto();
    $valor_parcela = $valor_compra/$compra->getParcelas();
    $log->setValor_parcela($valor_parcela);
    $log->setValor_total($valor_compra);
    $logDAO->atualizaPagamento($log);
    //pagamento atualizado
    return $log;
  }

  private function analisarCompra() {
    //criar numero randomico
    $probabilidade_aceitar = rand(1, 12);
    //se o numero for maior que 9, reprovar
    if ($probabilidade_aceitar > 9){
      return false;
    }//se não, aprovar
    else{
      return true;
    }
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
