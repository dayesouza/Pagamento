<?php

//DAO = Data Access Object
class VW_TAB_LOJA_DAO {
 
  private $nome_tabela;
  /**
   *d
   * @var BancoDeDados
   */
  private $conexao;
  
  private $entidade;
  
  public function __construct() {
    $this->nome_tabela = "VW_TAB_LOJA";
    $this->entidade = new VW_TAB_LOJA();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }
  
  /**
   * Busca o maior código da tabela
   * @return object
   */
  public function buscarUltimoCodigo() {    
    $sql = "select MAX(cnpj) from ".$this->nome_tabela;    
    $registro = $this->conexao->executaQuery($sql);    
    return $registro;    
  }
  
  public function buscar_especifico($codigo) {
      
    $sql = "select * from ".$this->nome_tabela.
            " where codigo=".$codigo;
    $registros = $this->conexao->executaQuery($sql, $this->entidade);    
    return $registros;
  }
  
  public function update($codigo, $data_vencimento, $bandeira,$nome_no_cartao, $apelido_cartao, $numero_cartao) {
    $sql = "update ".$this->nome_tabela.
            " set NOME_NO_CARTAO='".$nome_no_cartao."',DATA_VENCIMENTO='".$data_vencimento.
                "',BANDEIRA='".$bandeira ."',APELIDO_CARTAO='".$apelido_cartao."', NUMERO_CARTAO=".$numero_cartao." where codigo=".$codigo;
    $this->conexao->atualizaTabela($sql);  
    return true;
  }
  
  
  public function salvar($data_vencimento, $bandeira,$nome_no_cartao, $apelido_cartao, $numero_cartao) {
      $sql = 'insert into '.$this->nome_tabela." (NOME_NO_CARTAO,DATA_VENCIMENTO,BANDEIRA,APELIDO_CARTAO,NUMERO_CARTAO) "
              . "values ('".$nome_no_cartao."','"
              .$data_vencimento."','".$bandeira."','".$apelido_cartao."',".$numero_cartao.")";
      
      $this->conexao->atualizaTabela($sql);
      return true;
  }
  
  public function excluir($codigo){
    $sql = 'delete from '.$this->nome_tabela.' where codigo = '.$codigo;
    $this->conexao->atualizaTabela($sql);
    return true;      
      
  }
}