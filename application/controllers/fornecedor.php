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

class Fornecedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('fornecedor_model');
        $this->load->model('util_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
        $this->form_validation->set_error_delimiters('<erro class="errorFormulario">', '</erro>');
    }

    public function index() {
        $dados = array('pagina' => 'lista_fornecedor', 'titulo' => 'Pesquisa Fornecedor',
            'fornecedor' => $this->fornecedor_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function adiciona() {
        $dados = array('pagina' => 'adiciona_fornecedor', 'titulo' => 'Cadastro de Fornecedor');

        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|max_length[100]|strtolower|valid_email');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'trim|max_length[20]|valid_cnpj|is_unique[fornecedor.cnpj]');
        $this->form_validation->set_rules('num_telefone1', 'Numero do Telefone', 'trim|max_length[15]|min_length[14]');
        $this->form_validation->set_rules('num_telefone2', 'Numero do Celular', 'trim|max_length[15]|min_length[14]');

        if ($this->form_validation->run()) {
            $dados = elements(array('nome', 'email', 'cnpj', 'num_telefone1', 'num_telefone2'), $this->input->post());
            $this->fornecedor_model->do_insert($dados);
        } else {
            $dados = array('titulo' => 'Cadastro de Fornecedor', 'pagina' => 'adiciona_fornecedor',);
            $this->load->view('Principal', $dados);
        }
    }

    public function lista() {
        $dados = array('pagina' => 'lista_fornecedor', 'titulo' => 'Pesquisa de Fornecedor',
            'fornecedor' => $this->fornecedor_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function update() {
        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|max_length[100]|strtolower|valid_email');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'trim|max_length[20]|valid_cnpj');
        $this->form_validation->set_rules('num_telefone1', 'Numero do Telefone', 'trim|max_length[15]');
        $this->form_validation->set_rules('num_telefone2', 'Numero do Celular', 'trim|max_length[15]');

        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'email', 'cnpj', 'num_telefone1',
                'num_telefone2'), $this->input->post());

            $this->fornecedor_model->do_update(
                    $dados, array('id_pessoa' => $this->input->post('id_pessoa'),
                'id_fornecedor' => $this->input->post('id_fornecedor')));
        }
        
        $dados = array('titulo' => 'Alterar dados do Fornecedor', 'pagina' => 'atualiza_fornecedor');
        $this->load->view('Principal_popup', $dados);
    }

    public function visualiza() {
        $dados = array('pagina' => 'visualiza_fornecedor', 'titulo' => 'Visualiza Fornecedor',
            'fornecedor' => $this->fornecedor_model->get_byid($this->uri->segment(3)));

        $this->load->view('Principal', $dados);
    }
    
    public function delete() {
        $dados = array('titulo' => 'CRUD &raquo; Delete', 'tela' => 'Delete',);
        $iduser = $this->uri->segment(3);
        
        if ($iduser == NULL) {
            redirect('fornecedor/lista');
        }

        $this->util_model->deletarComEvento($this->fornecedor_model->do_delete($iduser), 'o', 'Fornecedor', 'fornecedor/lista');

        $this->load->view('Principal', $dados);
    }
}