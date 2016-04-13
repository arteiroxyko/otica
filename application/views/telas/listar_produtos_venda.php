<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>

<script language="Javascript" type="text/javascript">

    function putData(campoPai, valor, close) {
        var codigo = valor;
        window.opener.document.getElementById(campoPai).value = codigo;

        if (close === true) {
            window.close();
        }
    }
</script>




<?php
$produtos = $this->produto_model->getAll()->result();
?>

<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Cod.</th>
                <th>Cod. Barras</th>
                <th>Nome</th>
                <th>Qtd.</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>

<?php
foreach ($produtos as $linha) {


    if ($linha->status == '1') {

        echo "<tr class='alt' OnClick=\"
       putData('codigoBarras','".$linha->cod_barra."');
       putData('codigoProduto','".$linha->id_produto."');
       putData('nomeProduto','".$linha->nome."');   
       putData('quantidadeProduto','1');
       putData('idProduto','".$linha->id_produto."');   
       putData('precoVenda','".$this->util->pontoParaVirgula($linha->preco_venda)."',true);

\">";


        echo "<td>" . $linha->id_produto . "</td>";
        echo "<td>" . $linha->cod_barra . "</td>";
        echo "<td>" . $linha->nome . "</td>";
        echo "<td><center>" . $linha->quantidade . "</center></td>";
        echo "<td>R$ " . $this->util->pontoParaVirgula($linha->preco_venda) . "</td>";
        echo"</tr>";
    }
}
?>
        </tbody>
    </table>
</div>
