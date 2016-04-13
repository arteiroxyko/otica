       <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#listarVendasCliente').dataTable({
            "bPaginate": false,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": false,
            "bProcessing" : true,
            "bLengthChange": false,
            "bFilter": true,

        });
    });
</script>

<?php 
$vendas = $vendas;

if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

?>

<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="listarVendasCliente">
        
        <thead>
            <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Forma Pgto</th>
            <th>Valor Total</th>
            <th>Vendedor</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
<?php 



foreach ($vendas as $linha) {
    
    echo "<tr>
        <td valign='middle'>".$this->util->data_mysql_para_user($linha->data_venda)."</td>
        <td valign='middle'>".$linha->horario_venda."</td>
        <td valign='middle'>$linha->forma_pagamento</td>
        <td valign='middle'>R$ ".  number_format((($linha->preco_total_itens+$linha->preco_total_lentes+$linha->preco_total_servicos)-$linha->desconto),'2',',','')."</td>
        <td valign='middle'>".$linha->vendedor."</td>
        <td valign='middle'><a onClick=\"window.open('".base_url('venda/exibeVenda/'.$linha->id_venda)."','','width=900,height=800');\"/><center><img src=".base_url('public/img/pesquisar.png')." width='23' title='Visualizar Recibo' style='cursor: hand;'></center></a></td>
        </tr>";
}

echo"</tbody>";
echo"</table>";
echo"</div>";
?>