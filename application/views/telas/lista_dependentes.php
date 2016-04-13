     <script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#listarDependentes').dataTable({
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
$id_cliente = $this->uri->segment(3);
if($this->uri->segment(4)=='visualizar')$manter = TRUE;
$dependentes = $this->dependente_model->listarDependentes($id_cliente);

if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

?>

<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="listarDependentes">
        
        <thead>
            <tr>
        <th>Nome</th>
        <th>Data Nas.</th>
        <th>Responsável</th>
   <?php if(! $manter)echo"<th>&nbsp</th>"; ?>
    <?php if(! $manter)echo"<th>&nbsp</th>"; ?>
        </tr>
        </thead>
        <tbody>
<?php



foreach ($dependentes as $linha) {
    
    
    if(! $manter){
   echo "<tr>
        <td valign='middle'>$linha->nome</td>
        <td valign='middle'>".$this->util->data_mysql_para_user($linha->data_nascimento)."</td>
        <td valign='middle'>$linha->responsavel</td>
        <td valign='middle'><a href=\"javascript:abrirPopUp('".base_url('dependente/atualizarDependente/'.$linha->id_dependente)."','500','300');\"><center><img src=".base_url('public/img/edit.png')." width='23' title='Editar'></center></a></td>
        <td valign='middle'>".anchor('dependente/deletarDependente/'.$id_cliente.'/'.$linha->id_dependente,'<center><img src="'.base_url('public/img/delete.png').'" width="23" title="Excluir" /></center>','onclick="if (! confirm(\'Tem certeza que deseja excluir o dependente abaixo? \n\n Nome: '.$linha->nome.'\n Data de Nascimento: '.$this->util->data_mysql_para_user($linha->data_nascimento).'\n Responsável: '.$linha->responsavel.'\')) { return false; }"')."</td>
            
</tr>";
    }else{
        echo "<tr>
        <td valign='middle'>$linha->nome</td>
        <td valign='middle'>".$this->util->data_mysql_para_user($linha->data_nascimento)."</td>
        <td valign='middle'>$linha->responsavel</td>
            
</tr>";
    }
    
} 
echo"</tbody>";
echo"</table>";
echo"</div>";
?>