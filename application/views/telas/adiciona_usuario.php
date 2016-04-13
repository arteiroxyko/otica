<?php
echo"<div class=formulario style='  margin-left: 20px; width: 676px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onload=\"ocultaCampo('crm','id_crm'); alert('$msg');\">";
}

echo '<body onload="ocultaCampo(\'crm\',\'id_crm\');" />';

echo form_open('usuario/adiciona');

$nivel = $this->nivel_model->getAll()->result();

echo"<fieldset>";
echo"<legend>Dados do Usuário</legend>";
echo"<table>";
echo"<tr><td>";
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'nome'),  set_value('nome'), 'maxlength="100" placeholder="Nome do Usuário" autocomplete ="off" style="width:180px;" autofocus required title="Campo Nome é obrigatório"')."<span>&nbsp;&nbsp;</span>";
echo"</td><td>";
echo form_label('Email');
echo"</td><td>"; 
echo form_type(array('name'=>'email'),  set_value('email'), 'maxlength="100" placeholder="exemplo@email.com" autocomplete ="off" style="width:255px;"', 'email');
echo"</td></tr>";
echo"<tr><td>";
echo form_label('Login <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'login'),  set_value('login'),'maxlength="20" placeholder="Login"  autocomplete ="off" style="width:180px;" required title="Campo Login é obrigatório"');
echo"</td><td>";
echo form_label('Nivel <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>";
echo'<select name="id_nivel" onChange="if (id_nivel.value == 4) { mostraCampo(\'crm\', \'id_crm\'); } else { ocultaCampo(\'crm\',\'id_crm\'); }">';
echo'<option value="0">Selecione...</option>';
if ($nivel != NULL) {
    foreach ($nivel as $linha) {
        echo'<option value="'.$linha -> id.'">'.$linha -> nome.'</option>';
   }
}
echo'</select>';
echo"</td></tr>";
echo"<tr id=\"crm\"><td>";
echo'<div>';
    echo form_label('CRM <span style="color:gray;" title="Campo obrigatório">*</span>');
    echo"</td><td>";
    echo form_input(array('name'=>'crm'),  set_value('crm'), 'id="id_crm" maxlength="20" placeholder="crm do médico" autocomplete ="off" style="width:180px;" required title="Campo CRM é obrigatório"');
    echo"</td></tr>";
echo "</div>";
echo"<tr><td>";
echo form_label('Senha <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_password(array('name'=>'senha'),  set_value('senha'), 'maxlength="20" placeholder="Senha" autocomplete ="off" style="width:180px;" required title="Campo Senha é obrigatório"');
echo"</td><td>";
echo form_label('Confirme a Senha <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_password(array('name'=>'senha_confirma'), set_value('senha_confirma'), 'maxlength="20" placeholder="Confirme a Senha" autocomplete ="off" style="width:180px;" required title="Confirme sua senha"');
echo"</td></tr>";
echo"</table><table>";
echo"<tr><td>";
echo form_label('Lembrete da senha <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; 
echo form_input(array('name'=>'lembrete_senha'),  set_value('lembrete_senha'), 'maxlength="200" placeholder="Use uma palavra chave para lembrar sua senha" autocomplete ="off" style="width:405px;" required title="Campo Lembrete de senha é obrigatório"');
echo"</td></tr>";
echo"<tr><td>"; 
echo form_submit('', 'Cadastrar','onClick="if (senha.value != senha_confirma.value) { alert(\'As senhas informadas não conferem!\'); return false;}"');
echo"</tr></td>"; 
echo"</table>"; 
echo"</fieldset>";
echo"<p><font color=red>".form_error('login')."</font></p>";
echo form_close();
echo"</div>";
?>