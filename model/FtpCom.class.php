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

  public function __construct(Ftp $dados_ftp) {
    $this->conecta($dados_ftp);
    $this->loga($dados_ftp);
  }
  
  public function conecta(Ftp $dados_ftp) {
      $this->minha_conexao = ftp_ssl_connect(
            $dados_ftp->getEndereco()
              );
  }
  
  public function loga(Ftp $dados_ftp){
    return ftp_login($this->minha_conexao, $dados_ftp->getUsuario(), $dados_ftp->getSenha()
            );
  }
  
  public function envia(Ftp $dados_ftp){
    return ftp_put($this->minha_conexao, $dados_ftp->getFtp_pasta().$dados_ftp->getFtp_arquivo(),
            $dados_ftp->getLocal_arquivo(), FTP_ASCII);
  }
  
  public function recebe(Ftp $dados_ftp){
    return ftp_get($this->minha_conexao, $dados_ftp->getFtp_pasta().$dados_ftp->getFtp_arquivo(),
            $dados_ftp->getLocal_arquivo(), FTP_ASCII);
  }
  
  public function fecha_conexao(){
    return ftp_close($this->minha_conexao);
  }
}
