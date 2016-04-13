<?php

echo"<div class=formulario style='  margin-left: 40px; width: 600px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";//TITULO

$agendamento = $agendamento;//Boas praticas, captura o agendamento da controler

foreach ($agendamento as $agendamento)//Transforma as informações no array mais amigavel

echo form_open('consulta/cadastrarConsulta');

echo"<fieldset>";
echo"<legend>Dados do Cliente:</legend>";
echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome do Cliente');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome_cliente'), $agendamento->nome_cliente,'autocomplete ="off" placeholder="Nome Completo do Cliete" style="width:300px;" readonly');
echo"</td></tr>";//Essa linha pode remover
if($agendamento->nome_dependente != NULL){
    echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome do Dependente');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome_dependente'), $agendamento->nome_dependente,'autocomplete ="off" placeholder="Nome Completo do Cliete" style="width:300px;" readonly');
echo"</td></tr>";//Essa linha pode remover
}
echo"<tr><td>";//Essa linha pode remover
echo form_label('Email');
echo"</td><td>";//Essa linha pode remover
echo form_input(array('name'=>'email'),$agendamento->email,'autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;" readonly');
echo"<tr><td>";//Essa linha pode remover
echo form_label('CPF');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cpf'),$agendamento->cpf,'autocomplete ="off" placeholder="XXX.XXX.XXX-XX" readonly');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Data da Consulta');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'data_consulta'), $this->util->data_mysql_para_user($agendamento->data_consulta),'readonly style="width:100px;"');
echo form_label('Horário da Consulta');
echo form_input(array('name'=>'horario_consulta'),$agendamento->horario_consulta,'readonly style="width:70px;"');
echo"</td></tr>";//Essa linha pode remover
echo"</table>";
echo"<br>";
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Dados da Consulta:</legend>";
echo"<table border='0' width='100%'>";

echo"<tr  align='center'>";
echo"<td colspan='2'></td>";
echo"<td>Esférica</td>";
echo"<td>Cilíndrico</td>";
echo"<td>Eixo</td>";
echo"<td>DNP</td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td rowspan='2' align='center' valign='middle'>Longe</td>";
echo"<td align='right' style='border-left:1px solid #666666;'>OD</td>";
echo"<td align='center'><input type='text' name='longe_od_esferico' style='width:105px;' autocomplete ='off' placeholder='Ex: X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_od_cilindrico' style='width:105px;' autocomplete ='off' placeholder='Ex: -X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_od_eixo' style='width:105px;'autocomplete ='off' placeholder='Eixo em graus' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_od_dnp' style='width:105px;' autocomplete ='off' placeholder='DNP em mm' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td align='right' style='border-left:1px solid #666666;'>OE</td>";
echo"<td align='center'><input type='text' name='longe_oe_esferico' style='width:105px;' autocomplete ='off' placeholder='Ex: -X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_oe_cilindrico' style='width:105px;' autocomplete ='off' placeholder='Ex: X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_oe_eixo' style='width:105px;' autocomplete ='off' placeholder='Eixo em graus' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='longe_oe_dnp' style='width:105px;' autocomplete ='off' placeholder='DNP em mm' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"</tr>";

echo"<tr>";
echo"<td colspan='6'><font size='1'>&nbsp;</font></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td rowspan='2' align='center' valign='middle'>Perto</td>";
echo"<td align='right' style='border-left:1px solid #666666;'>OD</td>";
echo"<td align='center'><input type='text' name='perto_od_esferico' style='width:105px;' autocomplete ='off' placeholder='Ex: X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='perto_od_cilindrico' style='width:105px;' autocomplete ='off' placeholder='Ex: -X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='perto_od_eixo' style='width:105px;' autocomplete ='off' placeholder='Eixo em graus' onkeypress='return SomenteNumeros(event);' maxlength='6' ></td>";
echo"<td align='center'><input type='text' name='perto_od_dnp' style='width:105px;' autocomplete ='off' placeholder='DNP em mm' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td align='right' style='border-left:1px solid #666666;'>OE</td>";
echo"<td align='center'><input type='text' name='perto_oe_esferico' style='width:105px;' autocomplete ='off' placeholder='Ex: -X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='perto_oe_cilindrico' style='width:105px;' autocomplete ='off' placeholder='Ex: X,XX' onkeyup='Mascara_double(this);' onkeypress='Mascara_double(this);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='perto_oe_eixo' style='width:105px;' autocomplete ='off' placeholder='Eixo em graus' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"<td align='center'><input type='text' name='perto_oe_dnp' style='width:105px;' autocomplete ='off' placeholder='DNP em mm' onkeypress='return SomenteNumeros(event);' maxlength='6'></td>";
echo"</tr>";


echo"<tr>";
echo"<td align='left' valign='bottom'>Observações:</td>";
echo"<td align='right' colspan='4'>".form_label('DP')."</td>";
echo "<td align='center'>".form_input(array('name'=>'dp'),'','autocomplete ="off" placeholder="DP em mm" style="width:105px;" onkeypress="return SomenteNumeros(event);" maxlength="6"')."</td>";
echo"</tr>";

echo"<tr>";
echo"<td align='left' colspan='6'><textarea name=obervacoes cols=67 rows=4 autocomplete ='off' placeholder='Digite aqui suas observações'></textarea></td>";
echo"</tr>";

echo"<tr>";
echo"<td align='center' colspan='6'>".form_submit(array('name'=>'Salvar'),'Salvar')."</td>";
echo"</tr>";

echo"</table>"; //Essa linha pode remover
echo"</fieldset>";

$medico = $this->medico_model->retornaMedico('id_usuario ='.$this->session->userdata('id'));

echo form_hidden('id_medico',  $medico[0]->id,'');
echo form_hidden('id_agendamento',  $agendamento->id_agendamento,'');
echo form_hidden('crm',  $medico[0]->crm,'');
echo form_hidden('medico',  $medico[0]->nome,'');
echo form_hidden('id_cliente',  $agendamento->id_cliente,'');
echo form_hidden('id_dependente',  $agendamento->id_dependente,'');

echo form_close();



echo "</div>";


//Exime mensagem de dados da consulta 
if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

            
            


