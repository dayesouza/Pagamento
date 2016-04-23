<?php

class FtpC{
  
  public function recebeArquivoCartoes($parametros){
    $parametros = array("",);
    
  }
  
  public function enviarArquivo($parametros){
    //quando o pagamento for concluído receber as informacoes do pagamento
    //e enviar colocar em um arquivo texto e enviar por ftp para vendas
    
    //se foi recusado, colocar informacoes no arquivo e mandar tb com status cancelado
  }
  public function criaObjetoFtp($parametros){
    $objFtp = new Ftp();
    
  }
  
}
