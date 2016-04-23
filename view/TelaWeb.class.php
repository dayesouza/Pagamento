<?php

class TelaWeb {
  
    
  public function telaHome($parametros){
    echo "<a href=\"?page=PagamentoC.verificaNovaCompra\">Verificar</a>";
    
  }
  
  public function telaDesenhaBoleto($parametros){
    print_r($parametros);exit;
    
  }

}
