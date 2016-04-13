<?php
echo"<div class=formulario style='  margin-left: 40px; float:left; width: 610px;  padding: 2px 2px 0px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>";

$id_cliente = $this->uri->segment(3);

if($id_cliente == NULL){
    
    redirect ('cliente/listarClientes');
    
}

$query = $this->cliente_model->retornaCliente($id_cliente);

if($this->session->flashdata('statusUpdate')){
    $msg = $this->session->flashdata('statusUpdate');
    echo "<body onLoad=\" alert('$msg');\">";
}
if($this->session->flashdata('statusUpdateOK')){
    $msg = $this->session->flashdata('statusUpdateOK');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

echo form_open("cliente/atualizarCliente/$id_cliente");


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
echo form_input(array('name'=>'nome'),  set_value('nome',$query['pessoa']->nome),'maxlength="100" autocomplete ="off" placeholder="Nome Completo do Cliete" required title="Campo nome é obrigatório" style="width:300px;"');
echo form_error('nome');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Email');
echo"</td><td>";//Essa linha pode remover
echo form_type(array('name'=>'email'),set_value('email',$query['pessoa']->email),'maxlength="100" autocomplete ="off" placeholder="exemplo@exemplo.com.br" style="width:300px;"','email');
echo form_error('email');
echo"<tr><td>";//Essa linha pode remover
echo form_label('CPF');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cpf'),  set_value('cpf',$query['cliente']->cpf),'maxlength="11" autocomplete ="off" placeholder="XXXXXXXXXXX" OnKeyPress="MascaraCPF(this)" pattern="^(\d{3}\\d{3}\\d{3}\d{2})|(\d{11})$" readonly ');
echo form_error('cpf');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Data Nascimento');
echo"</td><td>"; //Essa linha pode remover
echo form_type(array('name'=>'data_nascimento'),  set_value('data_nascimento',$query['cliente']->data_nascimento),'maxlength="10" autocomplete ="off" min="1900-01-01" max="'.date('d-m-Y').'"','date');
echo form_error('data_nascimento');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Telefone Residencial');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'num_telefone1'),  set_value('num_telefone1',$query['telefone'][0]->num_telefone),'maxlength="14" autocomplete ="off" placeholder="(XX) XXXX-XXXX" OnKeyPress="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXX-XXXX"');
echo form_label('Telefone Celular');
echo form_input(array('name'=>'num_telefone2'),  set_value('num_telefone2',$query['telefone'][1]->num_telefone),'maxlength="15" autocomplete ="off" placeholder="(XX) XXXX-XXXXX" OnKeyPress="MascaraTelefone(this)" onBlur="MascaraTelefone(this)" pattern="\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}" title="Campo Telefone deve ser digitado no formato (XX) XXXXXX-XXXX"');
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
echo form_input(array('name'=>'rua'),  set_value('rua',$query['endereco']->logradouro),'maxlength="80" autocomplete ="off" placeholder="Exemplo: Av José Gulin, 9" style="width:425px;"');
echo form_error('rua');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Bairro');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'bairro'),  set_value('bairro',$query['endereco']->bairro),'maxlength="50" autocomplete ="off" placeholder="Exemplo: Bacacheri"');
echo form_error('bairro');
echo form_label('Complemento');
echo form_input(array('name'=>'complemento'),  set_value('complemento',$query['endereco']->complemento),'maxlength="20" autocomplete ="off" placeholder="Exemplo: Apt./Cj./Bloco"');
echo form_error('complemento');
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('Cidade');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cidade'),  set_value('cidade',$query['endereco']->cidade),'maxlength="50" autocomplete ="off" placeholder="Exemplo: Curiitba, 2000"');
echo form_error('cidade');
echo form_label('Estado','',array('style' => 'padding-right: 45px;',));
echo form_dropdown('estado', $options, set_value('estado',$query['endereco']->estado));
echo"</td></tr>";//Essa linha pode remover
echo"<tr><td>";//Essa linha pode remover
echo form_label('CEP');
echo"</td><td>"; //Essa linha pode remover
echo form_input(array('name'=>'cep'),  set_value('cep',$query['endereco']->cep),'maxlength="9" autocomplete ="off" placeholder="XXXXX-XXX" OnKeyPress="MascaraCep(this)"  pattern="\d{5}-?\d{3}" title="Campo CEP deve ser digitado no formato XXXXX-XXX"');
echo form_error('Cep');
echo"</td></tr>";//Essa linha pode remover


echo"</tr><td>"; //Essa linha pode remover
echo"<td>"; //Essa linha pode remover
echo form_submit(array('name'=>'Alterar'),'Alterar');
echo"</td><tr>"; //Essa linha pode remover
echo"</table>"; //Essa linha pode remover
echo"</fieldset>";

echo form_hidden('id_pessoa',$query['cliente']->id_pessoa);//Campo oculto que armazena id_pessoa
echo form_hidden('id_cliente',$id_cliente);//Campo oculto que armazena id_cliente
echo form_close();
echo'<a href="'.$this->session->userdata('paginaAnterior').'"><img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar" /></a>';
echo"</div>";
echo "<div style='float:left; margin-left:10px; padding: 90px 0px 0px;'}>";

$dependentes = $this->dependente_model->listarDependentes($id_cliente);

if($dependentes==NULL){
?>
            <table border="0">
                <tr id="icone_desativado">
        <td align="center">
            <?php echo"<img src='".base_url('public/img/dependente.png')."' title='Não possui Dependentes'>" ?>
             <p>Não possui Dependentes</p>
            </a>
        </td>
        </tr>

        
<?php
}else {
    ?>
        <table border="0">
            <tr id="icone_desbotado">
        <td align="center">
            <?php echo"<a href=\"javascript:abrirPopUp('".base_url('dependente/listarDependentes/'.$id_cliente)."','500','350');\" title='Listar Dependentes'><img src='".base_url('public/img/dependente.png')."' title='Listar Dependentes'>"; ?>
             <p>Listar Dependentes</p>
            </a>
        </td>
        </tr>
        </table>
    
<?php 
    
    
}
echo"</div>";
?>
