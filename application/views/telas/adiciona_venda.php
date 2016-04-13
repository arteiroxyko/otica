<script language=JavaScript>
    function ativaEnter(event, id, url) {
        if (event.keyCode === 13) {

            if (id === 'codigoBarras')
                var campoBusca = 'cod_barra';
            if (id === 'codigoProduto')
                var campoBusca = 'id';
            
            var valor = document.getElementById(id).value;
            if(valor.match(' ') || valor.match('%')){
                alert('Produto não encontrado');
                document.getElementById(id).value='';
                return false;
            }
            
            
            
            document.forms['formularioVenda'].onsubmit = function() {
                return false;
            }
            window.location.href = url + '/' + document.getElementById(id).value + '/' + campoBusca;
        }
    }
    function ativaEnterProduto(event, id, url) {
        if (event.keyCode === 13) {

            if (document.getElementById('quantidadeProduto').value > 9999) {

            } else {


                document.forms['formularioVenda'].onsubmit = function() {
                    return false;
                }
                window.location.href = url + '?id_produto=' + document.getElementById('idProduto').value + '&nome_produto=' + document.getElementById('nomeProduto').value + '&preco_venda=' + document.getElementById('precoVenda').value + '&quantidade_produto=' + document.getElementById('quantidadeProduto').value;
            }
        }
    }
    function ativaOnClickProduto(url) {
        if (document.getElementById('quantidadeProduto').value > 9999) {
        } else {

            document.forms['formularioVenda'].onsubmit = function() {
                return false;
            }
            window.location.href = url + '?id_produto=' + document.getElementById('idProduto').value + '&nome_produto=' + document.getElementById('nomeProduto').value + '&preco_venda=' + document.getElementById('precoVenda').value + '&quantidade_produto=' + document.getElementById('quantidadeProduto').value;
        }
    }
    function descontoVenda() {
        
        var subtotal = parseFloat(document.getElementById('subtotal').value.replace(",", "."));
        desconto = parseFloat(document.getElementById('desconto').value.replace(",", "."));
        var total = document.getElementById('total');
        if (document.getElementById('desconto').value === '')
            desconto = 0;
         if (desconto <= subtotal) {
            total.value = number_format(subtotal - desconto, 2, ',', '');
           dadosSessao('descontoSessao',document.getElementById('desconto').value.replace(",", "."));
        } else {
            alert('O valor do desconto não pode ser maior que o valor da venda!');
            document.getElementById('desconto').value = number_format(0, 2, ',', '');
            total.value = number_format(subtotal, 2, ',', '');
           dadosSessao('descontoSessao',document.getElementById('desconto').value.replace(",", "."));
            return false;
        }

    }

    function envia(pag) {

        var form = document.getElementById('formularioVenda');

        form.action = pag;
        form.method = 'post';
        form.submit();
    }
    
function dadosSessao(nome,dado)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
xmlhttp.onreadystatechange=function()
  {
  }
xmlhttp.open("GET","<?php echo base_url('venda/dadosSessao/')?>?"+nome+"="+dado,true);
xmlhttp.send();
}
   
</script>


</script>  
<div id='teste'></div>
<?php
if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}
if ($this->session->flashdata('orcamentoOk')) {
    $msg = $this->session->flashdata('orcamentoOk');
    echo "<body onLoad=\" 
        if(confirm('$msg')){
       abrirPopUp('" . base_url("venda/exibeOrcamento/" . $this->session->flashdata('id_orcamento')) . "','900','800');
    }else{}
            
\">";
}
if ($this->session->flashdata('vendaOk')) {
    $msg = $this->session->flashdata('vendaOk');
    echo "<body onLoad=\" 
        if(confirm('$msg')){
       abrirPopUp('" . base_url("venda/exibeVenda/" . $this->session->flashdata('id_venda')) . "','900','800');
    }else{}
            
\">";
}
if($_GET['nomeCliente']!=null) $nome_cliente = $_GET['nomeCliente'];
$cpf_cliente = $_GET['cpfCliente'];
$id_cliente = $_GET['idCliente'];

if ($nome_cliente != null)
    $this->session->set_userdata('nome_cliente', $nome_cliente);
if ($cpf_cliente != null)
    $this->session->set_userdata('cpf_cliente', $cpf_cliente);
if ($id_cliente != null)
    $this->session->set_userdata('id_cliente', $id_cliente);
if ($this->session->userdata('nome_cliente') == null)
    $this->session->set_userdata('nome_cliente', 'Cliente não definido');
if ($this->session->userdata('cpf_cliente') == null)
    $this->session->set_userdata('cpf_cliente', '000.000.000-00');
if ($this->session->userdata('id_cliente') == null)
    $this->session->set_userdata('id_cliente', '0');

echo"<div class=formulario>";
echo"<h2>$titulo</h2>";

echo form_open('venda', 'id="formularioVenda" name="formVenda');


echo"<fieldset>";
echo"<legend>Vendedor:</legend>";
echo form_input(array('name' => 'vendedor'), $this->session->userdata('nome'), 'style="width:400px;" readonly');
echo"</fieldset>";

echo"<fieldset>";
echo"<legend>Cliente:</legend>";
echo form_input(array('name' => 'cliente'), $this->session->userdata('nome_cliente'), 'id="nomeCliente" style="width:400px; height:25px;" readonly');
echo form_label('CPF');
echo form_input(array('name' => 'cpf'), $this->session->userdata('cpf_cliente'), 'id="cpfCliente" style="width:125px; height:25px;" readonly');
echo "<img src='" . base_url("public/img/list.png") . "' width='33px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand;' OnClick=\"abrirPopUp('" . base_url('venda/listarClientes') . "','600','445');\">";
echo"</fieldset>";

echo"<fieldset>";
echo"<legend>Produtos e Pagamento:</legend>";

if ($this->session->flashdata('autoFocusQuantidade') == 'autofocus') {
    $autoFocusQuantidade = 'autofocus';
    $autoFocusCodigoBarras = '';
} else {
    $autoFocusQuantidade = '';
    $autoFocusCodigoBarras = 'autofocus';
}


echo"<table>";
echo"<tr>";
echo"<td>" . form_label('Cod. Barras') . "</td>";
echo"<td>" . form_input(array('name' => 'codigo_barras'), $this->session->userdata('codigo_barras_temp'), 'autocomplete ="off" id="codigoBarras" style="width:210px; height:25px;" onkeypress=ativaEnter(event,"codigoBarras","' . base_url('venda/listarProdutosURL') . '") ' . $autoFocusCodigoBarras) . "</td>";
echo"<td>" . form_label('Cod.') . "</td>";
echo"<td>" . form_input(array('name' => 'codigo_produto'), $this->session->userdata('codigo_produto_temp'), 'autocomplete ="off" id="codigoProduto" style="width:123px; height:25px;" onkeypress=ativaEnter(event,"codigoProduto","' . base_url('venda/listarProdutosURL') . '")') . "</td>";
echo"<td>" . form_label('Qtd.') . "</td>";
echo"<td>" . form_type(array('name' => 'quantidade'), $this->session->userdata('quantidade_temp'), 'autocomplete ="off" id="quantidadeProduto" min="1" max ="' . $this->session->userdata('quantidade_max') . '" style="width:75px; height:25px;" onkeypress=ativaEnterProduto(event,"quantidadeProduto","' . base_url('venda/adicionaProduto') . '") ' . $autoFocusQuantidade . ' ', 'number') . "</td>";
echo"<td><img src='" . base_url("public/img/list.png") . "' width='33px' title='Pesquisar Produto' style='vertical-align: middle; cursor: hand;' OnClick=\"abrirPopUp('" . base_url('venda/listarProdutos') . "','750','445');\"></td>";
echo"<td>&nbsp;</td>";
echo"<td>&nbsp;</td>";
echo"<td><img src='" . base_url("public/img/lente.png") . "' width='40px' title='Adicionar Lente' style='vertical-align: middle; cursor: hand;' OnClick=\" abrirPopUp('" . base_url('venda/adicionaLente') . "','490','300');\"></td>";
echo"<td>&nbsp;</td>";
echo"<td>&nbsp;</td>";
echo"<td><img src='" . base_url("public/img/servico.png") . "' width='40px' title='Adicionar Serviço' style='vertical-align: middle; cursor: hand;' OnClick=\"abrirPopUp('" . base_url('venda/adicionaServico') . "','490','400');\"></td>";

echo"</tr>";



echo"<tr>";
echo"<td>" . form_label('Produto') . "</td>";
echo"<td>" . form_input(array('name' => 'nome_produto'), $this->session->userdata('nome_produto_temp'), 'id="nomeProduto" style="width:210px; height:25px;" readonly') . "</td>";
echo"<td>" . form_label('Preço Uni.') . "</td>";
echo"<td>" . form_input(array('name' => 'preco_venda'), $this->session->userdata('preco_venda_temp'), 'id="precoVenda" style="width:123px; height:25px;" readonly') . "</td>";
echo"<td><a href='javascript:ativaOnClickProduto(\"" . base_url("venda/adicionaProduto") . "\");' ><img src='" . base_url("public/img/add_carrinho.png") . "' width='33px' title='Adicionar Produto na Lista' style='vertical-align: middle; cursor: hand;' ></a></td>";

echo"</tr>";

echo"</table>";

echo'<div id="data-grid-local"></div>';
?>
<script>
    (function($) {
        var $dgLocal = $('#data-grid-local')

        $dgLocal.datagrid({
            jsonStore: {
                data: {"rows": [
<?php
$subTotal=0;
foreach ($this->session->userdata('itens') as $itens) {

    echo '{"Cod":"' . $itens["idProduto"] . '","nome":"' . $itens["nomeProduto"] . '","Qtd":"' . $itens["quantidadeProduto"] . '","valor_unitario":" R$ ' . $itens["precoVenda"] . '","sub_total":"R$ ' . $subTotal_aux = $this->util->pontoParaVirgula($this->util->virgulaParaPonto($itens["precoVenda"]) * $itens["quantidadeProduto"]) . '"},';
    $subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;
}
foreach ($this->session->userdata('lente') as $lentes) {

    echo '{"Cod":"' .'R'. $lentes["referencia"] . '","nome":"' .$lentes["nome_lente"] . '","Qtd":"' . $lentes["quantidade_lente"] . '","valor_unitario":" R$ ' . $lentes["preco_venda"] . '","sub_total":"R$ ' . $subTotal_aux = $this->util->pontoParaVirgula($this->util->virgulaParaPonto($lentes["preco_venda"]) * $lentes["quantidade_lente"]) . '"},';
    $subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;
}
foreach ($this->session->userdata('servico') as $servicos) {

    echo '{"Cod":"S000","nome":"' . $servicos["nome"] . '","Qtd":"' . $servicos["quantidade_servico"] . '","valor_unitario":" R$ ' . $servicos["preco"] . '","sub_total":"R$ ' . $subTotal_aux = $this->util->pontoParaVirgula($this->util->virgulaParaPonto($servicos["preco"]) * $servicos["quantidade_servico"]) . '"},';
    $subTotal = $this->util->virgulaParaPonto($subTotal_aux) + $subTotal;
}
?>

                    ]}
            }
            , pagination: false
                    , height: 115
                    , rowClick: false
                    , rowHover: false


                    , mapper: [{
                    name: 'Cod', alias: 'Código', css: {width: 1, textAlign: 'left'}
                }, {
                    name: 'nome', alias: 'Nome', css: {width: 350, textAlign: 'left'}
                }, {
                    name: 'Qtd', alias: 'Qtd', css: {width: 7, textAlign: 'left'}
                }, {
                    name: 'valor_unitario', alias: 'Valor Unitário', css: {textAlign: 'left'}
                }, {
                    name: 'sub_total', alias: 'Subtotal', css: {width: 150, textAlign: 'left'}
                }]
        })

    })(jQuery)

</script>
<?php
//Se não foi preenchido o valor de descophpnto adicionar o valor subtotal para o total
$total = $subTotal - $this->session->userdata('valor_desconto_venda');

//Se não tiver o adicionado o forma de pagamento ele tem valor 1
if($this->session->userdata('formaPgto')==null)$this->session->set_userdata('formaPgto','1');


echo"<table width='100%' align='right'>";
echo"<tr align='right'>";
echo"<td align ='left' colspan='2' width='70%'>";
echo form_label('Forma de Pagamento');
echo form_dropdown('forma_pagamento', array('1' => 'Dinheiro', '2' => 'Cartão de Crédito', '3' => 'Cartão de Débito', '4' => 'Cheque'), $this->session->userdata('formaPgto'), "Onchange=\" dadosSessao('formaPgto',this.value); if(this.value == '4'){ if(confirm('Desejá cadastrar os cheques agora?')){}else{return false;}abrirPopUp('" . base_url('venda/adicionarCheques') . "','645','400');}\"") . "<a href=javascript:abrirPopUp('" . base_url('venda/adicionarCheques') . "','645','400'); ><img src='" . base_url("public/img/cheque.png") . "' width='50px' title='Adicionar Cheques' style='vertical-align: middle; cursor: hand;' ></a></td>";

echo"<td>" . form_label('Subtotal') . "</td>";
echo"<td>" . form_input(array('name' => 'sub_total'), number_format($subTotal, '2', ',', ''), 'id="subtotal" style="width:125px; height:23px;" readonly') . "</td>";
echo"<td width='18px'> </td>";
echo"</tr>";
echo"<tr align='right'>";
echo"<td align ='left'></td>";
echo"<td width='40%'></td>";
echo"<td>" . form_label('Desconto') . "</td>";
echo"<td>" . form_input(array('name' => 'desconto'), number_format($this->session->userdata('valor_desconto_venda'), '2', ',', ''), 'id="desconto" autocomplete="off" style="width:125px; height:23px;" onkeyup="descontoVenda(event);" onkeypress="return(FormataReais(this,\'.\',\',\',event));" onkepress="descontoVenda(event);" ') . "</td>";
echo"</tr>";
echo"<tr align='right'>";
echo"<td align ='left'></td>";
echo"<td align='left' width='70%'>
     <div align='left' style='float:left; width:100px;'><input type='button' name='finalizar' value='Finalizar' onClick= if(confirm('Tem&nbsp;certeza&nbsp;que&nbsp;deseja&nbsp;finalizar&nbsp;a&nbsp;venda?')){envia('" . base_url("venda/gerarVenda") . "');}else{} ></div>
     <div align='center' style='float:left;'><input type='button' name='orcamento' value='Orçamento' onClick= if(confirm('Tem&nbsp;certeza&nbsp;que&nbsp;deseja&nbsp;salvar&nbsp;o&nbsp;Orçamento?')){envia('" . base_url("venda/gerarOrcamento") . "');}else{} ></div>
     <div align='right' style='float:left; width:100px;'><input type='button' name='finalizar' value='Cancelar' onClick= if(confirm('Tem&nbsp;certeza&nbsp;que&nbsp;deseja&nbsp;cancelar&nbsp;a&nbsp;venda?')){envia('" . base_url("venda/limparVenda") . "');}else{} ></div>
</td>";
echo"<td>" . form_label('<b>Total</b>') . "</td>";
echo"<td>" . form_input(array('name' => 'total'), number_format($total, '2', ',', ''), 'id="total" style="width:125px; height:23px;" readonly') . "</td>";
echo"</tr>";
echo"</table>";

echo '<input type="hidden" value="' . $this->session->userdata('id_cliente') . '" name="id_cliente" id="idCliente" />';
echo '<input type="hidden" value="' . $this->session->userdata('id_produto_temp') . '" name="id_produto" id="idProduto" />';

echo"</fieldset>";

echo form_close();

echo "</div>";
?>
