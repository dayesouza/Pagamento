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
  private $vencimento;
  private $codigo;
  private $id_bandeira;
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

function getVencimento() {
return $this->vencimento;
}

function getCodigo() {
return $this->codigo;
}

function getId_bandeira() {
return $this->id_bandeira;
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

function setVencimento($vencimento) {
$this->vencimento = $vencimento;
}

function setCodigo($codigo) {
$this->codigo = $codigo;
}

function setId_bandeira($id_bandeira) {
$this->id_bandeira = $id_bandeira;
}

function setId_tipo_pagamento($id_tipo_pagamento) {
$this->id_tipo_pagamento = $id_tipo_pagamento;
}


  
}
