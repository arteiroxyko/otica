<?php
echo "<h2>$titulo</h2>";

if($this->session->flashdata('msg')){
    $msg = $this->session->flashdata('msg');
    echo "<body onLoad=\" alert('$msg');\">";
}

$grife = $grife;//Pega a variavel da Controller (boa pratica)

    if ($grife != NULL) {
        $this -> table -> set_heading('NOME','&nbsp; ','&nbsp; ');
        foreach ($grife as $linha) {

            $this -> table -> add_row($linha -> nome, "<a href=\"javascript:abrirPopUp('" . base_url('grife/update/' . $linha->id) . "','400','300');\"> <center><img src='http://localhost/otica/public/img/edit.png' width='23'/></center></a>", anchor("grife/delete/$linha->id",'<center><img src="http://localhost/otica/public/img/delete.png" width="23"/></center>'));
        }
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