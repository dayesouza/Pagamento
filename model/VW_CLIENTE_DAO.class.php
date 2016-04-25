<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VW_CLIENTE_DAO
 *
 * @author day
 */
class VW_CLIENTE_DAO {
  private $nome_tabela;
  /**
   * d
   * @var BancoDeDados
   */
  private $conexao;
  private $entidade;

  public function __construct() {
    $this->nome_tabela = "VW_CLIENTE";
    $this->entidade = new VW_CLIENTE();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }

  /**
   * Busca o maior código da tabela
   * @return object
   */
  public function buscarCliente($id_cliente) {
    $sql = "select * from " . $this->nome_tabela." where id=".$id_cliente;
    $registro = $this->conexao->executaQuery($sql);
    return $registro;
  }
}
