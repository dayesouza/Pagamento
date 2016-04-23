<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TAB_PAGAMENTO_CARTOES_DAO
 *
 * @author day
 */
class TAB_PAGAMENTO_CARTOES_DAO {
  
    private $nome_tabela;
  /**
   *d
   * @var BancoDeDados
   */
  private $conexao;
  
  private $entidade;
  
  public function __construct() {
    $this->nome_tabela = "TAB_PAGAMENTO_CARTOES";
    $this->entidade = new TAB_PAGAMENTO_CARTOES();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }
  public function buscaCartaoCompra($id_compra){
    $sql = "select * from ".$this->nome_tabela." where id_compra = ".$id_compra;    
    $registro = $this->conexao->executaQuery($sql,$this->entidade);   
    if ($registro != null){
      return $registro[0];  
    }
    else{
      return null;
    }
  }
}
