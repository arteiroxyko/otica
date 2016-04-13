<?php

echo"<h2>$titulo</h2>";

echo validation_errors('<p>','</p>');

if($this->session->flashdata('cadastrook')){
    $msg = $this->session->flashdata('cadastrook');
    echo "<body onLoad=\" alert('$msg');\">";
}

$clientes = $this->cliente_model->listarClientes('')->result();

echo"<div class='tabela'>";
echo'<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
echo"<thead>";
echo"<tr>";
echo"<th>NOME</th><th>CPF</th><th>EMAIL</th><th>TELEFONE</th></tr>";
echo"</thead>";
echo"<tbody>";
foreach ($clientes as $linha) {

    $nomeReduzido = (explode(" ",$linha->nome));
          
   if(sizeof($nomeReduzido)>3){
       $nomeReduzido = $nomeReduzido[0].' '.$nomeReduzido[1].' '.$nomeReduzido[sizeof($nomeReduzido)-1];
   }else{
       $nomeReduzido = $linha->nome;
   }

    echo "<tr class='alt' OnClick=\"abrirPopUp('".base_url('dependente/cadastrarDependente/'.$linha->id_cliente)."','500','400');\">";
   echo "<td>".$nomeReduzido."</td>";
   echo "<td>".$linha->cpf."</td>";
   echo "<td>".$linha->email."</td>";
   echo "<td>".$linha->num_telefone."</td>";
   echo"</tr>";
   
}
echo"</tbody>";
echo"</table>";
echo"</div>";
?>

    