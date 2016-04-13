<?php
echo"<div class=formulario>";
echo"<h2>$titulo</h2>";

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onLoad=\" alert('$msg');\">";
}

echo form_open('cliente/cadastrarCliente');

//Tratamento do Select de estado
$options = array(
'AC' => 'AC',
'AL' => 'AL',
'AP' => 'AP',
'AM' => 'AM',
'BA' => 'BA',
'CE' => 'CE',
'DF' => 'DF',
'ES' => 'ES',
'GO' => 'GO',
'MA' => 'MA',
'MT' => 'MT',
'MS' => 'MS',
'MG' => 'MG',
'PA' => 'PA',
'PB' => 'PB',
'PR' => 'PR',
'PE' => 'PE',
'PI' => 'PI',
'RJ' => 'RJ',
'RN' => 'RN',
'RS' => 'RS',
'RO' => 'RO',
'RR' => 'RR',
'SC' => 'SC',
'SP' => 'SP',
'SE' => 'SE',
'TO' => 'TO',
    );
if(set_value('estado')==NULL){
    $setValueEstado='SP';
}else{
    $setValueEstado=set_value('estado');
}


    
echo"<fieldset>";
echo"<legend>Dados Pessoais:</legend>";
echo"<table>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Nome <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'nome'),  set_value('nome'),'maxlength="100" autocomplete ="off"  placeholder="Nome Completo do Cliente" autofocus style="width:300px;" required title="Campo nome é obrigatório" onkeypress="return SomenteLetras(event);"');
echo form_error('nome');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Email');
echo"</td><td>";//Essa linha pode remover
echo form_type(array('name'=>'email'),set_value('email'),'maxlength="100" autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;"','email');
echo form_error('email');
echo"<tr><td>";//Essa linha pode remover
echo form_label('CPF <span style="color:gray;" title="Campo obrigatório">*</span>');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cpf'),  set_value('cpf'),'maxlength="14" autocomplete ="off" placeholder="XXXXXXXXXXX" OnKeyPress="MascaraCPF(this)" pattern="^(\d{3}\d{3}\d{3}d{2})|(\d{11})$" required title="Campo CPF é obrigatório e deve ser digitado no formato (00000000000)"');
echo form_error('cpf');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Data de Nascimento');
echo"</td><td>"; //Essa linha pode remover
echo form_type(array('name'=>'data_nascimento'),  set_value('data_nascimento'),'maxlength="10" autocomplete ="off" min="1900-01-01" max="'.date('d-m-Y').'" title="testehduwahduhawd"','date');
echo form_error('data_nascimento');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Residencial');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone1'),  set_value('num_telefone1'),'maxlength="14" autocomplete ="off" placeholder="(XX) XXXX-XXXX" OnKeyPress="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXX-XXXX"');
echo form_label('Telefone Celular');
echo form_input(array('name'=>'num_telefone2'),  set_value('num_telefone2'),'maxlength="15" autocomplete ="off" placeholder="(XX) XXXXX-XXXX" OnKeyPress="MascaraTelefone(this)" onChange="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXXX-XXXX"');
echo"</td></tr>";//Essa linha pode remover
echo"</table>";
echo form_error('num_telefone1');
echo"<br>";
echo form_error('num_telefone2');
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Endereço:</legend>";
echo"<table>";
echo"<tr><td>";//Essa linha pode remover
echo form_label('Logradouro');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'rua'),  set_value('rua'),'maxlength="80" autocomplete ="off" placeholder="Exemplo: Av José Gulin, 9" style="width:425px;"');
echo form_error('rua');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Bairro');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'bairro'),  set_value('bairro'),'maxlength="50" autocomplete ="off" placeholder="Exemplo: Bacacheri"');
echo form_error('bairro');
echo form_label('Complemento');
echo form_input(array('name'=>'complemento'),  set_value('complemento'),'maxlength="20" autocomplete ="off" placeholder="Exemplo: Apt./Cj./Bloco"');
echo form_error('complemento');
echo"</td></tr>";//Essa linha pode remover

echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Cidade');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cidade'),  set_value('cidade'),'maxlength="50" autocomplete ="off" placeholder="Exemplo: Curitiba"');
echo form_error('cidade');
echo form_label('Estado','',array('style' => 'padding-right: 45px;',));
echo form_dropdown('estado', $options, $setValueEstado);

echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('CEP');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cep'),  set_value('cep'),'maxlength="9" autocomplete ="off" placeholder="XXXXX-XXX" OnKeyPress="MascaraCep(this)" pattern="\d{5}-?\d{3}" title="Campo CEP deve ser digitado no formato XXXXX-XXX"');
echo form_error('cep');
echo"</td></tr>";//Essa linha pode remover
echo"</tr><td>"; //Essa linha pode remover
echo"<td>"; //Essa linha pode remover
echo form_submit(array('name'=>'Cadastrar'),'Cadastrar');
echo"</td><tr>"; //Essa linha pode remover
echo"</table>"; //Essa linha pode remover
echo"</fieldset>";

echo form_close();

echo "</div>";

?>