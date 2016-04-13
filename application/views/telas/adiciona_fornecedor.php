<?php

echo"<div class=formulario>";
echo"<h2>$titulo</h2>";

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onLoad=\" alert('$msg');\">";
}

echo form_open('fornecedor/adiciona');

echo"<fieldset>";
echo"<legend>Dados Básicos:</legend>";
echo"<table>";
echo"<tr><td>";
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'nome'),  set_value('nome'),'maxlength="100" autocomplete ="off" placeholder="Nome Completo do Fornecedor" autofocus style="width:300px;" required title="Campo Nome é obrigatório" onkeypress="return SomenteLetras(event);"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Email');
echo"</td><td>";
echo form_type(array('name'=>'email'),set_value('email'),'maxlength="100" autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;"','email');
echo form_error('email');
echo"<tr><td>";
echo form_label('CNPJ <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'cnpj'),  set_value('cnpj'),'maxlength="18" autocomplete ="off" placeholder="XX.XXX.XXX/XXXX-XX" OnKeyPress="MascaraCNPJ(this)" pattern="^(\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2})|(\d{14})$" required title="Campo CNPJ é obrigatório e deve ser digitado no formato (00.000.000/0000-00)"');
echo form_error('cnpj');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Telefone Fixo');
echo"</td><td>"; 
echo form_input(array('name'=>'num_telefone1'),  set_value('num_telefone1'),'maxlength="14" autocomplete ="off" placeholder="(XX)XXXX-XXXX" OnKeyPress="MascaraTelefone(this)" onpaste="return false"');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Telefone Celular');
echo"</td><td>"; 
echo form_input(array('name'=>'num_telefone2'),  set_value('num_telefone2'),'maxlength="15" autocomplete ="off" placeholder="(XX) XXXXX-XXXX" OnKeyPress="MascaraTelefone(this)" onChange="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXXX-XXXX" onpaste="return false"');
echo"</td></tr>";
echo"</tr><td>";
echo"<td>"; 
echo form_submit(array('name'=>'Cadastrar'),'Cadastrar');
echo"</td><tr>"; 
echo"</table>"; 
echo form_close();
echo"</fieldset>";
?>
