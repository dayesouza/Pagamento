<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FTPConnection
 *
 * @author day
 */
class FTPConnection {
  /**
   *
   * @var String $usuario 
   */
  private $usuario;
  
  /**
   *
   * @var String $senha 
   */
  private $senha;
  
  /**
   *
   * @var String $endereco 
   */
  private $endereco;
  
  /**
   *
   * @var int $porta       
   */
  private $porta;
  
  /**
   *
   * @var String $local_arquivo
   */
  
  function getUsuario() {
    return $this->usuario;
  }
  function getSenha() {
    return $this->senha;
  }
  function getEndereco() {
    return $this->endereco;
  }
  function getPorta() {
    return $this->porta;
  }
  
  function setUsuario($usuario) {
    $this->usuario = $usuario;
  }
  function setSenha($senha) {
    $this->senha = $senha;
  }
  function setEndereco($endereco) {
    $this->endereco = $endereco;
  }
  function setPorta($porta = 22) {
    $this->porta = $porta;
  }
}
