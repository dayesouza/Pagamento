<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TAB_BANDEIRAS_DAO
 *
 * @author day
 */
class TAB_BANDEIRAS_DAO {
  private $nome_tabela;
  /**
   *d
   * @var BancoDeDados
   */
  private $conexao;
  
  private $entidade;
  
  public function __construct() {
    $this->nome_tabela = "TAB_BANDEIRAS";
    $this->entidade = new TAB_BANDEIRAS();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }
  
  /**
   * @return object
   */
  public function buscaInfoBandeira($cod_bandeira) {    
    $sql = "select * from ".$this->nome_tabela." where id=".$cod_bandeira;    
    $registro = $this->conexao->executaQuery($sql,$this->entidade);    
    return $registro;    
  }
}
