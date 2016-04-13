<!--Manuela-->
<?php
echo"<div class=formulario style='margin-left: 40px; width: 400px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>"; //TITULO

$query = $this->contas_a_pagar_model->get_byid($this->uri->segment(3));
$valor = $this->util->pontoParaVirgula($query->valor);

?>
<fieldset>
    <legend>Conta a pagar:</legend>
    <form method="POST" action=<?php echo base_url('contasAPagar/visualiza') ?>/>
    <table>
        <tr>
            <td>Nome</td><td><input type="text" style="width:310px;" name="nome" value="<?php echo set_value('nome',$query->nome); ?>"placeholder='Nome da Conta' autocomplete="off" readonly/></td></tr><tr>
            <td>Valor</td><td><input type="text" style="width:210px;" name="preco" value="<?php echo set_value('preco',$valor); ?>"placeholder='XXX,XX' readonly/></td></tr><tr>
            <td>Vencimento</td><td><input type="date" style="width:155px;" name="data" value="<?php echo set_value('data',$query->data); ?>" readonly/></td></tr><tr>
            <td>Descrição</td></tr><tr><td colspan="2"><textarea name="descricao" value="<?php echo set_value('descricao',$query->descricao); ?>" readonly cols=46 rows=7 placeholder='Digite aqui a descrição.' title="Descrição da conta"><?php echo set_value('descricao',$query->descricao); ?></textarea></td></tr>
    </table>
    </form>
</fildset>

<?php
echo'<a href="'.$this->session->userdata('paginaAnterior').'"><img src="'.base_url('public/img/voltar.png').'" width="25" id="icone_desbotado" title="Voltar" /></a>';
echo"</div>";
?>