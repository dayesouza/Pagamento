<?php

class CartaoC {

  public function cadastraCartao() {
    return array("view" => "telaCadastraCartao");
  }

  public function cadastrarCartao($parametros) {
    /* Validações de campos da interface */
    $data_vencimento = trim($parametros["data_vencimento"]);
    $bandeira = trim($parametros["bandeira"]);
    $nome_no_cartao = trim($parametros["nome_no_cartao"]);
    $apelido_cartao = trim($parametros["apelido_cartao"]);
    $numero_cartao = trim($parametros["numero_cartao"]);

    /* Envia pro banco de dados */
    if (isset($parametros["codigo"])) {
      $retorno_update = $this->editarCartao($parametros);
      return $retorno_update;
    }

    $cartao_dao = new CartaoDAO();
    $objetos = $cartao_dao->salvar($data_vencimento, $bandeira, $nome_no_cartao, $apelido_cartao, $numero_cartao);

    return array(
      "view" => "telaResultadoProcessamentoCartao",
      "data_vencimento" => $data_vencimento,
      "bandeira" => $bandeira,
      "nome_no_cartao" => $nome_no_cartao,
      "apelido_cartao" => $apelido_cartao,
      "numero_cartao" => $numero_cartao
    );
  }

  /**
   * 
   * @param array $parametros
   * @return array
   */
  public function consultarCartoes() {
    $cartao_dao = new CartaoDAO();
    $objetos = $cartao_dao->consultar();

    return array("view" => "telaConsultarCartoes", "lista_obj_cartao" => $objetos);
  }

  public function excluirCartao($parametros) {

    $codigo = $parametros["codigo"];

    $cartao_dao = new CartaoDAO();
    $objetos = $cartao_dao->excluir($codigo);

    $retorno_consulta = $this->consultarCartoes($parametros);

    return $retorno_consulta;
    //TODO implementar a exclusão do cartao
  }

  public function buscarCartao($parametros) {
    //TODO implementar a edição do cartao
    $codigo = $parametros["codigo"];
    
    $ftpc = new FtpC();
    $ftpc->recebeArquivoCartoes();
    

    $cartao_dao = new CartaoDAO();
    $objetos = $cartao_dao->buscar_especifico($codigo);
    return array("view" => "telaCadastraCartao", "lista_obj_cartao" => $objetos);
  }

  public function editarCartao($parametros) {
    $codigo = $parametros["codigo"];
    $nome_no_cartao = $parametros["nome_no_cartao"];
    $data_sql = $parametros["data_vencimento"];
    $bandeira = $parametros["bandeira"];
    $apelido_cartao = $parametros["apelido_cartao"];
    $numero_cartao = $parametros["numero_cartao"];

    $data_vencimento = $this->formataData($data_sql, "Y-m-d");
    $cartao_dao = new CartaoDAO();
    $cartao_dao->update($codigo, $data_vencimento, $bandeira, $nome_no_cartao, $apelido_cartao, $numero_cartao);

    $retorno_consulta = $this->consultarCartoes($parametros);

    return $retorno_consulta;
  }

  private function formataData($data, $formato) {
    $data_timestamp = strtotime($data);

    switch ($formato) {
      case 'Y-m-d':
        $nova_data = date("Y-m-d");
        break;
      case'd-m-Y':
        $nova_data = date('d-m-Y', $data_timestamp);
        break;
    }
    return $nova_data;
  }
  
  public function validaCartao(){
    
  }

}
