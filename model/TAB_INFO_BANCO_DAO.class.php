<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TAB_INFO_BANCO_DAO
 *
 * @author day
 */
class TAB_INFO_BANCO_DAO {
  private $nome_tabela;
  /**
   *d
   * @var BancoDeDados
   */
  private $conexao;
  
  private $entidade;
  
  public function __construct() {
    $this->nome_tabela = "TAB_INFO_BANCO";
    $this->entidade = new TAB_INFO_BANCO();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }
  
  /**
   * Busca o maior código da tabela
   * @return object
   */
  public function buscarInfoBanco() {    
    $sql = "select * from ".$this->nome_tabela;    
    $registro = $this->conexao->executaQuery($sql,$this->entidade);    
    return $registro[0];    
  }
}
