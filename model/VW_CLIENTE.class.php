<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VW_CLIENTE
 *
 * @author day
 */
class VW_CLIENTE {
  private $id;
  private $endereco;
  private $cpf;
  
  function getId() {
    return $this->id;
  }

  function getEndereco() {
    return $this->endereco;
  }

  function getCpd() {
    return $this->cpf;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setEndereco($endereco) {
    $this->endereco = $endereco;
  }

  function setCpd($cpd) {
    $this->cpf = $cpd;
  }


}
