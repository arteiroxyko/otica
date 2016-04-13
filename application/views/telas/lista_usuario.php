<?php
echo "<h2>$titulo</h2>";

if($this->session->flashdata('msg')){
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
    echo "<script>location.reload();</script>";
}

$usuario = $usuario;

$this->table->set_heading('NOME', 'LOGIN','EMAIL','&nbsp; ','&nbsp; ');

foreach ($usuario as $linha) {
        $this->table->add_row($linha->nome_usuario, $linha->login, $linha->email, "<a href=\"javascript:abrirPopUp('" . base_url('usuario/update/'.$linha->id_usuario)."','700','360');\"> <center><img src='http://localhost/otica/public/img/edit.png' width='23'/></center></a>", '<center><p onClick="if (! confirm(\'Tem certeza que deseja excluir o usuário abaixo? \n\n Nome: ' . $linha->nome_usuario.'\n Login: '.$linha->login.'\n Email: '.$linha->email.'\')) { return false; }">'.anchor('usuario/delete/'.$linha->id_usuario, '<img src="http://localhost/otica/public/img/delete.png" width="23"/>').'</p></center>');
}

$tmpl = array(
    'table_open'=>'<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">',
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