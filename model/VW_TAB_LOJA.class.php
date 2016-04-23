<?php
/**
 * Description of VW_TAB_LOJA
 *
 * @author day
 */
class VW_TAB_LOJA {
  
  private $cnpj;
  private $nome;
  private $email;
  private $contato;
  private $razao_social;
  
  function getCnpj() {
    return $this->cnpj;
  }

  function getNome() {
    return $this->nome;
  }

  function getEmail() {
    return $this->email;
  }

  function getContato() {
    return $this->contato;
  }
  
  function getRazao_social() {
    return $this->razao_social;
  }

  function setCnpj($cnpj) {
    $this->cnpj = $cnpj;
  }

  function setNome($nome) {
    $this->nome = $nome;
  }

  function setEmail($email) {
    $this->email = $email;
  }

  function setContato($contato) {
    $this->contato = $contato;
  }
  
  function setRazao_social($razao_social) {
    $this->razao_social = $razao_social;
  }

}
