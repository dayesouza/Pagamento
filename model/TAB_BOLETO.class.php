<?php
/**
 * Description of TAB_BOLETO
 *
 * @author day
 */
class TAB_BOLETO {
  /**
   *
   * @var int id
   */
  private $id;
  /**
   *
   * @var int info_banco 
   */
  private $id_info_banco;
  
  /**
   *
   * @var int id_cliente
   */
  private $id_cliente;
  
  private $cnpj_loja;
  
  private $id_compra;
  
  private $id_tipo_pagamento;
  
  private $data_processamento;
  
  private $data_vencimento;
  
  private $cod_barras;
  
  function getId() {
    return $this->id;
  }

  function getId_info_banco() {
    return $this->id_info_banco;
  }

  function getId_cliente() {
    return $this->id_cliente;
  }

  function getCnpj_loja() {
    return $this->cnpj_loja;
  }

  function getId_compra() {
    return $this->id_compra;
  }

  function getId_tipo_pagamento() {
    return $this->id_tipo_pagamento;
  }

  function getData_processamento() {
    return $this->data_processamento;
  }

  function getData_vencimento() {
    return $this->data_vencimento;
  }

  function getCod_barras() {
    return $this->cod_barras;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setId_info_banco($id_info_banco) {
    $this->id_info_banco = $id_info_banco;
  }

  function setId_cliente($id_cliente) {
    $this->id_cliente = $id_cliente;
  }

  function setCnpj_loja($cnpj_loja) {
    $this->cnpj_loja = $cnpj_loja;
  }

  function setId_compra($id_compra) {
    $this->id_compra = $id_compra;
  }

  function setId_tipo_pagamento($id_tipo_pagamento) {
    $this->id_tipo_pagamento = $id_tipo_pagamento;
  }

  function setData_processamento($data_processamento) {
    $this->data_processamento = $data_processamento;
  }

  function setData_vencimento($data_vencimento) {
    $this->data_vencimento = $data_vencimento;
  }

  function setCod_barras($cod_barras) {
    $this->cod_barras = $cod_barras;
  }


  
  
}
