<?php

class TelaWeb {
  public function telaHome($parametros){
    echo "<a href=\"?page=PagamentoC.verificaNovaCompra\">Verificar</a>";
  }
  
  public function telaDesenhaBoleto($parametros){
    $html = "";
    $html .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
    $html .= "<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-2\" />";
    $html .= "<script>";
    $html .= "#boleto_parceiro {
	height: 85px;
	width: 666px;
	font-family: Arial, Helvetica, sans-serif;
	margin-bottom: 15px;
	border-bottom-width: 1px;
	border-bottom-style: dashed;
	border-bottom-color: #000000;
}
.am {
	font-size: 9px;
	color: #333333;
	height: 10px;
	font-weight: bold;
	margin-bottom: 2px;
	text-align: center;
	width: 320px;
	border-top-width: 1px;
	border-right-width: 2px;
	border-left-width: 2px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-left-color: #000000;
}
#boleto{
	height: 416px;
	width: 666px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}

#tb_logo {
	height: 40px;
	width: 666px;
	border-bottom-width: 2px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
}
#tb_logo #td_banco {
	height: 22px;
	width: 53px;
	border-right-width: 2px;
	border-left-width: 2px;
	border-right-style: solid;
	border-left-style: solid;
	border-right-color: #000000;
	border-left-color: #000000;
	font-size: 15px;
	font-weight: bold;
	text-align: center;
}
.ld {font: bold 15px Arial; color: #000000}
.td_7_sb {
	height: 26px;
	width: 7px;
}
.td_7_cb {
	width: 7px;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #000000;
	height: 26px;
}
.td_2 {
	width: 2px;
}
.tabelas td{
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
}
.direito {
	width: 178px;
}
.titulo {
	font-size: 9px;
	color: #333333;
	height: 10px;
	font-weight: bold;
	margin-bottom: 2px;
}
.var {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	height: 13px;
}
.direito .var{
	text-align: right;
}
.tabela_1{
    width:666px; 
    height:28px; 
    border-bottom:solid; 
    border-bottom-color:#000000; 
    border-bottom-width:2px; 
    border-top:solid; 
    border-top-color:#000000; 
    border-top-width:2px; 
    margin-bottom: 5px;
}";
    $html .= "</script>";
    $html .= "<body><div id=\"boleto_parceiro\">";
    $html .= "<table class=\"tabela_1\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr> <td class=\"td_7_sb\">&nbsp;</td><td><div class=\"titulo\">Nosso Número</div>";
    //nosso numero
    $html .= "<div class=\"var\">".$parametros["obj_banco"]->getNosso_numero()."</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td><div class=\"titulo\">Espécie.</div>";
    $html .= "<div class=\"var\">R$</div></td> <td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td><div class=\"titulo\">Quantidade</div><div class=\"var\">&nbsp;</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td><div class=\"titulo\">Valor Documento</div>";
    //valor boleto
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getValor_boleto()."</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td><div class=\"titulo\">Espécie Doc.</div>";
    $html .= "<div class=\"var\">DS</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td><div class=\"titulo\">Agência / Código Cedente</div>";
    //dados banco
    $html .= "<div class=\"var\" style=\"text-align:right\">".$parametros["obj_banco"]->getAgencia()."/".$parametros["obj_banco"]->getConta()."</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table>";
    $html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td class=\"td_7_sb\">&nbsp;</td><td><div class=\"titulo\">Sacador / Avalista</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_7_sb\">&nbsp;</td>";
    $html .= "<td valign=\"top\" style=\"width:320px;\"><div class=\"am\">Autenticação Mecânica</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table></div>";
    $html .= "<div id=\"boleto\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"tb_logo\">";
    
    //img logo itau
    $html .= "<tr><td rowspan=\"2\" valign=\"bottom\" style=\"width:150px;\"><img src=\"view/img/logo_itau.jpg\" alt=\"Banco Itau\" width=\"150\" height=\"40\" title=\"Banco Itau\" /></td>";
    
    $html .= "<td align=\"center\" valign=\"bottom\" style=\"font-size: 9px; border:none;\">Banco</td>";
    $html .= "<td rowspan=\"2\" align=\"right\" valign=\"bottom\" style=\"width:6px;\"></td>";
    //linha digitavel pagamento
    $html .= "<td rowspan=\"2\" align=\"right\" valign=\"bottom\" style=\"font-size: 15px; font-weight:bold; width:445px;\"><span class=\"ld\">".$parametros["dados_linha_boleto"]["linha_digitavel"]."</span></td>";
    $html .= "<td rowspan=\"2\" align=\"right\" valign=\"bottom\" style=\"width:2px;\"></td>";
    $html .= "</tr><tr><td id=\"td_banco\">175</td></tr></table>";
    $html .= "<table class=\"tabelas\" style=\"width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td class=\"td_7_sb\">&nbsp;</td><td style=\"width: 468px;\"><div class=\"titulo\">Local do Pagamento</div>";
    $html .= "<div class=\"var\">Pagável em qualquer banco até a data de vencimento</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td class=\"direito\"><div class=\"titulo\">Vencimento</div>";
    //data_vencimento
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getData_vencimento()."</div></td><td class=\"td_2\">&nbsp;</td>";
    $html .= "</tr<tr><td class=\"td_7_sb\">&nbsp;</td><td><div class=\"titulo\">Cedente</div>";
    //nome da empresa
    $html .= "<div class=\"var\">".$parametros["obj_loja"]->getNome()."</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td class=\"direito\"><div class=\"titulo\">Agência / Cod.Cedente</div>";
    $html .= "<div class=\"var\">".$parametros["obj_banco"]->getAgencia()."/".$parametros["obj_banco"]->getConta()."</div></td><td>&nbsp;</td></tr></table>";
    $html .= "<table class=\"tabelas\" style=\"width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td class=\td_7_sb\">&nbsp;</td><td style=\"width:103px;\"><div class=\"titulo\">Data  Documento</div>";
    //data processamento boleto
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getData_processamento()."</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:133px;\"><div class=\"titulo\">Número Documento</div>";
    //numero documento//pedido
    $html .= "<div class=\"var\>".$parametros["obj_boleto"]->getNumero_documento()."</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td style=\"width:62px;\"><div class=\"titulo\">Espécie Doc.</div>";
    $html .= "<div class=\"var\">DS</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:34px;\"><div class=\"titulo\">Aceite</div>";
    $html .= "<div class=\"var\">S</div></td><td class=\td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:103px;\"><div class=\"titulo\">Data Processamento</div>";
    //data processamento de novo ue
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getData_processamento()."</div></td>";
    $html .= "<td class=\td_7_cb\">&nbsp;</td><td class=\"direito\"><div class=\"titulo\">Nosso Número</div>";
    //nosso numero/pedido de novo
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getNumero_documento()."</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table>";
    $html .= "<table class=\"tabelas\" style=\"width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
    $html .= "<tr><td class=\"td_7_sb\">&nbsp;</td><td style=\"width:118px;\"><div class=\"titulo\">Uso Banco</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:55px;\"><div class=\"titulo\">Carteira</div>";
    //carteira
    $html .= "<div class=\"var\">".$parametros["obj_banco"]->getCarteira()."</div></td>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td><td style=\"width:55px;\"><div class=\"titulo\">Espécie</div>";
    $html .= "<div class=\"var\">R$</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:104px;\"><div class=\"titulo\">Quantidade</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td style=\"width:103px;\"><div class=\"titulo\">Valor</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td class=\"direito\"><div class=\"titulo\">Valor do Documento</div>";
    //valor do boleto
    $html .= "<div class=\"var\">".$parametros["obj_boleto"]->getValor_boleto()."</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table>";
    $html .= "<table class=\"tabelas\" style=\"width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td rowspan=\"5\" class=\"td_7_sb\">&nbsp;</td>";
    //instruções de pagamento
    $html .= "<td rowspan=\"5\" valign=\"top\"><div class=\"titulo\" style=\"margin-bottom:18px;\">Instruções (Pagável em qualquer banco em até a data de vencimento)</div>";
    $html .= "<div class=\"var\">Senhor(a) caixa: Não receber após o vencimento<br/></div>";
    $html .= "</td><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td class=\"direito\"><div class=\"titulo\">(-) Desconto / Abatimento</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\td_2\">&nbsp;</td></tr>";
    $html .= "<tr><td class=\"td_7_cb\">&nbsp;</td><td class=\"direito\"><div class=\"titulo\">(-) Outras Deduções</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_2\">&nbsp;</td></tr>";
    $html .= "<tr><td class=\"td_7_cb\">&nbsp;</td><td class=\"direito\"><div class=\"titulo\">(+) Multa / Mora</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_2\">&nbsp;</td></tr><tr>";
    $html .= "<td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td class=\"direito\"><div class=\"titulo\">(+) Outros Acréscimos</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_2\">&nbsp;</td>";
    $html .= "</tr><tr><td class=\"td_7_cb\">&nbsp;</td>";
    $html .= "<td class=\"direito\"><div class=\"titulo\">(=) Valor Cobrado</div>";
    $html .= "<div class=\"var\">&nbsp;</div></td><td class=\"td_2\">&nbsp;</td>";
    $html .= "</tr></table>";
    $html .= "<table class=\"tabelas\" style=\"width:666px; height:65px; border-left:solid; border-left-width:2px; border-left-color:#000000;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td class=\"td_7_sb\">&nbsp;</td><td valign=\"top\"><div class=\"titulo\">Sacado</div>";
    //nome do cliente
    $html .= "<div class=\"var\" style=\"margin-bottom:5px; height:auto\">".$parametros["dados_boleto"]["sacado"]."<br />";
    //endereço do cliente
    $html .= $parametros["dados_boleto"]["endereco1"]."<br /></div>";
    $html .= "<div class=\"titulo\">Sacador / Avalista</div></td><td class=\"td_7_sb\">&nbsp;</td>";
    $html .= "<td class=\"direito\" valign=\"top\"><div class=\"titulo\">CPF / CNPJ</div>";
    //dados do sacador
    $html .= "<div class=\"var\" style=\"text-align:left;\">".$parametros["obj_loja"]->getCnpj()."</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table>";
    $html .= "<table style=\"width:666px; border-top:solid; border-top-width:2px; border-top-color:#000000\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    $html .= "<tr><td class=\"td_7_sb\">&nbsp;</td>";
    //imagem codigo de barras
    $html .= "<td style=\"width: 417px; height:62px;\"><img src=\"view/img/boleto_cod.png\"</td>";
    $html .= "<td class=\"td_7_sb\">&nbsp;</td>";
    $html .= "<td valign=\"top\"><div class=\"titulo\" style=\"text-align:left;\">Autenticaçao Mecânica / FICHA DE COMPENSAÇAO</div></td>";
    $html .= "<td class=\"td_2\">&nbsp;</td></tr></table></div>";
    $html .= "</body></html>";
    //manda criar o arquivo texto
    $boletoc = new BoletoC();
    $array_arquivo = $boletoc->criaArquivoBoleto($html,$parametros["obj_boleto"]->getNumero_documento());
    //manda por ftp
    $ftpc = new FtpC();
    $ftpc->enviarArquivo($array_arquivo);
  }
}
