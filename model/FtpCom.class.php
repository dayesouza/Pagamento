<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FtpCom
 *
 * @author day
 */
class FtpCom {

  private $minha_conexao;

  public function __construct() {
    $ftpcon = new FTPConnection();
    $ftpcon->setEndereco("25.130.139.222");
    $ftpcon->setPorta(21);
    $ftpcon->setUsuario("vendas");
    $ftpcon->setSenha("venda01");
    
    $this->conecta($ftpcon);
    $this->loga($ftpcon);
    ftp_pasv($this->minha_conexao, TRUE);
  }
  
  public function conecta(FTPConnection $dados_conexao){
      $this->minha_conexao = ftp_ssl_connect($dados_conexao->getEndereco());
  }
  
  public function loga(FTPConnection $dados_conexao){
    return ftp_login($this->minha_conexao, $dados_conexao->getUsuario(), 
      $dados_conexao->getSenha());
  }
  
  public function envia(FTPData $dados_ftp){
    return ftp_put($this->minha_conexao, $dados_ftp->getFtp_pasta()
      .$dados_ftp->getFtp_arquivo(), $dados_ftp->getLocal_arquivo(), FTP_BINARY);
  }
  
  public function recebe(FTPData $dados_ftp){
    return ftp_get($this->minha_conexao, $dados_ftp->getLocal_arquivo(),
            $dados_ftp->getFtp_pasta().$dados_ftp->getFtp_arquivo(), FTP_BINARY);
  }
  
  public function lista(FTPData $dados_ftp){
    return ftp_nlist($this->minha_conexao, $dados_ftp->getFtp_pasta());
  }
  
  public function exclui(FTPData $dados_ftp){
    //exclui o arquivo já lido e salvo
    ftp_delete($this->minha_conexao, $dados_ftp->getFtp_pasta()
      .$dados_ftp->getFtp_arquivo());
  }
  
  public function fecha_conexao(){
    return ftp_close($this->minha_conexao);
  }
}
