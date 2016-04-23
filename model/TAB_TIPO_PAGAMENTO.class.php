<?php

/**
 * Description of TAB_TIPO_PAGAMENTO
 *
 * @author day
 */
class TAB_TIPO_PAGAMENTO {
  
  private $id;
  private $descricao;
  
  function getId() {
    return $this->id;
  }

  function getDescricao() {
    return $this->descricao;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setDescricao($descricao) {
    $this->descricao = $descricao;
  }


}
