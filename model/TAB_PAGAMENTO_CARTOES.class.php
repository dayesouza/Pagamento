<?php

/**
 * Description of TAB_PAGAMENTO_CARTOES
 *
 * @author day
 */
class TAB_PAGAMENTO_CARTOES {

  private $id_compra;
  private $nome_no_cartao;
  private $numero;
  private $bandeira;
  private $id_tipo_pagamento;

  function getId_compra() {
    return $this->id_compra;
  }

  function getNome_no_cartao() {
    return $this->nome_no_cartao;
  }

  function getNumero() {
    return $this->numero;
  }

  function getBandeira() {
    return $this->bandeira;
  }

  function getId_tipo_pagamento() {
    return $this->id_tipo_pagamento;
  }

  function setId_compra($id_compra) {
    $this->id_compra = $id_compra;
  }

  function setNome_no_cartao($nome_no_cartao) {
    $this->nome_no_cartao = $nome_no_cartao;
  }

  function setNumero($numero) {
    $this->numero = $numero;
  }

  function setBandeira($bandeira) {
    $this->bandeira = $bandeira;
  }

  function setId_tipo_pagamento($id_tipo_pagamento) {
    $this->id_tipo_pagamento = $id_tipo_pagamento;
  }

}
