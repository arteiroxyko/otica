<?php

echo"<div class=formulario style='  margin-left: 40px; width: 700px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";
$id_produto = $this->uri->segment(3);

if($id_produto == NULL){
    redirect ('produto/lista');
}

if($this->session->flashdata('statusUpdate')){
    $msg = $this->session->flashdata('statusUpdate');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

$query = $this->produto_model->get_byid($id_produto);
echo form_open("Produto/update/$id_produto");

$todos_fornecedor = $this -> fornecedor_model -> getAll() -> result();
$todas_grife = $this -> grife_model -> getAll() -> result();

echo"<fieldset>";
echo"<legend>Produto</legend>";
echo"<table>";
// Campos da tabela Produto
//echo"<center><table>";
echo"<tr><td>";
echo form_label('Código de Barras');
echo"</td><td>";
echo form_input(array('name'=>'cod_barra'), set_value('cod_barra', $query['produto']->cod_barra), 'maxlength="20" placeholder="Código do Produto" autocomplete ="off" style="width:150px;" onpaste="return false;"');
echo"</td><td align='right'>";
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>";
echo form_input(array('name'=>'nome'),
        set_value('nome', $query['produto']->nome), 'maxlength="50" placeholder="Nome do produto" autocomplete ="off" style="width:260px;" required title="Campo nome é obrigatório"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Descricao');
echo"</td><td colspan='4'>"; 
echo form_input(array('name'=>'descricao'),
        set_value('descricao', $query['produto']->descricao), 'placeholder="Descrição do produto" autocomplete ="off" style="width:520px;"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Preco de custo <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_custo'),
        set_value('preco_custo', $this->util->pontoParaVirgula($query['produto']->preco_custo)), 'maxlength="3" placeholder="0.000,00" autocomplete ="off" onkeypress="return(FormataReais(this,\'.\',\',\',event));" style="width:120px;" onpaste="return false;" required title="Campo preço é obrigatório"');
echo"</td><td>";
echo form_label('Preco de venda <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_venda'),
        set_value('preco_venda', $this->util->pontoParaVirgula($query['produto']->preco_venda)), 'maxlength="3" placeholder="0.000,00" autocomplete ="off" onkeypress="return(FormataReais(this,\'.\',\',\',event));" style="width:120px;" onpaste="return false;" required title="Campo preço é obrigatório"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Quantidade <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_type(array('name'=>'quantidade'),
        set_value('quantidade', $query['produto']->quantidade), 'max="99999999999" min="0" autocomplete="off" style="width:80px;" OnKeyPress="mascaraInteiro(this)" onpaste="return false;" required title="Campo quantidade é obrigatório"', 'number');
echo"</td><td>";
echo form_label('Validade');
echo"</td><td>"; 
echo form_type(array('name'=>'validade'),  set_value('validade', $query['produto']->validade),'maxlength="10" autocomplete ="off" min="'.date('d-m-Y').'"','date');
echo form_error('validade');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Ativo');
echo"</td><td>";
if($query['produto']->status == 1) {
    echo '<input name="status" type="checkbox" id = "ativo" checked/>';
} else {
    echo '<input name="status" type="checkbox" id = "ativo"/>';
}
echo"</td></tr>";
echo "</table>";
echo "<br>";
// Oculta campos e mostra campos de acordo com a escolha
if($query['produto']->categoria == 1) {
// div armacao, carrega campos de armacao
echo'<div id="armacao">';
        echo"<fieldset>";
        echo"<legend>Armação</legend>";
        echo "<table>";
        echo"<tr><td>";
        echo form_label('Largura da lente');
        echo"</td><td>"; 
        echo form_input(array('name'=>'largura_lente'), set_value('largura_lente', $query['armacao']->largura_lente),'maxlength="11" placeholder="xx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"</td><td>";
        echo form_label('Largura da ponte');
        echo"</td><td>"; 
        echo form_input(array('name'=>'largura_ponte'), set_value('largura_ponte', $query['armacao']->largura_ponte),'maxlength="11" placeholder="xx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"</td></tr>";
        echo"<tr><td>";
        echo form_label('Comprimento da haste');
        echo"</td><td>"; 
        echo form_input(array('name'=>'comprimento_haste'),
                set_value('comprimento_haste', $query['armacao']->comprimento_haste),'maxlength="11" placeholder="xxx" autocomplete ="off" OnKeyPress="mascaraInteiro(this)" onpaste="return false;"');
        echo"</td><td>";
        echo form_label('Modelo');
        echo"</td><td>"; 
        echo form_input(array('name'=>'modelo'), set_value('modelo', $query['armacao']->modelo),'maxlength="11" placeholder="XX-xxx" autocomplete ="off"');
        echo"</td></tr>";
        echo"<tr><td>";
        echo form_label('Grife');
        echo"</td><td>";    
        echo'<select name="grife">';
        echo'<option value="">Selecione...</option>';
        if ($todas_grife != NULL) {
            foreach ($todas_grife as $linha) {
                if($query['grife']-> id == $linha -> id) {
                    echo'<option selected value="'.$linha -> id.'">'.$linha -> nome.'</option>';
                } else {
                    echo'<option value="'.$linha -> id.'">'.$linha -> nome.'</option>';
                }
            }
        }
        echo'</select>';
        echo"</td><td>";
        echo form_label('Fornecedor');
        echo"</td><td>";
        echo'<select name="fornecedor">';
        echo'<option value="">Selecione...</option>';
        if ($todos_fornecedor != NULL) {
            foreach ($todos_fornecedor as $linha) {
                if($query['fornecedorE']-> id == $linha -> id_fornecedor) {
                    echo'<option selected value="'.$linha -> id_fornecedor.'">'.$linha -> nome.'</option>';
                } else {
                    echo'<option value="'.$linha -> id_fornecedor.'">'.$linha -> nome.'</option>';
                }
           }
        }
        echo'</select>';
        echo"</td></tr>";
        echo"</fieldset>";
        echo"</table>";
echo"</div>";
}

echo"<p>";
echo"<table>";
echo"<tr><td>";
echo form_label('','',array('style' => 'padding-right: 75px;',));
echo form_submit('', 'Alterar','onClick="if(! document.getElementById(\'ativo\').checked) {if (! confirm(\'Deseja desativar esse produto?\')){ return false; }}"');
echo"</td></tr>";
echo"</table>";
echo"</fieldset>";
echo "</div>";

echo form_hidden('id_produto',$id_produto);
echo form_hidden('produto',$query['produto']->categoria);

echo form_close();
?>