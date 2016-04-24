<?php

/**
 * Description of FTPData
 * Objeto ftp
 * @author day
 */
class FTPData {
  /**
   *
   * @var String local_arquivo
   * Path do arquivo local 
   */
  private $local_arquivo;
  /**
   *
   * @var String ftp_pasta
   * Path para a pasta do arquivo ftp
   */
  private $ftp_pasta;
  /**
   *
   * @var String ftp_arquivo
   * Nome e tipo do arquivo no ftp
   */
  private $ftp_arquivo;
  
  function getLocal_arquivo() {
    return $this->local_arquivo;
  }

  function getFtp_pasta() {
    return $this->ftp_pasta;
  }

  function getFtp_arquivo() {
    return $this->ftp_arquivo;
  }

  function setLocal_arquivo($local_arquivo) {
    $this->local_arquivo = $local_arquivo;
  }
  function setFtp_pasta($ftp_pasta) {
    $this->ftp_pasta = $ftp_pasta;
  }
  function setFtp_arquivo($ftp_arquivo) {
    $this->ftp_arquivo = $ftp_arquivo;
  }
}
