     <script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#listarReceitas').dataTable({
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
$receitas = $receitas;

if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

?>

<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="listarReceitas">
        
        <thead>
            <tr>
            <th>Data</th>
            <th>Nome</th>
            <th>Médico</th>
            <th>&nbsp</th>
            </tr>
        </thead>
        <tbody>
<?php



foreach ($receitas as $linha) {
    
    if ($linha->id_dependente == null) {
        $all = $this->receita_model->retornaReceita($linha->id);
        $nome = $all['pessoa']->nome;
    } else {
        $all = $this->receita_model->retornaReceita($linha->id);
        $nome = $all['dependente']->nome;
    }
    
    echo "<tr>
        <td valign='middle'>".$this->util->data_mysql_para_user($linha->data)."</td>
        <td valign='middle'>".$nome."</td>
        <td valign='middle'>$linha->medico</td>
        <td valign='middle'><a onClick=\"window.close();window.open('".base_url('receita/exibeReceita/'.$linha->id)."','','width=900,height=800');\"/><center><img src=".base_url('public/img/pesquisar.png')." width='23' title='Visualizar' style='cursor: hand;'></center></a></td>
        </tr>";
}

echo"</tbody>";
echo"</table>";
echo"</div>";
?>