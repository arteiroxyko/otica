<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js">
</script>
<script type="text/javascript" src="http://localhost/otica/public/js/util.js"></script>

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

class ContasAPagar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('util_model');
        $this->load->model('contas_a_pagar_model');
        $this->load->library('uri');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {
        $dados = array('pagina' => 'adiciona_conta_a_pagar', 'titulo' => 'Conta a Pagar');
        $this->load->view('Principal', $dados);
    }

    public function adiciona() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('preco', 'Preço', 'required|trim');
        
        if ($this->form_validation->run()) {
            $dados = elements(array('nome', 'preco', 'data', 'descricao'), $this->input->post());
            $this->contas_a_pagar_model->do_insert($dados);
        }
        
        $dados = array('pagina' => 'adiciona_conta_a_pagar', 'titulo' => 'Conta a Pagar');
        $this->load->view('Principal', $dados);
    }

    public function lista() {
        $dados = array('pagina' => 'lista_contas_a_pagar', 'titulo' => 'Contas a Pagar', 'contas' => $this->contas_a_pagar_model->getAll()->result());
        $this->load->view('Principal', $dados);
    }

    public function visualiza() {
        $dados = array('pagina' => 'visualiza_conta_a_pagar', 'titulo' => 'Visualiza Conta a Pagar');
        $this->load->view('Principal', $dados);
    }

    public function update() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('preco', 'Preço', 'required|trim');
        
        if ($this->form_validation->run()) {
            $dados = elements(array('nome', 'preco', 'data', 'descricao'), $this->input->post());
            $this->contas_a_pagar_model->do_update($dados, $this->uri->segment(3));
        }
        
        $dados = array('pagina' => 'atualiza_conta_a_pagar', 'titulo' => 'Altera Conta a Pagar');
        $this->load->view('Principal_popup', $dados);
    }
    
    public function delete() {
        $dados = array('titulo' => 'CRUD &raquo; Delete', 'tela' => 'Delete');
        $id = $this->uri->segment(3);

        if (! $id == NULL) {
            $this->util_model->deletarComEvento($this->contas_a_pagar_model->do_delete($id), 'a', 'Conta a Pagar', 'contasAPagar/lista');
        }
        
        $this->load->view('Principal', $dados);
    }
}