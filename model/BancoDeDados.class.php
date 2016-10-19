<?php

class BancoDeDados {

  private $my_conexao;

public function conecta($conexao = null) {
    if ($conexao != null){
      $this->my_conexao = mysqli_connect(
        $conexao["host"], $conexao["user"], $conexao["senha"], $conexao["database"]
      );
      echo "ta";exit;
    }
    else{
      $this->my_conexao = mysqli_connect(
              "localhost", "root", "admcpd", "pagamentos"
      );
    }
  }

  public function desconecta() {
    mysqli_close($this->my_conexao);
  }

  public function executaQuery($texto_query, $objeto = null) {
    $nome_classe = get_class($objeto);

    $rs = mysqli_query($this->my_conexao, $texto_query);
    $lista_objetos = array();
    if (!($rs instanceof mysqli_result)){
      return $rs;
    }
    while ($registro = mysqli_fetch_assoc($rs)) {
      if ($objeto == null) {
        $obj = $registro[key($registro)];
      }
      else {
        $obj = new $nome_classe();
        $lista_atributos = array_keys($registro);

        foreach ($lista_atributos as $nome_atributo) {
          $nome_atributo_original = $nome_atributo;
          $nome_atributo = strtolower($nome_atributo);
          $nome_atributo = "set" . ucfirst($nome_atributo);
          $obj->$nome_atributo($registro[$nome_atributo_original]);
        }
      }

      $lista_objetos[] = $obj;
    }
    return $lista_objetos;
  }

  public function atualizaTabela($texto_query) {
    $rs = mysqli_query($this->my_conexao, $texto_query);
    return $rs;
  }

}
