<?php

/**
 * Description of PagamentoC
 *
 * @author day
 */
class PagamentoC {

  public function verificaNovaCompra() {
            

    //vai na tab_log_pagamento
    $logPagamentoDAO = new TAB_LOG_PAGAMENTO_DAO();
    $ultimo_codigo = $logPagamentoDAO->buscarUltimoCodigo();
    //se for nulo não existem logs, buscar todos os registros de compra
    if ($ultimo_codigo[0] == null) {
      //busca todas as compras
      
      $vw_pagamentoDAO = new VW_TAB_PAGAMENTO_DAO();
      
      $compras = $vw_pagamentoDAO->buscarTodos();
      
      //Se for diferente de null, é porque existe compra
      if ($compras != null) {//Para cada compra encontrada, ir para o tipo de pagamento
        foreach ($compras as $compra) {
          $this->verificaTipoPagamento($compra);
        }
      }
    }//se não, pega esse ultimo id
//    else {
      //procura na view tab_pagamento se tem alguma compra dps desse id
//    }


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
        $cartaoc->buscarCartao($compra);
        break;
      case 2://se for 2, é boleto

        break;
    }
  }

}
