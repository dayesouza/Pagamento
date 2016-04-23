<?php
/**
 * Description of TAB_LOG_PAGAMENTO
 *
 * @author day
 */
class TAB_LOG_PAGAMENTO {
  
  private $id_compra;
  private $data_pagamento;
  private $status_pagamento;
  private $pago;
  private $cod_barras_boleto;
  private $numero_cartao;
  private $valor_total;
  private $valor_parcela;
  
  function getId_compra() {
    return $this->id_compra;
  }

  function getData_pagamento() {
    return $this->data_pagamento;
  }

  function getStatus_pagamento() {
    return $this->status_pagamento;
  }

  function getPago() {
    return $this->pago;
  }
  function getCod_barras_boleto() {
    return $this->cod_barras_boleto;
  }

  function getNumero_cartao() {
    return $this->numero_cartao;
  }
  
  function getValor_total() {
    return $this->valor_total;
  }
  
  function getValor_parcela() {
    return $this->valor_parcela;
  }

  function setId_compra($id_compra) {
    $this->id_compra = $id_compra;
  }

  function setData_pagamento($data_pagamento) {
    $this->data_pagamento = $data_pagamento;
  }

  function setStatus_pagamento($status_pagamento) {
    $this->status_pagamento = $status_pagamento;
  }

  function setPago($pago) {
    $this->pago = $pago;
  }
  
  function setCod_barras_boleto($cod_barras_boleto) {
    $this->cod_barras_boleto = $cod_barras_boleto;
  }

  function setNumero_cartao($numero_cartao) {
    $this->numero_cartao = $numero_cartao;
  }
  
  function setValor_total($valor_total) {
    $this->valor_total = $valor_total;
  }
  
  function setValor_parcela($valor_parcela) {
    $this->valor_parcela = $valor_parcela;
  }
}
