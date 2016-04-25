<?php

function __autoload($nome_classe){
    $nome_arquivo_classe = $nome_classe . ".class.php";    
    $diretorios_classes = array("model", "view", "controller","scripts","plugins");
    $classe_encontrada = false;
    
    foreach ($diretorios_classes as $dir) {
      $caminho_completo_arquivo = $dir ."/". $nome_arquivo_classe;      
      if (file_exists($caminho_completo_arquivo)) {
        require_once $caminho_completo_arquivo;
        $classe_encontrada = true;
        break;
      }
    }
    
    if (!$classe_encontrada) {
      throw new Exception("Classe ".$nome_classe." não encontrada.");
    }

    
}

?>
