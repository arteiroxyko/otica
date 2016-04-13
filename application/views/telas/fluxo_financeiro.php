<?php
echo"<div class=formulario style='margin-left: 40px; width: 460px;  padding: 2px 2px 2px;  border-radius: 3px;'>";
echo"<h2>$titulo</h2>"; //TITULO



if(url!="")echo $url;


?>
<fieldset>
    <legend>Filtros:</legend>
    <form method="POST" action=<?php echo base_url('fluxoFinanceiro/relatorioPopUp') ?>/>
        <fieldset>
            <legend>Período:</legend>
            <table>
                <tr>
                    <td>De&nbsp;</td><td><input type="date" style="width:155px;" name="dataInicial" autocomplete="off" required /><span>&nbsp;&nbsp;</span></td>
                    <td>Até&nbsp;</td><td><input type="date" style="width:155px;" name="dataFinal" autocomplete="off" required  /></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Exibir:</legend>
                <table><tr>
                    <td>Contas a Pagar&nbsp;&nbsp;<input name="contas_pagar" type="checkbox" id = "ativo" checked/></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>Vendas&nbsp;&nbsp;<input name="vendas" type="checkbox" id = "ativo" checked/></td>
                </tr></table>
        </fieldset>
    <table>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
        <input type="submit" value="Gerar Relatório">
    </form>
</fieldset>
<?php
echo"</div>";
?>
