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

  public function __construct(FTPConnection $dados_conexao) {
    $this->conecta($dados_conexao);
    $this->loga($dados_conexao);
  }
  
  public function conecta(FTPConnection $dados_conexao) {
      $this->minha_conexao = ftp_ssl_connect($dados_conexao->getEndereco());
  }
  
  public function loga(FTPConnection $dados_conexao){
    return ftp_login($this->minha_conexao, $dados_conexao->getUsuario(), 
      $dados_conexao->getSenha());
  }
  
  public function envia(FTPData $dados_ftp){
    return ftp_put($this->minha_conexao, $dados_ftp->getFtp_pasta()
      .$dados_ftp->getFtp_arquivo(), $dados_ftp->getLocal_arquivo(), FTP_ASCII);
  }
  
  public function recebe(FTPData $dados_ftp){
    return ftp_get($this->minha_conexao, $dados_ftp->getFtp_pasta()
      .$dados_ftp->getFtp_arquivo(),$dados_ftp->getLocal_arquivo(), FTP_ASCII);
  }
  
  public function fecha_conexao(){
    return ftp_close($this->minha_conexao);
  }
}
