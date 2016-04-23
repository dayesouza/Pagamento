<?php
ini_set('display_errors', true);

require_once 'autoload.php';

if (isset($_REQUEST["page"])) {

  //Tratar quais classes de controle serão invocadas
  $nome_page = $_REQUEST["page"];

  $partes_url = explode(".", $nome_page);

  $nome_classe = $partes_url[0];
  $metodo_classe = $partes_url[1];

  try {
    $objeto = new $nome_classe();

    if (!method_exists($objeto, $metodo_classe)) {
      throw new Exception("O método " . $metodo_classe . " da classe " . $nome_classe . " não existe.");
    }
    $retorno = $objeto->$metodo_classe($_REQUEST);

    $tela = new TelaWeb();
    $tela->$retorno["view"]($retorno);
  } catch (Exception $e) {
    $tela = new TelaWeb();
    $tela->paginaNaoEncontrada($_REQUEST);
    exit;
  }
}
else {
  $tela = new TelaWeb();
  $tela->telaHome($_REQUEST);
}
?>