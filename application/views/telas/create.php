<?php


echo"<h2>Cadastro de Cliente</h2>";

echo form_open('crud/create');

echo validation_errors('<p>','</p>');

if($this->session->flashdata('cadastrook')){
    
    echo '<p>'.$this->session->flashdata('cadastrook').'</p>';
}




echo form_label('Nome');
echo form_input(array('name'=>'nome'),  set_value('nome'),'autofocus');
echo form_label('Email');
echo form_input(array('name'=>'email'),set_value('email'));
echo form_label('Login');
echo form_input(array('name'=>'login'),set_value('login'));
echo form_label('Senha');
echo form_password(array('name'=>'senha'),set_value('senha'));
echo form_label('Repita a Senha');
echo form_password(array('name'=>'senha2'),set_value('senha2'));
echo form_submit(array('name'=>'Cadastrar'),'Cadastrar');

echo form_close();

