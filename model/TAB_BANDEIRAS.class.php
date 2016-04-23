<?php

/**
 * Description of TAB_BANDEIRAS
 *
 * @author day
 */
class TAB_BANDEIRAS {
  
  private $id;
  private $nome;
  private $contato;
  
  function getId() {
    return $this->id;
  }

  function getNome() {
    return $this->nome;
  }

  function getContato() {
    return $this->contato;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setNome($nome) {
    $this->nome = $nome;
  }

  function setContato($contato) {
    $this->contato = $contato;
  }


}
