<?php
/**
 * Description of TAB_INFO_BANCO
 *
 * @author day
 */
class TAB_INFO_BANCO {
  
  private $id;
  private $agencia;
  private $conta;
  private $conta_dv;
  private $carteira;
  private $nome;
  private $nosso_numero;
  
  function getId() {
    return $this->id;
  }

  function getAgencia() {
    return $this->agencia;
  }

  function getConta() {
    return $this->conta;
  }

  function getConta_dv() {
    return $this->conta_dv;
  }

  function getCarteira() {
    return $this->carteira;
  }

  function getNome() {
    return $this->nome;
  }
  
  function getNosso_numero() {
    return $this->nosso_numero;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setAgencia($agencia) {
    $this->agencia = $agencia;
  }

  function setConta($conta) {
    $this->conta = $conta;
  }

  function setConta_dv($conta_dv) {
    $this->conta_dv = $conta_dv;
  }

  function setCarteira($carteira) {
    $this->carteira = $carteira;
  }

  function setNome($nome) {
    $this->nome = $nome;
  }
  
  function setNosso_numero($nosso_numero) {
    $this->nosso_numero = $nosso_numero;
  }
}
