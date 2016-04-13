<?php
echo "<h2>$titulo</h2>";

if($this->session->flashdata('msg')){
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');location.reload();\">";
}

$fornecedor = $fornecedor;//Pega a variavel da Controller (boa pratica)

$this->table->set_heading('NOME', 'EMAIL', 'CNPJ', 'TELEFONE', '&nbsp; ','&nbsp; ','&nbsp; ');

foreach ($fornecedor as $linha) {
    
    $this -> table -> add_row($linha->nome, $linha->email, $linha->cnpj, $linha->num_telefone, anchor("fornecedor/visualiza/".$linha->id_pessoa."/".$linha->id_fornecedor, '<center><img src="http://localhost/otica/public/img/search.png" width="23"/></center>'), "<a href=\"javascript:abrirPopUp('".base_url('fornecedor/update/'.$linha->id_pessoa.'/'.$linha->id_fornecedor). "','550','400');\"> <center><img src='http://localhost/otica/public/img/edit.png' width='23'/></center></a>", '<center><p onClick="if (! confirm(\'Tem certeza que deseja excluir o fornecedor abaixo? \n\n Nome: ' . $linha->nome.'\n CNPJ: '.$linha->cnpj.'\')) { return false; }">' . anchor('fornecedor/delete/'.$linha->id_pessoa, '<img src="http://localhost/otica/public/img/delete.png" width="23"/>') . '</p></center>');

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