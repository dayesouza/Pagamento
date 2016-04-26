<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TAB_CLIENTE
 *
 * @author day
 */
class TAB_CLIENTE {
  
  private $id;
  private $cpf;
  private $nome;
  private $endereco;
  
  function getId() {
    return $this->id;
  }

  function getCpf() {
    return $this->cpf;
  }

  function getNome() {
    return $this->nome;
  }

  function getEndereco() {
    return $this->endereco;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setCpf($cpf) {
    $this->cpf = $cpf;
  }

  function setNome($nome) {
    $this->nome = $nome;
  }

  function setEndereco($endereco) {
    $this->endereco = $endereco;
  }


}
