<p align='right'><table border="0"  id="icone_desbotado">
    <tr>    
    <td align="right">
            <?php echo "<a href='#'><img src='".base_url('public/img/impressora.png')."' title='Imprimir' width='50px' class='impressao' onClick='window.print();'></a>"; ?>
             
            </a>
        </td>
        </tr>
        </table></p>

<?php
echo'<body style="background-color:#FFFFFF;">';
echo"<fieldset>";
echo"<div style='background-image: url(".base_url('public/img/logo_receita.png').");background-repeat: no-repeat;background-size: 100px;'>";
echo"<br>";

echo"<font size='5'><center><b>Receita Oftalmológica </b></center></font></h2>";//TITULO
echo"<br>";

$dados_receita = $dados_receita;//Boas praticas, captura o agendamento da controler

echo"<p align='right'>";
echo'<b>Data da Consulta: </b>';
echo $this->util->data_mysql_para_user($dados_receita['receita']->data);
echo" </p>";
echo"</div>";
echo"<fieldset>";
echo"<legend>Dados do Paciente:</legend>";
echo"<table width='100%'>";//Essa linha pode remover

if($dados_receita['receita']->id_dependente==NULL){
//Mostra cabeçalhodo do cliente
echo"<tr><td>";//Essa linha pode remover
echo"<b>Nome:</b>";
echo $dados_receita['pessoa']->nome;
echo"</td>";
echo"<td>";//Essa linha pode remover
echo "<b>CPF: </b>";
echo $dados_receita['cliente']->cpf;
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td><b>Email: </b>";
echo $dados_receita['pessoa']->email."</td>";   
}else{
echo"<tr><td align='left'>";//Essa linha pode remover
echo"<b>Nome do Dependente: &nbsp;</b>";
echo $dados_receita['dependente']->nome;
echo"</td></tr>";

echo"<tr><td>&nbsp;</td></tr>";

echo"<tr><td>";//Essa linha pode remover
echo"<b>Nome do Responsável: </b>";
echo $dados_receita['pessoa']->nome;
echo"</td>";
echo"<td>";//Essa linha pode remover
echo "<b>CPF: </b>";
echo $dados_receita['cliente']->cpf;
echo"</td>";
echo"<td><b>Email: </b>";
echo $dados_receita['pessoa']->email."</td>";     
}


//Inicializa todas as variaveis do diagnostico com vazio
        $longe_od_esferico = '';
        $longe_od_cilindrico = '';
        $longe_od_eixo = '';
        $longe_od_dnp = '';
        $longe_oe_esferico = '';
        $longe_oe_cilindrico = '';
        $longe_oe_eixo = '';
        $longe_oe_dnp = '';
        $perto_od_esferico = '';
        $perto_od_cilindrico = '';
        $perto_od_eixo = '';
        $perto_od_dnp = '';
        $perto_oe_esferico = '';
        $perto_oe_cilindrico = '';
        $perto_oe_eixo = '';
        $perto_oe_dnp = '';
//Trata os dados da Consulta

foreach ($dados_receita['diagnostico'] as $diagnostico){
    
    $diagnostico->esferico = $this->util->pontoParaVirgula($diagnostico->esferico);
    $diagnostico->cilindrico = $this->util->pontoParaVirgula($diagnostico->cilindrico);
    
    
    
    if($diagnostico->distancia == "Longe" && $diagnostico->lado == "OD" ){
        
        $longe_od_esferico = $diagnostico->esferico;
        $longe_od_cilindrico = $diagnostico->cilindrico;
        $longe_od_eixo = $diagnostico->eixo.'º';
        $longe_od_dnp = $diagnostico->dnp.'mm';
    }
        if($diagnostico->distancia == "Longe" && $diagnostico->lado == "OE" ){
        
        $longe_oe_esferico = $diagnostico->esferico;
        $longe_oe_cilindrico = $diagnostico->cilindrico;
        $longe_oe_eixo = $diagnostico->eixo.'º';
        $longe_oe_dnp = $diagnostico->dnp.'mm';
    }    
         if($diagnostico->distancia == "Perto" && $diagnostico->lado == "OD" ){
        
        $perto_od_esferico = $diagnostico->esferico;
        $perto_od_cilindrico = $diagnostico->cilindrico;
        $perto_od_eixo = $diagnostico->eixo.'º';
        $perto_od_dnp = $diagnostico->dnp.'mm';
    }
        if($diagnostico->distancia == "Perto" && $diagnostico->lado == "OE" ){
        
        $perto_oe_esferico = $diagnostico->esferico;
        $perto_oe_cilindrico = $diagnostico->cilindrico;
        $perto_oe_eixo = $diagnostico->eixo.'º';
        $perto_oe_dnp = $diagnostico->dnp.'mm';
    }    
        
}

echo"</td></tr>";//Essa linha pode remover

echo"</table>";
echo"<br>";
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Dados da Consulta:</legend>";
echo"<table border='0' width='100%'>";

echo"<tr  align='center'>";
echo"<td colspan='2'></td>";
echo"<td>Esférica</td>";
echo"<td>Cilíndrico</td>";
echo"<td>Eixo</td>";
echo"<td>DNP</td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td rowspan='2' align='center' valign='middle'>Longe</td>";
echo"<td align='right' style='border-left:1px solid #666666;'>OD</td>";
echo"<td align='center'><input type='text' value='".$longe_od_esferico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_od_cilindrico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_od_eixo."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_od_dnp."' style='width:105px;'  disable ></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td align='right' style='border-left:1px solid #666666;'>OE</td>";
echo"<td align='center'><input type='text' value='".$longe_oe_esferico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_oe_cilindrico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_oe_eixo."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$longe_oe_dnp."' style='width:105px;'  disable ></td>";
echo"</tr>";

echo"<tr>";
echo"<td colspan='6'><font size='1'>&nbsp;</font></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td rowspan='2' align='center' valign='middle'>Perto</td>";
echo"<td align='right' style='border-left:1px solid #666666;'>OD</td>";
echo"<td align='center'><input type='text' value='".$perto_od_esferico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_od_cilindrico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_od_eixo."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_od_dnp."' style='width:105px;'  disable ></td>";
echo"</tr>";

echo"<tr style='border: 1px solid #666666;'>";
echo"<td align='right' style='border-left:1px solid #666666;'>OE</td>";
echo"<td align='center'><input type='text' value='".$perto_oe_esferico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_oe_cilindrico."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_oe_eixo."' style='width:105px;'  disable ></td>";
echo"<td align='center'><input type='text' value='".$perto_oe_dnp."' style='width:105px;'  disable ></td>";
echo"</tr>";


echo"<tr>";

echo"<td align='right' colspan='5'>DP</td>";
echo "<td align='center'>".form_input('',$dados_receita['receita']->dp.'mm','style="width:105px; " disable ')."</td>";
echo"</tr>";
echo"</table>";
echo"</fieldset>";
echo"<fieldset style=' height: 90px;'>";
echo"<legend>Observações:</legend>";
echo $dados_receita['receita']->observacao;
echo"</fieldset>";
echo"<fieldset>";
echo"<legend>Dados do Médico:</legend>";

echo"<br>";
echo"<br>";
echo"<table width='100%'>";
echo"<tr>";
echo"<td>";
echo"<b>Médico(a):</b> ".$dados_receita['receita']->medico;
echo"</td>";
echo"<td align = 'rigth'>";
echo"<b>CRM:</b> ".$dados_receita['receita']->crm;
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td>&nbsp;</td>";
echo"<td>&nbsp;</td>";
echo"</tr>";
echo"<tr>";
echo"<td>&nbsp;</td>";
echo"<td>&nbsp;</td>";
echo"</tr>";
echo"<tr>";
echo"<td>&nbsp;</td>";
echo"<td>&nbsp;</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2' align='center'>______________________________________________<br><b>".
        $dados_receita['receita']->medico."</b></td>";
echo"</tr>";

echo"</table>";
echo"<br>";
echo"<br>";
echo"</fieldset>";
echo"<center><font size='3'>Ótica  - Rua XV, 1 Centro Curitiba - Fone: (41) 3057-0000</font></center>";
echo"</fieldset>";

//Tratamento das mensagem, se for ok, exime a mensagem e fecha o popup
if ($this->session->flashdata('msgOk')) {
    $msg = $this->session->flashdata('msgOk');
    ?>
    

    <script>

        var WinSizeHor = 900;
        var WinSizeVert = 800;
        posHoriz = parseInt((screen.availWidth / 2) - parseInt(WinSizeHor / 2))
        posVert = parseInt((screen.availHeight / 2) - parseInt(WinSizeVert / 2))
        self.moveTo(posHoriz, posVert);
        self.resizeTo(WinSizeHor, WinSizeVert);

        window.opener.location.reload();
        if (confirm('Dados salvos com sucesso \n\nVocê gostaria de imprimir a receita?')) {
        } else {
            window.close();
        }

    </script>
   <?php

}
?>