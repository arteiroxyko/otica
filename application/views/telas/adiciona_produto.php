<!--<script language="javascript"> document.onkeydown = applyKey;-->
<!--</script>-->

<?php
//echo"<div id='div_dog'>";
//    echo "<img src='".base_url("public/img/true.png")."' width='20px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand; position:relative; top:-2px; left:8px; right:0px;' OnClick=\"abrirPopUp('".base_url("public/img/nika.jpg")."','628','628');\">";
//    echo "<img src='".base_url("public/img/true.png")."' width='20px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand; position:relative; top:-2px; left:8px; right:0px;' OnClick=\"abrirPopUp('".base_url("public/img/lisa.jpg")."','628','518');\">";
//    echo "<img src='".base_url("public/img/true.png")."' width='20px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand; position:relative; top:-2px; left:8px; right:0px;' OnClick=\"abrirPopUp('".base_url("public/img/mana.jpg")."','628','518');\">";
//    echo "<img src='".base_url("public/img/true.png")."' width='20px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand; position:relative; top:-2px; left:8px; right:0px;' OnClick=\"abrirPopUp('".base_url("public/img/manu.jpg")."','523','518');\">";
//    echo "<img src='".base_url("public/img/false.png")."' width='20px' title='Pesquisar Cliente' style='vertical-align: middle; cursor: hand; position:relative; top:-2px; left:8px; right:0px;' OnClick=\"ocultaDiv();\">";
//echo"</div>";

echo"<div class=formulario>";
echo"<h2>$titulo</h2>";

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onload=\"ocultaArmacao(); alert('$msg');\">";
}

// Boa pratica, pega variavel da Controller
$todos_fornecedor = $todos_fornecedor;
$todas_grife = $todas_grife;
$carrega = $carrega;

if($carrega == 1) {
    echo '<body onload="mostraArmacao();" />';
} else {
    echo '<body onload="ocultaArmacao();" />';
}

echo form_open('produto/adiciona');

// Campos da tabela Produto
echo"<fieldset>";
echo"<legend>Dados Básicos do Produto:</legend>";
echo"<table>";
echo"<tr><td>";
echo form_label('Categoria');
echo"</td><td>";
// Oculta campos e mostra campos de acordo com a escolha
if($carrega == 1) {
    echo '<body onload="mostraArmacao();" />';
    echo'<select name=produto onChange="mostra(value);">
       <option value="0"> Outro</option>
       <option value="1"  selected> Armação</option>
    </select>';
} else {
    echo '<body onload="ocultaArmacao();" />';
    echo'<select name=produto onChange="mostra(value);">
       <option value="0"> Outro</option>
       <option value="1"> Armação</option>
    </select>';
}

echo"</td>";
echo"<td>";
echo form_label('Codigo de Barra');
echo"</td><td>";
echo form_input(array('name'=>'cod_barra'),  set_value('cod_barra'), 'maxlength="20" placeholder="Código do Produto" autocomplete ="off" style="width:150px;" onpaste="return false;" autofocus');
echo"<tr><td>";
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>";
echo form_input(array('name'=>'nome'),  set_value('nome'), 'maxlength="50" placeholder="Nome do produto" autocomplete ="off" style="width:250px;" required title="Campo nome é obrigatório"');
echo"</td>";
echo"<td>";
echo form_label('Descrição');
echo"</td><td>"; 
echo form_input(array('name'=>'descricao'),  set_value('descricao'), 'placeholder="Descrição do produto" autocomplete ="off" style="width:250px;"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Preço de custo <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_custo'),  set_value('preco_custo'), 'id="precoCusto" maxlength="3" placeholder="0.000,00" autocomplete ="off" onkeypress="return(FormataReais(this,\'.\',\',\',event));" style="width:120px;" onpaste="return false;" required title="Campo preço é obrigatório"');
echo"</td>";
echo"<td>";
echo form_label('Preço de venda <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_venda'),  set_value('preco_venda'), 'id="precoVenda" maxlength="3" placeholder="0.000,00" autocomplete ="off" onkeypress="return(FormataReais(this,\'.\',\',\',event));" style="width:120px;" onpaste="return false;" required title="Campo preço é obrigatório"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Quantidade <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_type(array('name'=>'quantidade'), '1', 'max="99999999999" min="0" autocomplete="off" style="width:100px;" OnKeyPress="mascaraInteiro(this)" onpaste="return false;" required title="Campo quantidade é obrigatório"', 'number');
echo"</td><td>";
echo form_label('Validade');
echo"</td><td>"; 
echo form_type(array('name'=>'validade'),  set_value('validade'),'maxlength="10" autocomplete ="off" max="9999-12-31" min="'.date('d-m-Y').'"','date');
echo form_error('validade');
echo"</td></tr>";
echo"</table>";
echo"<p></p>";
    // div armacao, carrega campos de armacao
    echo'<div id="armacao">';
        echo"<fieldset>";
        echo"<legend>Dados da Armação:</legend>";
        echo"<table>";
        echo"<tr><td>";
        echo form_label('Largura da lente');
        echo"</td><td>"; 
        echo form_input(array('name'=>'largura_lente'),  set_value('largura_lente'),'maxlength="11" placeholder="xx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"</td>";
        echo"<td>";
        echo form_label('Largura da ponte');
        echo"</td><td>"; 
        echo form_input(array('name'=>'largura_ponte'),  set_value('largura_ponte'),'maxlength="11" placeholder="xx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"</td></tr>";
        echo"<tr><td>";
        echo form_label('Comprimento da haste');
        echo"</td><td>";
        echo form_input(array('name'=>'comprimento_haste'),  set_value('comprimento_haste'),'maxlength="11" placeholder="xxx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"<td>";
        echo form_label('Fornecedor');
        echo"</td><td>";
        echo'<select name="fornecedor">';
        echo'<option value="">Selecione...</option>';
        if ($todos_fornecedor != NULL) {
            foreach ($todos_fornecedor as $linha) {
                echo'<option value="'.$linha -> id_fornecedor.'">'.$linha -> nome.'</option>';
           }
        }
        echo'</select>';
        echo"</td></tr>";
        echo"<tr><td>";
        echo form_label('Modelo');
        echo"</td><td>"; 
        echo form_input(array('name'=>'modelo'),  set_value('modelo'),'maxlength="11" placeholder="XX-xxx" autocomplete ="off"');
        echo"</td>";
        echo"<td>";
        echo form_label('Grife');
        echo"</td><td>";    
        echo'<select name="grife">';
        echo'<option value="">Selecione...</option>';
        if ($todas_grife != NULL) {
            foreach ($todas_grife as $linha) {
                echo'<option value="'.$linha -> id.'">'.$linha -> nome.'</option>';

            }    
        }
        echo'</select>';
        echo"</td></tr>";
        echo"</table>";
        echo"</fieldset>";
    echo"</div>";
echo"<p></p>";
echo"<table>";
echo"<tr><td>";
echo form_label('','',array('style' => 'padding-right:80px;',));
echo form_submit('', 'Cadastrar','');
echo"</td></tr>"; 
echo"</table>";
echo "</div>";
echo"</fieldset>";

echo form_close();
?>
