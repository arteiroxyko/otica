<?php
//Exime mensagem de agendamento do cliente Javascript
if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

$ano = $this->uri->segment(3); //Captura o ano da URL
$mes = $this->uri->segment(4); //Captura o mês da URL
$dia = $this->uri->segment(5); //Captura o dia da URL

if ($ano == null) {
    $anoCalendario = date('Y'); //Captura o ano do sistema
} else {
    $anoCalendario = $ano; //Captura o ano da URL
}

if ($mes == null) {
    $mesCalendario = date('m'); //Captura o mes do sistema
} else {
    $mesCalendario = $mes; //Captura o mes da URL
}
if ($dia == NULL) {
    $dia = date('d');
}
$dados = array();
for ($i = 1; $i < 32; $i++) {

    $diaSemana = date("w", mktime(0, 0, 0, $mesCalendario, $i, $anoCalendario)); //Captura o dia da semana (ex: 0 Domingo, 1 Segunda 2 terça ...
    if ($diaSemana != 0 && $diaSemana != 6) {//Não irá fazer link em sábados e Domingos
        if ($i > 9) {//Esse if serve para acrescentar zeros nos números de 1 a 9 ex: 01,02,03,04
            $dados[$i] = base_url('agendamento/horarioConsulta/' . $anoCalendario . '/' . $mesCalendario . '/' . $i);
        } else {
            $dados[$i] = base_url('agendamento/horarioConsulta/' . $anoCalendario . '/' . $mesCalendario . '/0' . $i);
        }
    }
}
//Gera o calendario enviando o ano e o mes atual, se ambos forem null é gerado referente ao ano e mês atual
echo "<div style=float:left;>";
echo"<h2>$titulo</h2>"; //TITULO
echo $this->calendar->generate($anoCalendario, $mesCalendario, $dados);
echo "</div>";
$diaCalendario = $this->uri->segment(5); //Captura o dia do mes que o usuario escolheu no calendario

echo "<div style='float:left; margin-left:0px; padding: 70px 20px 0px;'}>";

$diaSemana_url = date("w", mktime(0, 0, 0, $mesCalendario, $dia, $anoCalendario)); //Captura o dia da semana que vem na URL (ex: 0 Domingo, 1 Segunda 2 terça ...
//Verifica se a data escolhida é menor que a data atual se for não deixa adicionar cliente
if ($anoCalendario . $mesCalendario . $diaCalendario >= date('Y') . date('m') . date('d') && $diaSemana_url != "0" && $diaSemana_url != "6") {
    
}//Acaba o if de verificação se a data é inferior a data atual

$clientes = $this->cliente_model->listarClientes('')->result();
?>

<div class='tabela'>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>NOME</th><th>CPF</th></tr>
        </thead>
        <tbody>

            <?php
            foreach ($clientes as $linha) {

                $nomeReduzido = (explode(" ", $linha->nome));

                if (sizeof($nomeReduzido) > 3) {
                    $nomeReduzido = $nomeReduzido[0] . ' ' . $nomeReduzido[1] . ' ' . $nomeReduzido[sizeof($nomeReduzido) - 1];
                } else {
                    $nomeReduzido = $linha->nome;
                }

                echo "<tr class='alt' OnClick=\"abrirPopUp('" . base_url('agendamento/agendamentoDeCliente/' . $ano . '/' . $mes . '/' . $dia . '/' . $linha->id_cliente) . "','500','400');\">";
                echo "<td>" . $nomeReduzido . "</td>";
                echo "<td>" . $linha->cpf . "</td>";
                echo"</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
echo"</div>";

$horarioAgendamento = $horarioAgendamento; //Boa pratica esse dado vem da controller

if ($horarioAgendamento == null) {
    $this->table->set_heading('Data', 'Horário', 'Nome', 'CPF', 'E-mail', 'Cliente');

    $tmpl = array('table_open' => '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">');
    $this->table->set_template($tmpl);
} else {
    if ($anoCalendario . $mesCalendario . $diaCalendario >= date('Y') . date('m') . date('d')) {
        $this->table->set_heading('Data', 'Horário', 'Nome', 'CPF', 'E-mail', 'Cliente', 'Excluir');
    } else {
        $this->table->set_heading('Data', 'Horário', 'Nome', 'CPF', 'E-mail', 'Cliente');
    }
    foreach ($horarioAgendamento as $linha) {


        if ($linha->id_dependente == NULL) {
            $nome = $linha->nome_cliente;
            $strDependente = "<center><img src=" . base_url('/public/img/cliente.png') . " width='23' title='Cliente'></center>";
        } else {
            $nome = $linha->nome_dependente;
            $strDependente = "<center><img src=" . base_url('/public/img/dependente.png') . " width='23' title='Dependente'></center>";
        }

        if ($anoCalendario . $mesCalendario . $diaCalendario >= date('Y') . date('m') . date('d')) {
            $this->table->add_row($this->util->data_mysql_para_user($linha->data_consulta), $linha->horario_consulta, anchor('cliente/listaCliente/' . $linha->id_cliente, $nome), $linha->cpf, $linha->email, $strDependente, anchor('agendamento/deletarAgendamento/' . $anoCalendario . '/' . $mesCalendario . '/' . $diaCalendario . '/' . $linha->id_agendamento, '<center><img src=' . base_url('public/img/delete.png') . ' width="20" title="Excluir"></center>', 'onclick="if (! confirm(\'Tem certeza que deseja excluir o agendamento abaixo? \n\n Nome: ' . $nome . '\n Data do agendamento: ' . $this->util->data_mysql_para_user($linha->data_consulta) . '\n Horário: ' . $linha->horario_consulta . '\')) { return false; }"'));
        } else {
            $this->table->add_row($this->util->data_mysql_para_user($linha->data_consulta), $linha->horario_consulta, $nome, $linha->cpf, $linha->email, $strDependente);
        }
    }
    $tmpl = array(
        'table_open' => '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">',
        'cell_start' => '<td valign="middle">',
        'cell_end' => '</td">',
        'cell_alt_start' => '<td valign="middle">',
        'cell_alt_end' => '</td>',
    );
    $this->table->set_template($tmpl);
}
echo"<div class='tabela'>";
echo $this->table->generate();
echo"</div>";
?>