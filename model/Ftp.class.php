<?php

/**
 * Description of Ftp
 * Objeto ftp
 * @author day
 */
class Ftp {
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
  private $local_arquivo;
  /**
   *
   * @var String ftp_pasta
   */
  private $ftp_pasta;
  /**
   *
   * @var String ftp_arquivo
   */
  private $ftp_arquivo;
  
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
  function getLocal_arquivo() {
    return $this->local_arquivo;
  }

  function getFtp_pasta() {
    return $this->ftp_pasta;
  }

  function getFtp_arquivo() {
    return $this->ftp_arquivo;
  }

  function setUsuario(String $usuario) {
    $this->usuario = $usuario;
  }
  function setSenha(String $senha) {
    $this->senha = $senha;
  }
  function setEndereco(String $endereco) {
    $this->endereco = $endereco;
  }
  function setPorta($porta) {
    $this->porta = $porta;
  }
  function setLocal_arquivo(String $local_arquivo) {
    $this->local_arquivo = $local_arquivo;
  }
  function setFtp_pasta(String $ftp_pasta) {
    $this->ftp_pasta = $ftp_pasta;
  }
  function setFtp_arquivo(String $ftp_arquivo) {
    $this->ftp_arquivo = $ftp_arquivo;
  }
}
