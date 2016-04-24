<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VW_TAB_PAGAMENTO_DAO
 *
 * @author day
 */
class VW_TAB_PAGAMENTO_DAO {
  
  private $nome_tabela;
  /**
   *d
   * @var BancoDeDados
   */
  private $conexao;
  
  private $entidade;
  
  public function __construct() {
    $this->nome_tabela = "VW_TAB_PAGAMENTO";
    $this->entidade = new VW_TAB_PAGAMENTO();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }
  
  public function buscarTodos(){
    $sql = "select * from ".$this->nome_tabela;    
    $registro = $this->conexao->executaQuery($sql,$this->entidade);    
    return $registro;  
  }
  public function buscarApartirDe($codigo){
    $sql = "select * from " . $this->nome_tabela .
            " where id_compra >" . $codigo;
    $registros = $this->conexao->executaQuery($sql, $this->entidade);
    return $registros;
  }
  
  
}
