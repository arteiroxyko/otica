<p align='right'><table border="0"  id="icone_desbotado">
    <tr>    
    <td align="right">
            <?php echo "<a href='#'><img src='".base_url('public/img/impressora.png')."' title='Imprimir' width='50px' class='impressao' onClick='window.print();'></a>"; ?>
             
            </a>
        </td>
        </tr>
        </table></p>

<?php
echo'<body style="background-color:#FFFFFF;">';
echo"<fieldset>";
echo"<div style='background-image: url(".base_url('public/img/logo_venda.png').");background-repeat: no-repeat;background-size: 100px;'>";
echo"<br>";

echo"<font size='5'><center><b>Orçamento</b></center></font></h2>";//TITULO
echo"<br>";

$dados_orcamento = $dados_orcamento;//Boas praticas, captura o orçamento da controler

echo"<p align='right'>";
echo'<b>Data do Orçamento: </b>';
echo $this->util->data_mysql_para_user($dados_orcamento['orcamento']->data);
echo" </p>";
echo"</div>";
echo"<fieldset>";
echo"<legend>Dados do Cliente:</legend>";
echo"<table width='100%'>";//Essa linha pode remover

//Mostra cabeçalhodo do cliente
echo"<tr><td>";//Essa linha pode remover
echo"<b>Nome: </b>";
echo $dados_orcamento['pessoa']->nome;
echo"</td>";
echo"<td>";//Essa linha pode remover
echo "<b>CPF: </b>";
echo $dados_orcamento['cliente']->cpf;
echo"</td>";
echo"</tr>";
echo"<tr><td>&nbsp;</td></tr>";
echo"<tr>";
echo"<td><b>Email: </b>";
echo $dados_orcamento['pessoa']->email."</td>";   
echo"</td></tr>";//Essa linha pode remover
echo"</table>";
echo"<br>";
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Produtos/Serviço:</legend>";
echo"<table border='0' width='100%'>";

echo"<tr  align='center' style='border-bottom: 1px solid #666666;'>";
echo"<td>Código</td>";
echo"<td>Nome</td>";
echo"<td>Qtd.</td>";
echo"<td>Valor Unitário</td>";
echo"<td>Sub Total</td>";
echo"</tr>";

if($dados_orcamento['itens']!=null){
foreach ($dados_orcamento['itens'] as $itens){

echo"<tr>";
echo"<td style='border-left: 1px solid #666666;'>".$itens->id_produto."</td>";
echo"<td style='border-left: 1px solid #666666;'>".$itens->nome."</td>";
echo"<td style='border-left: 1px solid #666666;'>".$itens->quantidade."</td>";
echo"<td style='border-left: 1px solid #666666;'>R$ ".number_format($itens->preco_unitario,'2',',','')."</td>";
echo"<td style='border-left: 1px solid #666666;border-right: 1px solid #666666;'>R$ ".$subTotal_aux = number_format($itens->preco_unitario*$itens->quantidade,'2',',','')."</td>";
echo"</tr>";
$subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;

}}
if($dados_orcamento['lentes']!=null){
foreach ($dados_orcamento['lentes'] as $lente){

echo"<tr>";
echo"<td style='border-left: 1px solid #666666;'>R".$lente->referencia."</td>";
echo"<td style='border-left: 1px solid #666666;'>".$lente->nome."</td>";
echo"<td style='border-left: 1px solid #666666;'>1</td>";
echo"<td style='border-left: 1px solid #666666;'>R$ ".number_format($lente->preco_venda,'2',',','')."</td>";
echo"<td style='border-left: 1px solid #666666;border-right: 1px solid #666666;'>R$ ".$subTotal_aux = number_format($lente->preco_venda,'2',',','')."</td>";
echo"</tr>";
$subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;

}}
if($dados_orcamento['servicos']!=null){
foreach ($dados_orcamento['servicos'] as $servico){

echo"<tr>";
echo"<td style='border-left: 1px solid #666666;'>S000</td>";
echo"<td style='border-left: 1px solid #666666;'>".$servico->nome."</td>";
echo"<td style='border-left: 1px solid #666666;'>1</td>";
echo"<td style='border-left: 1px solid #666666;'>R$ ".number_format($servico->preco_venda,'2',',','')."</td>";
echo"<td style='border-left: 1px solid #666666;border-right: 1px solid #666666;'>R$ ".$subTotal_aux = number_format($servico->preco_venda,'2',',','')."</td>";
echo"</tr>";
$subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;

}}
echo"<tr style='border-top: 1px solid #666666;'>";
echo"<td colspan='5'>&nbsp;</td>";
echo"</tr>";

echo"<tr>";
echo"<td colspan='3'></td>";
echo"<td align='right'><b>Subtotal: </b></td>";
echo"<td align='left'>".  number_format($subTotal,'2',',','')."</td>";
echo"</tr>";
echo"</table>";
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Detalhes</legend>";

echo"<br>";
echo"<table width='100%'>";
echo"<tr>";
echo"<td>";
echo"Forma de Pagamento: ".$dados_orcamento['formaPgto']->nome;
echo "</td>";
echo"<td>";
echo"<div align='right'><b>Desconto: ".number_format($desconto=$dados_orcamento['orcamento']->desconto,'2',',','')."</b></div>";
echo "</td>";
echo"</tr>";
echo"<tr><td colspan='2'>&nbsp;</td></tr>";
echo"<tr>";
echo"<td>";
echo"Vendedor: ".$dados_orcamento['orcamento']->vendedor;
echo "</td>";
echo"<td>";
echo"<div align='right'><h3>Total: <font color='red'>".number_format($subTotal-$desconto,'2',',','')."</font><h3></div>";
echo "</td>";
echo"</tr>";

echo"</table>";
echo"<br>";
echo"<br>";
echo"</fieldset>";
echo"<center><font size='3'>Ótica  - Rua XV, 1 Centro Curitiba - Fone: (41) 3057-0000</font></center>";
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
