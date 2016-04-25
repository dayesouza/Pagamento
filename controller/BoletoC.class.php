<?php

/**
 * Description of BoletoC
 *
 * @author day
 */
class BoletoC {

  public function criaInfoBoleto(VW_TAB_PAGAMENTO $compra) {
    //busca informacoes da loja
    $vwLoja = new VW_TAB_LOJA_DAO();
    $objLoja = $vwLoja->buscarInfoLoja();

    //Busca as informacoes do banco
    $infoBanco = new TAB_INFO_BANCO_DAO();
    $objBanco = $infoBanco->buscarInfoBanco();

    //pega informacoes do cliente
    $infoCliente = new VW_CLIENTE_DAO();
    $objCliente = $infoCliente->buscarCliente($compra->getId_cliente());
    $objBoleto = new TAB_BOLETO();

    $dias_de_prazo_para_pagamento = 5;
    $data_venc = date("Y/m/d", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
    $valor_cobrado = $compra->getValor_compra(); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
    $valor_boleto = number_format($valor_cobrado);

    $objBoleto->setNumero_documento($compra->getId_compra()); // Num do pedido ou nosso numero
    $objBoleto->setData_vencimento($data_venc); // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    $objBoleto->setData_processamento(date("Y/m/d")); // Data de emissao do Boleto
    $objBoleto->setValor_boleto($valor_boleto);  // Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
    $dados_boleto["sacado"] = $objCliente->getNome();
    $dados_boleto["endereco1"] = $objCliente->getEndereco();
    $dados_boleto["endereco2"] = "";

// INFORMACOES PARA O CLIENTE
    $dados_boleto["demonstrativo1"] = "Pagamento de Compra na Loja " . $objLoja->getNome();
    $dados_boleto["demonstrativo2"] = "Mensalidade referente a " . $objLoja->getNome();
    $dados_boleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
    $dados_boleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
    $dados_boleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
    $dados_boleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: " . $objLoja->getContato();
    $dados_boleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

    $dados_pagamento_boleto = $this->funcoesItau($objBoleto, $objBanco);
    $tela = new TelaWeb();
    $parametros["dados_linha_boleto"] = $dados_pagamento_boleto;
    $parametros["dados_boleto"] = $dados_boleto;
    $parametros["obj_boleto"] = $objBoleto;
    $parametros["obj_banco"] = $objBanco;
    $parametros["obj_loja"] = $objLoja;
    //manda gravar na tabela de boletos
    $objBoleto->setCnpj_loja($objLoja->getCNPJ());
    $objBoleto->setId_cliente($compra->getId_cliente());
    $objBoleto->setId_info_banco($objBanco->getId());
    $objBoleto->setId_tipo_pagamento(2);
    $objBoleto->setCod_barras($dados_pagamento_boleto["linha_digitavel"]);
    //gravar na log o pagamento iniciado
    $this->gravaLogBoleto($compra, $dados_pagamento_boleto, $objBoleto);
    //grava o boleto
    $this->gravaBoleto($objBoleto);
    
    $tela->telaDesenhaBoleto($parametros);
    //delay de 50 segundos
//    sleep(50);
    return $objBoleto;
  }
  
  public function gravaLogBoleto(VW_TAB_PAGAMENTO $compra, $dados_pagamento_boleto, TAB_BOLETO $objBoleto){
    $log = new TAB_LOG_PAGAMENTO();
    $log->setCod_barras_boleto($dados_pagamento_boleto["linha_digitavel"]);
    $log->setId_compra($compra->getId_compra());
    $log->setStatus_pagamento("Em andamento");
    $log->setValor_parcela($objBoleto->getValor_boleto());
    $log->setValor_total($objBoleto->getValor_boleto());
    $logdao = new TAB_LOG_PAGAMENTO_DAO();
    $logdao->salvaLogPagBoleto($log);
  }

  public function funcoesItau(TAB_BOLETO $dados_boleto, TAB_INFO_BANCO $dados_banco) {
    $codigobanco = "341";
    $nummoeda = "9";
    $fator_vencimento = $this->fator_vencimento($dados_boleto->getData_vencimento());
    //valor tem 10 digitos, sem virgula
    $valor = $this->formata_numero($dados_boleto->getValor_boleto(), 10, 0, "valor");
    //agencia � 4 digitos
    $agencia = $this->formata_numero($dados_banco->getAgencia(), 4, 0);
    //conta � 5 digitos + 1 do dv
    $conta = $this->formata_numero($dados_banco->getConta(), 5, 0);
    //carteira 175
    $carteira = $dados_banco->getCarteira();
    //nosso_numero no maximo 8 digitos
    $nnum = $this->formata_numero($dados_banco->getNosso_numero(), 8, 0);

    $codigo_barras = $codigobanco . $nummoeda . $fator_vencimento . $valor . $carteira . $nnum . $this->modulo_10($agencia . $conta . $carteira . $nnum) . $agencia . $conta . $this->modulo_10($agencia . $conta) . '000';
    // 43 numeros para o calculo do digito verificador
    $dv = $this->digitoVerificador_barra($codigo_barras);
// Numero para o codigo de barras com 44 digitos
    $linha = substr($codigo_barras, 0, 4) . $dv . substr($codigo_barras, 4, 43);

    $dados_boleto_linha["codigo_barras"] = $linha;
    $dados_boleto_linha["linha_digitavel"] = $this->monta_linha_digitavel($linha); // verificar
    return $dados_boleto_linha;
  }

// FUNCOES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

  private function digitoVerificador_barra($numero) {
    $resto2 = $this->modulo_11($numero, 9, 1);
    $digito = 11 - $resto2;
    if ($digito == 0 || $digito == 1 || $digito == 10 || $digito == 11) {
      $dv = 1;
    }
    else {
      $dv = $digito;
    }
    return $dv;
  }

  private function formata_numero($numero, $loop, $insert, $tipo = "geral") {
    if ($tipo == "geral") {
      $numero = str_replace(",", "", $numero);
      while (strlen($numero) < $loop) {
        $numero = $insert . $numero;
      }
    }
    if ($tipo == "valor") {
      /*
        retira as virgulas
        formata o numero
        preenche com zeros
       */
      $numero = str_replace(",", "", $numero);
      while (strlen($numero) < $loop) {
        $numero = $insert . $numero;
      }
    }
    if ($tipo == "convenio") {
      while (strlen($numero) < $loop) {
        $numero = $numero . $insert;
      }
    }
    return $numero;
  }

  private function fator_vencimento($data) {
    $data = explode("/", $data);
    $ano = $data[2];
    $mes = $data[1];
    $dia = $data[0];
    return(abs(($this->_dateToDays("1997", "10", "07")) - ($this->_dateToDays($ano, $mes, $dia))));
  }

  private function _dateToDays($year, $month, $day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
      $month -= 3;
    }
    else {
      $month += 9;
      if ($year) {
        $year--;
      }
      else {
        $year = 99;
        $century --;
      }
    }
    return ( floor(( 146097 * $century) / 4) +
            floor(( 1461 * $year) / 4) +
            floor(( 153 * $month + 2) / 5) +
            $day + 1721119);
  }

  private function modulo_10($num) {
    $numtotal10 = 0;
    $fator = 2;

    // Separacao dos numeros
    for ($i = strlen($num); $i > 0; $i--) {
      // pega cada numero isoladamente
      $numeros[$i] = substr($num, $i - 1, 1);
      // Efetua multiplicacao do numero pelo (falor 10)
      // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
      $temp = $numeros[$i] * $fator;
      $temp0 = 0;
      foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
        $temp0+=$v;
      }
      $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
      // monta sequencia para soma dos digitos no (modulo 10)
      $numtotal10 += $parcial10[$i];
      if ($fator == 2) {
        $fator = 1;
      }
      else {
        $fator = 2; // intercala fator de multiplicacao (modulo 10)
      }
    }

    // v�rias linhas removidas, vide fun��o original
    // Calculo do modulo 10
    $resto = $numtotal10 % 10;
    $digito = 10 - $resto;
    if ($resto == 0) {
      $digito = 0;
    }

    return $digito;
  }

  private function modulo_11($num, $base = 9, $r = 0) {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Fun��o:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     *
     *   Entrada:
     *     $num: string num�rica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Sa�da:
     *     Retorna o Digito verificador.
     *
     *   Observa��es:
     *     - Script desenvolvido sem nenhum reaproveitamento de c�digo pr� existente.
     *     - Assume-se que a verifica��o do formato das vari�veis de entrada � feita antes da execu��o deste script.
     */
    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
      // pega cada numero isoladamente
      $numeros[$i] = substr($num, $i - 1, 1);
      // Efetua multiplicacao do numero pelo falor
      $parcial[$i] = $numeros[$i] * $fator;
      // Soma dos digitos
      $soma += $parcial[$i];
      if ($fator == $base) {
        // restaura fator de multiplicacao para 2 
        $fator = 1;
      }
      $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
      $soma *= 10;
      $digito = $soma % 11;
      if ($digito == 10) {
        $digito = 0;
      }
      return $digito;
    }
    elseif ($r == 1) {
      $resto = $soma % 11;
      return $resto;
    }
  }

// Alterada por Glauber Portella para especifica��o do Ita�
  private function monta_linha_digitavel($codigo) {
    // campo 1
    $banco = substr($codigo, 0, 3);
    $moeda = substr($codigo, 3, 1);
    $ccc = substr($codigo, 19, 3);
    $ddnnum = substr($codigo, 22, 2);
    $dv1 = $this->modulo_10($banco . $moeda . $ccc . $ddnnum);
    // campo 2
    $resnnum = substr($codigo, 24, 6);
    $dac1 = substr($codigo, 30, 1); //modulo_10($agencia.$conta.$carteira.$nnum);
    $dddag = substr($codigo, 31, 3);
    $dv2 = $this->modulo_10($resnnum . $dac1 . $dddag);
    // campo 3
    $resag = substr($codigo, 34, 1);
    $contadac = substr($codigo, 35, 6); //substr($codigo,35,5).modulo_10(substr($codigo,35,5));
    $zeros = substr($codigo, 41, 3);
    $dv3 = $this->modulo_10($resag . $contadac . $zeros);
    // campo 4
    $dv4 = substr($codigo, 4, 1);
    // campo 5
    $fator = substr($codigo, 5, 4);
    $valor = substr($codigo, 9, 10);

    $campo1 = substr($banco . $moeda . $ccc . $ddnnum . $dv1, 0, 5) . '.' . substr($banco . $moeda . $ccc . $ddnnum . $dv1, 5, 5);
    $campo2 = substr($resnnum . $dac1 . $dddag . $dv2, 0, 5) . '.' . substr($resnnum . $dac1 . $dddag . $dv2, 5, 6);
    $campo3 = substr($resag . $contadac . $zeros . $dv3, 0, 5) . '.' . substr($resag . $contadac . $zeros . $dv3, 5, 6);
    $campo4 = $dv4;
    $campo5 = $fator . $valor;

    return "$campo1 $campo2 $campo3 $campo4 $campo5";
  }

  public function gravaBoleto(TAB_BOLETO $objBoleto) {
    $boletodao = new TAB_BOLETO_DAO();
    $boletodao->gravaInfoBoleto($objBoleto);
    return true;
  }
  public function criaArquivoBoleto($html,$id){
    //dá pra criar direto no ftp já
    $arquivo = "/var/www/html/Pagamento/docs/";
    $name = "Boleto_" . $id . ".txt";
    $file = fopen($arquivo . $name, 'a');
    if ($file == false) {
      die('Não foi possível criar o arquivo.');
    }
    fwrite($file, $html);
    fclose($file);
    $array_arquivo = array($arquivo, $name);
    return $array_arquivo;
  }

}
