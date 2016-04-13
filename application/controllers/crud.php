<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('crud_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');
    }

    public function index() {

        $dados = array(
            'titulo' => 'CRUD com CODEIgniter',
            'tela' => '',
        );

        $this->load->view('crud', $dados);
    }

    public function create() {
        
        
        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[200]|ucwords');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|max_length[200]|strtolower|valid_email|is_unique[curso_ci.email]');
        $this->form_validation->set_rules('login', 'LOGIN', 'trim|required|max_length[200]|strtolower|is_unique[curso_ci.login]');
        $this->form_validation->set_rules('senha', 'SENHA', 'trim|required|strtolower');
        $this->form_validation->set_rules('senha2', 'SENHA', 'trim|required|strtolower|matches[senha]');
        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'login', 'email', 'senha'), $this->input->post());

            $this->crud_model->do_insert($dados);
        }


        $dados = array(
            'titulo' => 'CRUD &raquo; Create',
            'tela' => 'Create',
        );

        $this->load->view('crud', $dados);
    }

    public function retrieve() {


        $dados = array(
            'titulo' => 'CRUD &raquo; Retrieve',
            'tela' => 'Retrieve',
            'usuarios' => $this->crud_model->get_all()->result(),
        );

        $this->load->view('crud', $dados);
    }

    public function update() {

        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[200]|ucwords');
        $this->form_validation->set_rules('senha', 'SENHA', 'trim|required|strtolower');
        $this->form_validation->set_rules('senha2', 'SENHA', 'trim|required|strtolower|matches[senha]');
        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'senha'), $this->input->post());

            $this->crud_model->do_update($dados, array('id' => $this->input->post('idusuario')));
        }

        $dados = array(
            'titulo' => 'CRUD &raquo; Update',
            'tela' => 'Update',
        );

        $this->load->view('crud', $dados);
    }

    public function delete() {

        $dados = array(
            'titulo' => 'CRUD &raquo; Delete',
            'tela' => 'Delete',
        );
          $iduser = $this->uri->segment(3);
        
          
          if($iduser == NULL)redirect ('crud/retrieve');
          
          $this->crud_model->do_delete($iduser);
              
          $this->load->view('crud', $dados);
        
        
    }

}