<?php
echo"<div class=formulario style='  margin-left: 40px; width: 400px; padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";
$id_dependente = $this->uri->segment(3);


if($id_dependente==NULL){
    
    redirect ('cliente/listarClientes');
    
}

$query = $this->dependente_model->retornaDependente($id_dependente);

echo validation_errors('<p>','</p>');

if ($this->session->flashdata('statusUpdate')) {
    $msg = $this->session->flashdata('statusUpdate');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

?>
        <fieldset>
        <legend>Dados do Dependente:</legend>


<?php

echo form_open("dependente/atualizarDependente/$id_dependente");

echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome do Dependente <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome'), set_value('nome',$query->nome),'maxlength="100" autocomplete ="off"  placeholder="Nome do Dependente" autofocus style="width:150px;" required title="Campo nome é obrigatório" onkeypress="return SomenteLetras(event);"');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Data de Nascimento');
echo"</td><td>";//Essa linha pode remover
//echo form_input(array('name'=>'data_nascimento'),set_value('data_nascimento',$this->util->data_mysql_para_user($query->data_nascimento)));
echo form_type(array('name'=>'data_nascimento'), set_value('data_nascimento', $query->data_nascimento),'maxlength="10" autocomplete ="off" min="1900-01-01" max="'.date('d-m-Y').'"','date');
echo"<tr><td>";//Essa linha pode remover
echo form_label('Responsável');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'responsavel'), set_value('responsavel',$query->responsavel),'maxlength="100" autocomplete ="off" autofocus style="width:150px;" placeholder="Grau de Parentesco"');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td valign='middle'>";//Essa linha pode remover
echo'<a href="'.$this->session->userdata('paginaAnterior').'"><img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar" /></a>';
echo"</td><td>";//Essa linha pode remover

echo form_submit(array('name'=>'Alterar'),'Alterar');
echo"</td><tr>"; //Essa linha pode remover
echo"</table>"; //Essa linha pode remover

echo form_hidden('id_dependente',$id_dependente);//Campo oculto que armazena id_Dependente
echo form_close();
echo"</fieldset>";
?>