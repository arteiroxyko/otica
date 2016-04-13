<!--Manuela-->
<?php

echo"<div class=formulario style='  margin-left: 40px; width: 700px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";
$id_produto = $this->uri->segment(3);

if($id_produto == NULL){
    redirect ('produto/lista');
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
echo form_input(array('name'=>'cod_barra'), set_value('cod_barra', $query['produto']->cod_barra), 'placeholder="Código do Produto" autocomplete ="off" style="width:150px;" onpaste="return false;" readonly');
echo"</td><td align='right'>";
echo form_label('Nome');
echo"</td><td>";
echo form_input(array('name'=>'nome'),
        set_value('nome', $query['produto']->nome), 'placeholder="Nome do produto" style="width:260px;" readonly');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Descricao');
echo"</td><td colspan='4'>"; 
echo form_input(array('name'=>'descricao'),
        set_value('descricao', $query['produto']->descricao), 'placeholder="Descrição do produto" style="width:520px;" readonly');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Preco de custo');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_custo'),
        set_value('preco_custo', $this->util->pontoParaVirgula($query['produto']->preco_custo)), 'placeholder="0.000,00" style="width:80px;" readonly');
echo"</td><td>";
echo form_label('Preco de venda');
echo"</td><td>"; 
echo form_input(array('name'=>'preco_venda'),
        set_value('preco_venda', $this->util->pontoParaVirgula($query['produto']->preco_venda)), 'placeholder="0.000,00" style="width:80px;" readonly');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Quantidade');
echo"</td><td>"; 
echo form_type(array('name'=>'quantidade'),
        set_value('quantidade', $query['produto']->quantidade), 'style="width:80px;" readonly', 'number');
echo"</td><td>";
echo form_label('Validade');
echo"</td><td>"; 
echo form_type(array('name'=>'validade'),  set_value('validade', $query['produto']->validade),'readonly','date');
echo form_error('validade');
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
        echo form_input(array('name'=>'largura_lente'), set_value('largura_lente', $query['armacao']->largura_lente),'placeholder="xx" readonly');
        echo"</td><td>";
        echo form_label('Largura da ponte');
        echo"</td><td>"; 
        echo form_input(array('name'=>'largura_ponte'), set_value('largura_ponte', $query['armacao']->largura_ponte),'placeholder="xx" readonly');
        echo"</td></tr>";
        echo"<tr><td>";
        echo form_label('Comprimento da haste');
        echo"</td><td>"; 
        echo form_input(array('name'=>'comprimento_haste'),
                set_value('comprimento_haste', $query['armacao']->comprimento_haste),'placeholder="xxx" readonly');
        echo"</td><td>";
        echo form_label('Modelo');
        echo"</td><td>"; 
        echo form_input(array('name'=>'modelo'), set_value('modelo', $query['armacao']->modelo),'placeholder="XX-xxx" readonly');
        echo"</td></tr>";
        if ($query['grife']->id != null) {
            echo"<tr><td>";
            echo form_label('Grife');
            echo"</td><td>";    
            if ($todas_grife != NULL) {
                foreach ($todas_grife as $linha) {
                    if($query['grife']->id == $linha->id) {
                        echo form_input(array('name'=>'grife'), set_value('grife', $query['grife']->nome),'readonly');
                    }
                }
            }
            echo'</select>';
            echo"</td>";
        }
        if ($query['fornecedorE']->id != null) {
            echo"<td>";
            echo form_label('Fornecedor');
            echo"</td><td>";
            if ($todos_fornecedor != NULL) {
                foreach ($todos_fornecedor as $linha) {
                    if($query['fornecedorE']->id == $linha -> id_fornecedor) {
                        echo form_input(array('name'=>'fornecedor'), set_value('grife', $linha->nome),'readonly');
                    }
               }
               echo'</select>';
               echo"</td></tr>";
            }
        }
        echo"</fieldset>";
        echo"</table>";
echo"</div>";
}
echo'<a href="'.$this->session->userdata('paginaAnterior').'"><img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar" /></a>';
echo"</fieldset>";

echo form_close();
?>