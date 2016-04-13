<!--Manuela-->
<?php
echo "<h2>$titulo</h2>";

if($this->session->flashdata('msg')){
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\"alert('$msg');\">";
}

$contas = $contas;//Pega a variavel da Controller (boa pratica)
// A MAIOR GAMBIARRA DA MINHA VIDA! POR FALTA DE TEMPO O AMIGÃO NÃO DEIXOU EU ALTERAR NA TABELA E SETAR OS TAMANHOS,
// O QUE EU FIZ: ESSA GAMBI RIDICULA, dei uns &nbsp; PRA AJUSTAR AO TAMANHO e.e kkkkkk
$espaco = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
$this->table->set_heading('VENCIMENTO',$espaco.'NOME DO TÍTULO'.$espaco, '&nbsp; &nbsp; VALOR &nbsp; &nbsp; ',$espaco.$espaco.'DESCRIÇÃO'.$espaco.$espaco,'&nbsp; ','&nbsp; ','&nbsp; &nbsp; &nbsp; ');

foreach ($contas as $linha) {
    
    $data = $this->util->data_mysql_para_user($linha->data);
    if ($linha->data < date('d-m-Y')) {
        $data = "<span title='Título vencido' style='color:red;'>".$data."</span>";
    } else if($linha->data == date('d-m-Y')) {
        $data = "<span title='Vence hoje'><b>".$data."</b></span>";
    }
    
    $this->table->add_row('<center>'.$data, $linha->nome, '<p>'."R$ ".$this->util->pontoParaVirgula($linha->valor),$linha->descricao, anchor("contasAPagar/visualiza/$linha->id", '<center><img src="http://localhost/otica/public/img/search.png" width="23"/></center>'),"<a href=\"javascript:abrirPopUp('" . base_url('contasAPagar/update/' . $linha->id) . "','500','450');\"> <center><img src='http://localhost/otica/public/img/edit.png' width='23'/></center></a>", '<center><p onClick="if (! confirm(\'Tem certeza que deseja excluir a conta a pagar abaixo? \n\nNome: '.$linha->nome.'\nValor: '.$linha->valor.'\nData do pagamento: '.$this->util->data_mysql_para_user($linha->data).'\')) { return false; }">' . anchor('contasAPagar/delete/'.$linha->id, '<img src="http://localhost/otica/public/img/delete.png" width="23"/>') . '</p></center>');
}

$tmpl = array(
            'table_open' => '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">',
        );

//$tmpl = array(
//    'table_open'=>'<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">',
//    'cell_start' => '<td valign="middle">',
//    'cell_end' => '</td>',
//    'cell_alt_start' => '<td valign="middle">',
//    'cell_alt_end' => '</td>',
//);

echo"<div class='tabela'>";
$this->table->set_template($tmpl);
echo $this->table->generate();
echo"</div>";

?>