<?php

echo "<h2>$titulo</h2>";

echo form_open('produto/pesquisa');

echo "</td><td>";
//Essa linha pode remover
echo form_label('Pesquisa:');
echo form_input(array('name'=>'pesquisa'),  set_value('pesquisa'),'autofocus, autocomplete ="off"');
echo "</td></tr>";
//Essa linha pode remove

echo form_submit(array('name' => 'Procurar'), 'Procurar');
echo "<p></p>";
echo "<br><center><table>";
//Essa linha pode remover

if ($pesquisa != NULL) {

	$this -> table -> set_heading('REFERENCIA', 'NOME', 'DESCRIÇÃO', 'PREÇO CUSTO', 'PREÇO VENDA', 'VALIDADE', 'QUANTIDADE', 'STATUS', 'MANTER');
        foreach ($pesquisa as $linha) {
            $this -> table -> add_row($linha ->referencia, $linha -> nome, $linha -> descricao, $linha -> preco_custo, $linha -> preco_venda, $linha -> validade,
                    $linha -> quantidade, $linha -> status,
                    anchor("produto/update/$linha->id_produto",'Editar').'|'.
                    anchor("produto/delete/$linha->id_produto",'Excluir'));
        }
        $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" width="100%" cellspacing="1" class="mytable">' );
        $this->table->set_template($tmpl);
        echo $this -> table -> generate();

} else {
    redirect('produto/lista');
}
echo form_close();
?>