<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#example').dataTable({
            "bPaginate": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });
    });
</script>

<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('usuario_model');
        $this->load->model('nivel_model');
        $this->load->model('util_model');
        $this->load->library('uri');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {
        $dados = array('pagina' => 'adiciona_usuario', 'titulo' => 'Cadastro de Usuário');
        $this->load->view('Principal', $dados);
    }

    public function adiciona() {
        //Dados do usuário
        $this->form_validation->set_rules('nome', 'Nome', 'trim');
        $this->form_validation->set_rules('login', 'Login', 'trim|required|is_unique[usuario.login]');
        $this->form_validation->set_rules('senha', 'Senha', 'trim|required');
        $this->form_validation->set_rules('senha_confirma', 'Senha', 'trim|required');
        $this->form_validation->set_rules('lembrete_senha', 'Lembrete de Senha', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim');
        $this->form_validation->set_rules('id_nivel', 'Nivel de Acesso', 'trim|required');
        
        if ($this->input->post('id_nivel') == "4") {
            //Dados do médico
            $this->form_validation->set_rules('crm', 'CRM', 'trim|required');
            $crm = $this->input->post('crm');
        } else {
            $crm = null;
        }
        
        if ($this->form_validation->run()) {
            if ($this->input->post('id_nivel') != "0") {
                $dados = elements(array('nome', 'login', 'senha', 'lembrete_senha', 'email', 'id_nivel'), $this->input->post());
                $this->usuario_model->do_insert($dados, $crm);
            } else {
                $dados = array('titulo' => 'Cadastro de Usuário', 'pagina' => 'adiciona_usuario');
            }
        } else {
            $dados = array('titulo' => 'Cadastro de Usuário', 'pagina' => 'adiciona_usuario');
        }

        $this->load->view('Principal', $dados);
    }

    public function lista() {
        $dados = array('pagina' => 'lista_usuario', 'titulo' => 'Pesquisa de Usuário',
            'usuario' => $this->usuario_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function update() {
        //Dados do usuário
        $this->form_validation->set_rules('nome', 'Nome', 'trim');
        $this->form_validation->set_rules('login', 'Login', 'trim|required');
        $this->form_validation->set_rules('senha', 'Senha', 'trim|required');
        $this->form_validation->set_rules('senha_confirma', 'Senha', 'trim|required');
        $this->form_validation->set_rules('lembrete_senha', 'Lembrete de Senha', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim');
        $this->form_validation->set_rules('id_nivel', 'Nivel de Acesso', 'trim|required');
        
        if ($this->input->post('id_nivel') == "4") {
            //Dados do médico
            $this->form_validation->set_rules('crm', 'CRM', 'trim|required');
            $crm = $this->input->post('crm');
        } else {
            $crm = null;
        }
        
        if ($this->form_validation->run()) {
            if ($this->input->post('id_nivel') != "0") {
                $dados = elements(array('nome', 'login', 'senha', 'lembrete_senha', 'email', 'id_nivel'), $this->input->post());
                $this->usuario_model->do_update($dados, $crm, $this->input->post('id'));
            } else {
                $dados = array('titulo' => 'Alterar dados do usuario', 'pagina' => 'atualiza_usuario');
            }
        } else {
            $dados = array('titulo' => 'Alterar dados do usuario', 'pagina' => 'atualiza_usuario');
        }
        
        $this->load->view('Principal_popup', $dados);
    }

    public function delete() {
        $dados = array('titulo' => 'CRUD &raquo; Delete', 'tela' => 'Delete',);
        $iduser = $this->uri->segment(3);

        if ($iduser == NULL) {
            redirect('usuario/lista');
        } else {
            $this->util_model->deletarComEvento($this->usuario_model->do_delete($iduser), 'o', 'Usuário', 'usuario/lista');
        }
        $this->load->view('Principal', $dados);
    }

//    public function esqueciSenha() {
//        $dados = array('pagina' => 'esqueci_minha_senha');
//
//        $this->load->view('login', $dados);
//    }
}