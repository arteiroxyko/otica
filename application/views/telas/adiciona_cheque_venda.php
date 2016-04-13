<?php 
?>
<script language=JavaScript>
    function parcelas(parcelas) {

        var total = parseFloat(opener.document.getElementById('total').value.replace(",", "."));
        var valor_parcela = total / parseInt(parcelas.value);
        document.getElementById('parcelas').value = parcelas.value;
        for (var i = 1; i <= parcelas.value; i++) {
            var tr_block = document.getElementById('tr_' + i);
            var valor = document.getElementById('valor_' + i);
            document.getElementById('data_' + i).setAttribute("required", "true");
            document.getElementById('descricao_' + i).setAttribute("required", "true");
            document.getElementById('valor_' + i).setAttribute("required", "true");

            tr_block.style.display = "";

            valor.value = number_format(valor_parcela, '2', ',', '');

        }

        for (var i = 3; i > parcelas.value; i--) {
            var tr = document.getElementById('tr_' + i);
            tr.style.display = "none";
            document.getElementById('data_' + i).removeAttribute("required", "true");
            document.getElementById('descricao_' + i).removeAttribute("required", "true");
            document.getElementById('valor_' + i).removeAttribute("required", "true");

        }
    }


    function dataPagamento(element) {

        var date = new Date(element.value.replace('-', ','));
        for (var i = 1; i <= 10; i++) {

            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString();
            var dd = date.getDate().toString();
            if (mm < 10)
                mm = '0' + mm;
            if (dd < 10)
                dd = '0' + dd;

            var data_input = document.getElementById('data_' + i);
            data_input.value = yyyy + '-' + mm + '-' + dd;

            date.setMonth(date.getMonth() + 1);

        }

    }


</script>
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
if ($this->session->userdata('parcelas') != null) {
    ?>

<body onLoad="
            document.getElementById('data_1').setAttribute('required', 'true');
            document.getElementById('descricao_1').setAttribute('required', 'true');
            document.getElementById('valor_1').setAttribute('required', 'true');">
<?php
          } else {
?>
			<body "
            onload="document.getElementById('valor_1').value = opener.document.getElementById('total').value;
            document.getElementById('data_1').setAttribute('required', 'true');
            document.getElementById('descricao_1').setAttribute('required', 'true');
            document.getElementById('valor_1').setAttribute('required', 'true');">
<?php }
          ?>
<fieldset>
<legend>Dados dos Cheques:</legend>
<div style ="float: left; " align="left"> Número de Parcelas
  <select name="selectParcelas" onChange="parcelas(this);">
    <?php
                for ($i = 1; $i < 4; $i++) {
                    if ($i == $this->session->userdata('parcelas')) {
                        echo "<option value='$i' selected>$i</option>";
                    } else {
                        echo "<option value='$i'>$i</option>";
                    }
                }
                ?>
  </select>
</div>
<div align="right">Data da Primeira Parcela
  <input type="date"  min="<?php echo date('d-m-Y') ?>" name="data_0" style="width:150px;" onChange="dataPagamento(this);">
</div>
<br>
<form method="POST" action="<?php echo base_url('venda/adicionarCheques'); ?>">
  <?php
            if ($this->session->userdata('parcelas') != null) {
                echo'<input type="hidden" name="parcelas" id="parcelas" value="'.$this->session->userdata('parcelas').'">';
            }else{
                echo'<input type="hidden" name="parcelas" id="parcelas" value="1">';
            }
            ?>
  <table>
    <tr>
      <td>&nbsp;&nbsp;Data</td>
      <td>&nbsp;&nbsp;Descrição</td>
      <td>&nbsp;&nbsp;Valor</td>
    </tr>
    <tr>
      <?php
if ($this->session->userdata('parcelas') != null) {
    $cheques = $this->session->userdata('cheques');
    for ($i = 1; $i < 4; $i++) {
        if ($i != '1')
            if ($i > $this->session->userdata('parcelas'))$display = 'none';
            if ($i <= $this->session->userdata('parcelas')){$required = 'required';}else{$required = '';}
        echo '<tr id="tr_' . $i . '" style=display:' . $display . '>
            <td><input type="date" min="' . date('d-m-Y') . '" id="data_' . $i . '" '.$required.' value="' . $cheques[$i - 1][data] . '" name="data_' . $i . '" style="width:150px;"></td>
            <td><input type="text" id="descricao_' . $i . '" '.$required.' value="' . $cheques[$i - 1][descricao] . '" name="descricao_' . $i . '" style="width:250px;" placeholder="' . $i . 'º Parcela"></td>
            <td><input type="text" id="valor_' . $i . '" '.$required.' value="' .$this->util->pontoParaVirgula($cheques[$i - 1][valor]) . '" name="valor_' . $i . '" style="width:90px;" onkeypress="return(FormataReais(this,\'.\',\',\',event));" placeholder="XXX,XX"></td>
            </tr><tr>';
    }
}else {
    for ($i = 1; $i < 4; $i++) {
        if ($i != '1')
            $display = 'none';
        echo '<tr id="tr_' . $i . '" style=display:' . $display . '>
            <td><input type="date" min="' . date('d-m-Y') . '" id="data_' . $i . '" name="data_' . $i . '" style="width:150px;"></td>
            <td><input type="text" id="descricao_' . $i . '" value="' . $i . 'º Parcela" name="descricao_' . $i . '" style="width:250px;" placeholder="' . $i . 'º Parcela"></td>
            <td><input type="text" id="valor_' . $i . '" name="valor_' . $i . '" style="width:90px;" onkeypress="return(FormataReais(this,\'.\',\',\',event));" placeholder="XXX,XX"></td>
            </tr><tr>';
    }
}
?>
  </table>
  <input type=submit value="Enviar">
</form>
</fildset>
<?php
echo"</div>";
?>
