<?php
/**
 * Description of VW_TAB_PAGAMENTO
 *
 * @author day
 */
class VW_TAB_PAGAMENTO {
  private $id_compra;
  private $id_cliente;
  private $tipo_pagamento;
  private $valor_compra;
  private $data_compra;
  private $parcelas;
  private $valor_desconto;

  function getId_compra() {
    return $this->id_compra;
  }

  function getId_cliente() {
    return $this->id_cliente;
  }

  function getTipo_pagamento() {
    return $this->tipo_pagamento;
  }

  function getValor_compra() {
    return $this->valor_compra;
  }

  function getData_compra() {
    return $this->data_compra;
  }

  function getParcelas() {
    return $this->parcelas;
  }

  function getValor_desconto() {
    return $this->valor_desconto;
  }

  function setId_compra($id_compra) {
    $this->id_compra = $id_compra;
  }

  function setId_cliente($id_cliente) {
    $this->id_cliente = $id_cliente;
  }

  function setTipo_pagamento($tipo_pagamento) {
    $this->tipo_pagamento = $tipo_pagamento;
  }

  function setValor_compra($valor_compra) {
    $this->valor_compra = $valor_compra;
  }

  function setData_compra($data_compra) {
    $this->data_compra = $data_compra;
  }

  function setParcelas($parcelas) {
    $this->parcelas = $parcelas;
  }

  function setValor_desconto($valor_desconto) {
    $this->valor_desconto = $valor_desconto;
  }

  
}
