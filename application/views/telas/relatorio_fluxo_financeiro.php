
<p align='right'><table border="0"  id="icone_desbotado">
    <tr>    
    <td align="right">
            <?php echo "<a href='#'><img src='".base_url('public/img/impressora.png')."' title='Imprimir' width='50px' class='impressao' onClick='window.print();'></a>"; ?>
             
            </a>
        </td>
        </tr>
        </table></p>

<?php
echo "<body onLoad=\" window.opener.location.reload();\">";

echo'<body style="background-color:#FFFFFF;">';
echo"<fieldset>";
echo"<br>";

echo"<font size='6'><center><b>Relatório de Fluxo Financeiro</b></center></font></h2>";//TITULO
echo"<br>";

echo"<p align='left'>";
echo'<font size="5"><b>Período</b></font>';
echo"<br>";
echo"<br>";
echo '<b>De </b>'.$this->util->data_mysql_para_user($dataInicial);
echo '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Até </b>'.$this->util->data_mysql_para_user($dataFinal);
echo" </p>";
echo"<br>";
echo"<br>";
echo"</div>";

echo"<fieldset>";
echo"<legend>Lançamentos</legend>";
echo"<table border='0' width='100%'>";

echo"<tr  style='border-bottom: 1px solid #666666;'>";
echo"<td>Data</td>";
echo"<td>Descrição</td>";
echo"<td>Valor</td>";
echo"</tr>";
$dadosRelatorio = $dadosRelatorio;
if(dadosRelatorio !=null){
    $lucro = 0;
    $contasAPagar = 0;
    $vendas = 0;
foreach ($dadosRelatorio as $dados){

    $valor = ($dados->preco1+$dados->preco2+$dados->preco3)-$dados->desconto;
    
    if($dados->tipo == '0'){
        $lucro = $lucro - $valor;
        $contasAPagar = $contasAPagar + $valor;
    }else{
        $lucro = $lucro + $valor;
        $vendas = $vendas + $valor;
        
    }
    if($dados->tipo=='1' && $dados->descricao==''){
        $descricao = 'Venda sem cliente';
    }else{
        $descricao = $dados->descricao;
    }
    
   
echo"<tr>";
echo"<td style='border-left: 1px solid #666666;'>".$this->util->data_mysql_para_user($dados->data)."</td>";
echo"<td style='border-left: 1px solid #666666;'>".$descricao."</td>";
if($dados->tipo=='0'){
echo"<td style='border-left: 1px solid #666666;border-right: 1px solid #666666;'><font color='red'>R$ -".number_format($valor,2,',','')."</font></td>";
}else{
echo"<td style='border-left: 1px solid #666666;border-right: 1px solid #666666;'>R$ ".number_format($valor,2,',','')."</td>";
}
echo"</tr>";
}}
echo"<tr style='border-top: 1px solid #666666;'>";
echo"<td colspan='5'>&nbsp;</td>";
echo"</tr>";
echo"</table>";
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Detalhes</legend>";

echo"<br>";
echo"<table width='100%'>";


echo"<tr>";
echo"<td align='right'><b>Total de Débito </b></td>";
echo"<td align='left'>R$ ".  number_format($contasAPagar,'2',',','')."</td>";
echo"<td align='right'><b>Total de Crédito </b></td>";
echo"<td align='left'>R$ ".  number_format($vendas,'2',',','')."</td>";
echo"</tr>";
echo"<tr>";
echo"<td>&nbsp;</td>";
echo"</tr>";
echo"<tr>";
echo"<td>&nbsp;</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='4' align='right'>";
echo"<div align='right'><h3>Lucro Total: <font color='red'>".number_format($lucro,'2',',','')."</font><h3></div>";
echo"</td>";
echo"</tr>";
echo"</table>";
echo"</fieldset>";
echo"</fieldset>";







?>
    

    <script>

        var WinSizeHor = 900;
        var WinSizeVert = 800;
        posHoriz = parseInt((screen.availWidth / 2) - parseInt(WinSizeHor / 2))
        posVert = parseInt((screen.availHeight / 2) - parseInt(WinSizeVert / 2))
        self.moveTo(posHoriz, posVert);
        self.resizeTo(WinSizeHor, WinSizeVert);

        
    </script>
