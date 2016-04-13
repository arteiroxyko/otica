<?php
echo"<div class=formulario style='margin-left: 40px; width: 400px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>"; //TITULO
//Exime mensagem de agendamento do cliente Javascript
if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}
if ($this->session->flashdata('msgOk')) {
    $msg = $this->session->flashdata('msgOk');
    echo "<body onLoad=\" alert('$msg');window.opener.location.reload();window.close();\">";
}
?>
<fieldset>
    <legend>Dados da Lente:</legend>

    <form method="POST" action=<?php echo base_url('venda/adicionaLente') ?>/>
    <table>
        <tr>
            <td>Ref. <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="text" style="width:210px;" name="referencia" value="<?php echo set_value('referencia'); ?>" placeholder='Referência da Lente.' autocomplete="off" autofocus required title="Campo referencia custo é obrigatório" /></td></tr><tr>
            <td>Nome <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="text" style="width:210px;" name="nome_lente" value="<?php echo set_value('nome_lente'); ?>" placeholder='Nome da Lente.' autocomplete="off" required title="Campo nome é obrigatório" /></td></tr><tr>
            <td>Preço Venda <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="text" style="width:210px;" name="preco_venda" value="<?php echo set_value('preco_venda'); ?>" placeholder="XXX,XX" autocomplete="off"   required title="Campo preço custo é obrigatório" onkeypress="return(FormataReais(this,'.',',',event));" /></td></tr><tr>
            <td></td><td><input type="submit" value="Cadastrar"></td></tr>

    </table>
</form>
</fildset>

<?php
echo"</div>";
?>