<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TAB_BOLETO_DAO
 *
 * @author day
 */
class TAB_BOLETO_DAO {

  private $nome_tabela;

  /**
   * d
   * @var BancoDeDados
   */
  private $conexao;
  private $entidade;

  public function __construct() {
    $this->nome_tabela = "TAB_BOLETO";
    $this->entidade = new TAB_BOLETO();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }

  /**
   * @return object
   */
  public function gravaInfoBoleto(TAB_BOLETO $obj_boleto) {
    $sql = "insert into " . $this->nome_tabela . "(id,id_info_banco, id_cliente, "
            . "cnpj_loja, numero_documento, data_processamento, data_vencimento, cod_barras,"
            . " id_tipo_pagamento, valor_boleto) values (".$obj_boleto->getNumero_documento()
            .",".$obj_boleto->getId_info_banco()
            .", ".$obj_boleto->getId_cliente().",".$obj_boleto->getCnpj_loja()
            .",".$obj_boleto->getNumero_documento().",'".$obj_boleto->getData_processamento()
            ."','".$obj_boleto->getData_vencimento()."','".$obj_boleto->getCod_barras()
            ."',".$obj_boleto->getId_tipo_pagamento().",".$obj_boleto->getValor_boleto().")";
    $registro = $this->conexao->executaQuery($sql, $this->entidade);
    return $registro;
  }

}
