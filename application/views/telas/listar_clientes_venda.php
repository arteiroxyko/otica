       <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>

        <script language="Javascript" type="text/javascript"> 

function putData(nomeCliente,idCliente,cpfCliente,url) {  
        
     window.opener.location.href = url+'?idCliente='+idCliente+'&nomeCliente='+nomeCliente+'&cpfCliente='+cpfCliente;
       window.close();   
     
      window.opener.document.getElementById('codigoBarras').focus();
}  
</script>
               
        
        

<?php

    $clientes = $this->cliente_model->listarClientes('')->result();

?>
        
<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
<tr>
<th>NOME</th><th>CPF</th></tr>
</thead>
<tbody>
        
        <?php
        if($this->session->userdata('lente')==NULL){
   echo "<tr class='alt' OnClick=\"putData('Cliente não definido','0','000.000.000-00','".base_url('venda/cadastrarVenda/')."');\">";
   echo "<td>Cliente não definido</td>";
   echo "<td>000.000.000-00</td>";
   echo"</tr>";
        }
foreach ($clientes as $linha) {

    $nomeReduzido = (explode(" ",$linha->nome));
          
   if(sizeof($nomeReduzido)>3){
       $nomeReduzido = $nomeReduzido[0].' '.$nomeReduzido[1].' '.$nomeReduzido[sizeof($nomeReduzido)-1];
   }else{
       $nomeReduzido = $linha->nome;
   }
   
   echo "<tr class='alt' OnClick=\"putData('".$linha->nome."','".$linha->id_cliente."','".$linha->cpf."','".base_url('venda/cadastrarVenda/')."');\">";
   echo "<td>".$nomeReduzido."</td>";
   echo "<td>".$linha->cpf."</td>";
   echo"</tr>";
   
}
?>
</tbody>
    </table>
</div>
