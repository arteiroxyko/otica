<?php

echo"<div class=formulario style='  margin-left: 40px; width: 700px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";

$id_pessoa = $this->uri->segment(3);
$id_fornecedor = $this->uri->segment(4);

if($id_pessoa == NULL || $id_fornecedor == NULL){
    redirect ('fornecedor/lista');
}

$query = $this->fornecedor_model->get_byid($id_pessoa,$id_fornecedor);

echo form_open("Fornecedor/update/$id_pessoa/$id_fornecedor");

echo"<fieldset>";
echo"<legend>Dados Básicos:</legend>";
echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome'),  set_value('nome',$query['pessoa']->nome),'autocomplete ="off" placeholder="Nome Completo do Fornecedor" style="width:300px;" readonly');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Email');
echo"</td><td>";//Essa linha pode remover
echo form_input(array('name'=>'email'),set_value('email',$query['pessoa']->email),'autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;" readonly','email');
echo form_error('email');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Cnpj');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cnpj'),  set_value('cnpj',$query['fornecedor']->cnpj),'autocomplete ="off" placeholder="XX.XXX.XXX/XXXX-XX" readonly');
echo form_error('cnpj');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Fixo');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone1'),  set_value('num_telefone1',$query['telefone'][0]->num_telefone),'autocomplete ="off" placeholder="(XX)XXXX-XXXX" readonly');
echo"</tr></td>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Celular');
echo"</td><td>"; //Essa linha pode remover<td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone2'),  set_value('num_telefone2',$query['telefone'][1]->num_telefone),'autocomplete ="off" placeholder="(XX) XXXXX-XXXX" readonly');
echo"</td></tr>";//Essa linha pode remover
echo"</table>"; //Essa linha pode remover
echo "</fieldset>";
//echo anchor("fornecedor/lista/", '<img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar"/>');
echo'<a href="'.$this->session->userdata('paginaAnterior').'"><img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar" /></a>';
echo "</div>";

echo form_hidden('id_pessoa',$id_pessoa);//Campo oculto que armazena id_pessoa
echo form_hidden('id_fornecedor',$id_fornecedor);//Campo oculto que armazena id_cliente

echo form_close();
?>