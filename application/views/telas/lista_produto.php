<?php
echo "<h2>$titulo</h2>";

if($this->session->flashdata('msg')){
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\"alert('$msg');\">";
}

$produto = $produto;//Pega a variavel da Controller (boa pratica)

$this->table->set_heading('COD', 'COD. BARRA','NOME','CUSTO R$','VENDA R$','QTD', 'ATIVO', '&nbsp; ','&nbsp; ','&nbsp; ');

foreach ($produto as $linha) {
    
    if($linha->categoria=="0"){
        $lenPopUp = "'780','400'";
    } else {
        $lenPopUp = "'780','550'";
    }
    
    if ($linha->status == "0") {
        $ativo="<img src=http://localhost/otica/public/img/false.png width=18>";
        $value = 0;
    } else {
        $ativo="<img src=http://localhost/otica/public/img/true.png width=18>";
        $value = 1;
    }
    $this->table->add_row($linha->id_produto, $linha->cod_barra, $linha->nome, "R$ ".$this->util->pontoParaVirgula($linha->preco_custo), "R$ ".$this->util->pontoParaVirgula($linha->preco_venda), '<center>'.$linha->quantidade, "<center><p id='num_ativo' style='display: none;'>".$value."</p>".$ativo."</center>", anchor("produto/visualiza/$linha->id_produto", '<center><img src="http://localhost/otica/public/img/search.png" width="23"/></center>'),"<a href=\"javascript:abrirPopUp('" . base_url('produto/update/' . $linha->id_produto) . "',".$lenPopUp.");\"> <center><img src='http://localhost/otica/public/img/edit.png' width='23'/></center></a>", '<center><p onClick="if (! confirm(\'Tem certeza que deseja excluir o produto abaixo? \n\n Código de barra: ' . $linha->cod_barra.'\n Nome: '.$linha->nome.'\')) { return false; }">' . anchor('produto/delete/'.$linha->id_produto, '<img src="http://localhost/otica/public/img/delete.png" width="23"/>') . '</p></center>');
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