<?php

//DAO = Data Access Object
class TAB_LOG_PAGAMENTO_DAO {

  private $nome_tabela;

  /**
   * d
   * @var BancoDeDados
   */
  private $conexao;
  private $entidade;

  public function __construct() {
    $this->nome_tabela = "TAB_LOG_PAGAMENTO";
    $this->entidade = new TAB_LOG_PAGAMENTO();
    //Instancia o banco de dados. 
    $this->conexao = new BancoDeDados();
    $this->conexao->conecta();
  }

  /**
   * Busca o maior código da tabela
   * @return object
   */
  public function buscarUltimoCodigo() {
    $sql = "select MAX(id_compra) from " . $this->nome_tabela;
    $registro = $this->conexao->executaQuery($sql);
    return $registro;
  }
  
  public function buscaLog($codigo){
    $sql = "select * from " . $this->nome_tabela." where id_compra=".$codigo;
    $registro = $this->conexao->executaQuery($sql,$this->entidade);
    return $registro;
  }

  public function update($codigo, $data_vencimento, $bandeira, $nome_no_cartao, $apelido_cartao, $numero_cartao) {
    $sql = "update " . $this->nome_tabela .
            " set NOME_NO_CARTAO='" . $nome_no_cartao . "',DATA_VENCIMENTO='" . $data_vencimento .
            "',BANDEIRA='" . $bandeira . "',APELIDO_CARTAO='" . $apelido_cartao . "', NUMERO_CARTAO=" . $numero_cartao . " where codigo=" . $codigo;
    $this->conexao->atualizaTabela($sql);
    return true;
  }

  public function salvaLogPagCartao($log) {
    $sql = 'insert into ' . $this->nome_tabela . " (ID_COMPRA,STATUS_PAGAMENTO,NUMERO_CARTAO)"
      ." values (" . $log->getId_compra() . ",'"
      .$log->getStatus_pagamento() . "'," . $log->getNumero_cartao() . ")";
    $this->conexao->atualizaTabela($sql);
    return true;
  }
    public function salvaLogPagBoleto($log) {
    $sql = 'insert into ' . $this->nome_tabela . " (ID_COMPRA,STATUS_PAGAMENTO,COD_BARRAS_BOLETO,VALOR_PARCELA,VALOR_TOTAL)"
      ." values (".$log->getId_compra().",'"
      .$log->getStatus_pagamento()."','".$log->getCod_barras_boleto()."'"
            . ",".$log->getValor_parcela().",".$log->getValor_total().")";
    $this->conexao->atualizaTabela($sql);
    return true;
  }
  
  public function atualizaPagamento($log){
    $sql = 'update ' . $this->nome_tabela . " set"
      . " STATUS_PAGAMENTO= '".$log->getStatus_pagamento()
      ."', PAGO='".$log->getPago()
      ."',VALOR_PARCELA= ".$log->getValor_parcela()
      .", DATA_PAGAMENTO='".$log->getData_pagamento()
       ."',VALOR_TOTAL=".$log->getValor_total()
      ." where ID_COMPRA= ".$log->getId_compra()
      ." and NUMERO_CARTAO=".$log->getNumero_cartao();
    $this->conexao->atualizaTabela($sql);

    return true;
  }
  
    public function atualizaPagamentoBoleto($log){
    $sql = 'update ' . $this->nome_tabela . " set"
      ." STATUS_PAGAMENTO= '".$log->getStatus_pagamento()
      ."', PAGO='".$log->getPago()
      ."', DATA_PAGAMENTO='".$log->getData_pagamento()
      ."' where ID_COMPRA=".$log->getId_compra();
    $this->conexao->atualizaTabela($sql);

    return true;
  }

}
