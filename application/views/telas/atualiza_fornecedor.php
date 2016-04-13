<?php
echo"<div class=formulario style='  margin-left: 20px; width: 500px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";


$id_pessoa = $this->uri->segment(3);
$id_fornecedor = $this->uri->segment(4);

if($id_pessoa == NULL || $id_fornecedor == NULL){
    redirect ('fornecedor/lista');
}

$query = $this->fornecedor_model->get_byid($id_pessoa,$id_fornecedor);

if($this->session->flashdata('statusUpdate')){
    $msg = $this->session->flashdata('statusUpdate');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

echo form_open("Fornecedor/update/$id_pessoa/$id_fornecedor");

echo"<fieldset>";
echo"<legend>Dados Básicos:</legend>";
echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome'),  set_value('nome',$query['pessoa']->nome),'maxlength="100" autocomplete ="off" placeholder="Nome Completo do Fornecedor" autofocus style="width:300px;" required title="Campo Nome é obrigatório"');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Email');
echo"</td><td>";//Essa linha pode remover
echo form_input(array('name'=>'email'),set_value('email',$query['pessoa']->email),'maxlength="100" autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;"','email');
echo form_error('email');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('CNPJ <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cnpj'),  set_value('cnpj',$query['fornecedor']->cnpj),'maxlength="18" autocomplete ="off" placeholder="XX.XXX.XXX/XXXX-XX" OnKeyPress="MascaraCNPJ(this)" required title="Campo CNPJ é obrigatório" readonly');
echo form_error('cnpj');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Fixo');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone1'),  set_value('num_telefone1',$query['telefone'][0]->num_telefone),'maxlength="14" autocomplete ="off" placeholder="(XX)XXXX-XXXX" OnKeyPress="MascaraTelefone(this)" onpaste="return false"');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Celular');
echo"</td><td>"; //Essa linha pode remover<td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone2'),  set_value('num_telefone2',$query['telefone'][1]->num_telefone),'maxlength="15" autocomplete ="off" placeholder="(XX) XXXXX-XXXX" OnKeyPress="MascaraTelefone(this)" onChange="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXXX-XXXX" onpaste="return false"');
echo"</td></tr>";//Essa linha pode remover

echo"</tr><td>"; //Essa linha pode remover
echo"<td>"; //Essa linha pode remover
echo form_submit(array('name'=>'Alterar'),'Alterar');
echo"</td><tr>"; //Essa linha pode remover
echo"</table>"; //Essa linha pode remover
echo "</fieldset>";
echo "</div>";

echo form_hidden('id_pessoa',$id_pessoa);//Campo oculto que armazena id_pessoa
echo form_hidden('id_fornecedor',$id_fornecedor);//Campo oculto que armazena id_cliente
echo form_close();

?>
