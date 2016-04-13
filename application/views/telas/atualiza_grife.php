<?php
echo"<div class=formulario style='  margin-left: 40px; width: 300px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";

$id_grife = $this->uri->segment(3);

if($id_grife == NULL){
    redirect ('grife/lista');
}

if($this->session->flashdata('statusUpdate')){
    $msg = $this->session->flashdata('statusUpdate');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

$query = $this->grife_model->get_byid($id_grife);


echo form_open("grife/update/$id_grife");

echo"<fieldset>";
echo"<legend>Grife</legend>";
echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome'),  set_value('descricao',$query['grife']->nome),'maxlength="50" placeholder="Nome da grife" autocomplete ="off" style="width:150px;"');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo"</fieldset>";

echo"</tr><td>"; //Essa linha pode remover
echo"<td>"; //Essa linha pode remover
echo form_submit(array('name'=>'Alterar'),'Alterar');
echo"</td><tr>"; //Essa linha pode remover
echo"</table>"; //Essa linha pode remover


echo form_hidden('id_grife',$id_grife);//Campo oculto que armazena id_cliente
echo form_close();
echo"</div>";
?>
