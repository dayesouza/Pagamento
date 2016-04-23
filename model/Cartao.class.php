<?php

/* Entidade */
class Cartao {

  private $codigo;
  private $data_vencimento;
  private $bandeira;
  private $nome_no_cartao;
  private $numero_cartao;
  
  function getCodigo() {
      return $this->codigo;
  }

  function getData_vencimento() {
      return $this->data_vencimento;
  }

  function getBandeira() {
      return $this->bandeira;
  }

  function getNome_no_cartao() {
      return $this->nome_no_cartao;
  }

  function getApelido_cartao() {
      return $this->apelido_cartao;
  }

  function getNumero_cartao() {
      return $this->numero_cartao;
  }

  function setCodigo($codigo) {
      $this->codigo = $codigo;
  }

  function setData_vencimento($data_vencimento) {
      $this->data_vencimento = $data_vencimento;
  }

  function setBandeira($bandeira) {
      $this->bandeira = $bandeira;
  }

  function setNome_no_cartao($nome_no_cartao) {
      $this->nome_no_cartao = $nome_no_cartao;
  }

  function setApelido_cartao($apelido_cartao) {
      $this->apelido_cartao = $apelido_cartao;
  }

  function setNumero_cartao($numero_cartao) {
      $this->numero_cartao = $numero_cartao;
  }


  
}