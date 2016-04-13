<?php

echo "<h2>$titulo</h2>";

echo form_open('fornecedor/pesquisa');

echo "<br>";
//Essa linha pode remover
echo "</br>";
//Essa linha pode remover

echo "</td><td>";
//Essa linha pode remover
echo form_label('Pesquise:');
echo form_input(array('name' => 'nome'), set_value('nome'));
echo "</td></tr>";
//Essa linha pode remove

echo form_submit(array('name' => 'Procurar'), 'Procurar');

echo "<br><center><table>";
//Essa linha pode remover

if ($pesquisa != NULL) {

	$this -> table -> set_heading('NOME', 'EMAIL', 'CNPJ', 'TELEFONE');
	foreach ($pesquisa as $linha) {

		$this -> table -> add_row($linha -> nome, $linha -> email, $linha -> cnpj, $linha -> num_telefone, anchor("Fornecedor/update/$linha->id_pessoa/$linha->id_fornecedor",'Editar').'
      |  '.anchor("Fornecedor/delete/$linha->id_pessoa",'Excluir'));

	}
	echo $this -> table -> generate();

	echo "</br></table>";
	//Essa linha pode remover

}
echo form_close();
?>