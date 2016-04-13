<?php
echo"<div class=formulario style='margin-left: 20px; width: 400px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>"; //TITULO

if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}
if ($this->session->flashdata('msgOk')) {
    $msg = $this->session->flashdata('msgOk');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}

$id = $this->uri->segment(3);
$cheque = $this->cheque_model->get_byid($id);
?>
    <fieldset>
        <legend>Dados dos Cheques:</legend>
        
        <form method="POST" action="<?php echo base_url('cheque/atualizarCheque/'.$id); ?>">
            <table>
                <tr>
                    <td>&nbsp;&nbsp;Data</td>
                    <td>&nbsp;&nbsp;Descrição</td>
                    <td>&nbsp;&nbsp;Valor</td>
                </tr><tr>
<?php
        echo '<tr>
            <td><input type="date" name="data" value="'. $cheque->data .'" required title="Campo Data é obrigatório" style="width:150px;"></td>
            <td><input type="text" id="descricao" value="' . $cheque->descricao . '" name="descricao" readonly style="width:250px;" placeholder="Parcela"></td>
            <td><input type="text" id="valor" value="' .$this->util->pontoParaVirgula($cheque->valor) . '" name="valor" style="width:90px;" readonly placeholder="XXX,XX"></td>
            </tr><tr>';
        echo form_hidden('id', $id,'');
?>

            </table>

            <input type=submit value="Alterar">

        </form>
    </fildset>

<?php
echo"</div>";
?>