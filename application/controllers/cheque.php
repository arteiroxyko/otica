<script type="text/javascript" src="http://localhost/otica/public/js/cheque.js"></script>
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js">
</script>

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

class Cheque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('cheque_model');
        $this->load->model('venda_model');
        $this->load->model('util_model');
        $this->load->library('uri');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {
        $dados = array('pagina' => 'gerenciar_cheques', 'titulo' => 'Gerenciar Cheques');
        $this->load->view('Principal', $dados);
    }
    
    public function baixaCheque() {
        $id = $this->uri->segment(4); // Pega id do cheque
        $status = $this->uri->segment(4); // Pega status
        $this->cheque_model->baixaCheque($id, $status);
    }
    
    public function atualizarCheque() {
        $this->form_validation->set_rules('data', 'Data', 'required|trim');
        
        if ($this->form_validation->run()) {
            $this->cheque_model->atualizaCheque($this->input->post('id'), $this->input->post('data'));
        }
        $dados = array('pagina' => 'altera_cheque', 'titulo' => 'Altera data do Cheque');
        $this->load->view('Principal_popup', $dados);
    }
}
?>
