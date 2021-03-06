<?php

class FtpC {

  public function enviarArquivo($array_arquivo) {
    //quando o pagamento for concluído receber as informacoes do pagamento
    //cria o objeto data
    $ftpdata = $this->criaDataFTP($array_arquivo);
    //envia pelo ftpcom que é tipo o DAO
    $ftpcom = new FtpCom();
    $envio_ftp = $ftpcom->envia($ftpdata);
    if ($envio_ftp) {//se true, deu certo
      return true;
    }
    else {
      die("Erro no envio ftp. Verifique seu servidor.");
    }
  }
  
  public function baixaArquivo($ftpdata){
    $ftpCom = new FtpCom();
    $array_arquivos = $ftpCom->recebe($ftpdata);
    return $array_arquivos;
  }
  //busca arquivos no diretório FTP
  public function listaArquivos($ftpdata){
    $ftpCom = new FtpCom();
    $array_arquivos = $ftpCom->lista($ftpdata);
    return $array_arquivos;
  }

  public function criaDataFTP($array_arquivo) {
    $caminho_arquivo = $array_arquivo[0];
    $nome_arquivo = $array_arquivo[1];
    $ftpdata = new FTPData();
    $ftpdata->setLocal_arquivo($caminho_arquivo . $nome_arquivo);
    $ftpdata->setFtp_pasta("/ArqPagamentos/");
    $ftpdata->setFtp_arquivo($nome_arquivo);
    return $ftpdata;
  }
  public function excluiArquivo($dados_ftp){
    $ftpCom = new FtpCom();
    $ftpCom->exclui($dados_ftp);
    return true;
  }

}
