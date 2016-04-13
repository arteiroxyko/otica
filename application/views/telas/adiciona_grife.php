<?php
echo"<div class=formulario style='  margin-left: 40px; width: 300px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";

echo validation_errors('<p>','</p>');

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onload=\"alert('$msg');\">";
}

echo form_open('grife/adiciona');

echo"<fieldset>";
echo"<legend>Grife</legend>";
echo"<table>";
echo"<tr><td>";
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>";
echo form_input(array('name'=>'nome'),  set_value('nome'),'maxlength="50" placeholder="Nome da grife" autocomplete ="off" style="width:150px;"');
echo"</td></tr>";
echo"<tr><td>";
echo"</fieldset>";

echo"<td>"; 
echo form_submit('', 'Cadastrar');
echo"</td><tr>"; 
echo"</table>"; 

echo form_close();

?>
