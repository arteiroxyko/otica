<?php

echo"<h2>$titulo</h2>";

if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');location.reload();\">";
}


$clientes = $clientes; //Pega a variavel da Controller (boa pratica)



$this->table->set_heading('NOME', 'CPF', 'EMAIL', 'TELEFONE', '&nbsp; ', '&nbsp; ', '&nbsp; ');
foreach ($clientes as $linha) {

    $nomeReduzido = (explode(" ", $linha->nome));

    if (sizeof($nomeReduzido) > 3) {
        $nomeReduzido = $nomeReduzido[0] . ' ' . $nomeReduzido[1] . ' ' . $nomeReduzido[sizeof($nomeReduzido) - 1];
    } else {
        $nomeReduzido = $linha->nome;
    }

    $this->table->add_row($nomeReduzido, $linha->cpf, $linha->email, $linha->num_telefone, anchor("cliente/listaCliente/$linha->id_cliente", '<center><img src="http://localhost/otica/public/img/search.png" width="23"/></center>'),anchor("cliente/atualizarCliente/$linha->id_cliente", '<center><img src="http://localhost/otica/public/img/edit.png" width="23"/></center>'), '<center><p onClick="if (! confirm(\'Tem certeza que deseja excluir o cliente abaixo? \n\n Nome: ' . $linha->nome . '\n CPF: ' . $linha->cpf . '\n Email: ' . $linha->email . '\')) { return false; }">' . anchor('cliente/deletarCliente/' . $linha->id_pessoa . '/' . $linha->id_cliente, '<img src="http://localhost/otica/public/img/delete.png" width="23"/>') . '</p></center>');
}

/* * $tmpl = array(
  'table_open' => '<table border="1" cellpadding="2" width="100%" cellspacing="1" class="listholover">',
  'row_start' => '<tr class="alt">',
  'row_alt_start'=> '<tr class="alt">',
  'cell_start'          => '<td>',
  'cell_end'            => '</td>',
  );
 * 
 * 
 */
$tmpl = array(
    'table_open' => '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">',
    'cell_start' => '<td valign="middle">',
    'cell_end' => '</td">',
    'cell_alt_start' => '<td valign="middle">',
    'cell_alt_end' => '</td>',
);

echo"<div class='tabela'>";
$this->table->set_template($tmpl);
echo $this->table->generate();
echo"</div>";
?>
