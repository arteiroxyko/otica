<!--Manuela-->
<?php
echo"<div class=formulario style='margin-left: 40px; width: 400px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>"; //TITULO

if ($this->session->flashdata('msgOk')) {
    $msg = $this->session->flashdata('msgOk');
    echo "<body onLoad=\"alert('$msg');\">";
}

?>
<fieldset>
    <legend>Conta a pagar:</legend>
    <form method="POST" action=<?php echo base_url('contasAPagar/adiciona') ?>/>
    <table>
        <tr>
            <td>Nome <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="text" style="width:290px;" name="nome" value="<?php echo set_value('nome'); ?>"maxlength="50" placeholder='Nome do título' autocomplete="off" autofocus required title="Campo nome é obrigatório" autofocus/></td></tr><tr>
            <td>Valor <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="text" style="width:210px;" name="preco" value="<?php echo set_value('preco'); ?>" autocomplete="off" placeholder='XXX,XX' required title="Campo preço é obrigatório" onkeypress="return(FormataReais(this,'.',',',event));" /></td></tr><tr>
            <td>Vencimento <span style="color:gray;" title="Campo obrigatório">*</span></td><td><input type="date" style="width:155px;" name="data" value="<?php echo set_value('data'); ?>" required title="Campo Vencimento é obrigatório" autocomplete="off" /></td></tr><tr>
            <td>Descrição:</td></tr><tr><td colspan="2"><textarea name="descricao" cols=46 rows=7 placeholder='Digite aqui a descrição.' title="Campo descrição é opcional"><?php echo set_value('descricao'); ?></textarea></td></tr><tr>
            <td align='center' colspan="2"><input type="submit" value="Cadastrar"></td></tr>
    </table>
    </form>
</fildset>

<?php
echo"</div>";
?>