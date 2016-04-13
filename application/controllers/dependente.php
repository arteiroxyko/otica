<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#example').dataTable({
                    "bPaginate": true,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "bSort": false,
                    "oLanguage": {
                   "sLengthMenu": "<br>Escolhe um cliente para cadastrar o dependente"
                  }
                });
            });
        </script>
         <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#lista_dependentes_table1').dataTable({
                    "bPaginate": true,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                });
            });
        </script>

<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dependente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helpers('url');
        $this->load->helper('form');
        $this->load->model('dependente_model');
        $this->load->model('cliente_model');
        $this->load->library('form_validation');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {

        $dados = Array(
            'pagina' => 'lista_responsavel',
            'titulo' => 'Cadastro de Dependente',
        );

        $this->load->view('Principal', $dados);
    }

    public function atualizarDependente() {

        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('data_nascimento', 'Data Nascimento', 'trim');
        $this->form_validation->set_rules('responsavel', 'RESPONSAVEL', 'trim|max_length[20]');


        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'data_nascimento', 'responsavel'), $this->input->post());


            $this->dependente_model->atualizaDependente(
                    $dados, array('id_dependente' => $this->input->post('id_dependente'),
            ));
        }

        $dados = array(
            'titulo' => 'Alterar dados do dependente',
            'pagina' => 'altera_dependente',
        );

        $this->load->view('principal_popup', $dados);
    }

    public function deletarDependente() {
        
        $id_cliente = $this->uri->segment(3);
        $id_dependente = $this->uri->segment(4);
        
        if ($id_dependente != NULL) {

            $retorno = $this->dependente_model->deletaDependente($id_dependente);
            
            if ($retorno == '0') {
                $this->session->set_flashdata('msg', 'Dependente deletado com sucesso');
                redirect(base_url('dependente/listarDependentes/'. $id_cliente));
            } else if ($retorno == '1451') {
                $this->session->set_flashdata('msg', 'Não foi possível deletar o dependente porque \njá está associado a outro evento');
                redirect(base_url('dependente/listarDependentes/'. $id_cliente));
            }
        } else {
            redirect(current_url());
        }
    }

    public function cadastrarDependente() {

        $this->form_validation->set_rules('nomeCliente', 'NOME DO CLIENTE', 'trim|required|ucwords');
        $this->form_validation->set_rules('cpfCliente', 'CPF DO CLIENTE', 'trim|required|ucwords');
        $this->form_validation->set_rules('nomeDependente', 'NOME DO DEPENDENTE', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('dataNascimentoDependente', 'Data Nascimento', 'trim');
        $this->form_validation->set_rules('responsavelDependente', 'RESPONSAVEL', 'trim|max_length[20]|ucwords');

        if ($this->form_validation->run() == true) {

            $dependente = elements(array('nomeDependente', 'dataNascimentoDependente', 'responsavelDependente', 'idCliente'), $this->input->post());
            $this->dependente_model->cadastrarDependente($dependente);
        } else {

            $dados = array(
                'titulo' => 'Cadastro de Dependente',
                'pagina' => 'adiciona_dependente',
            );

            $this->load->view('Principal_popup', $dados);
        }
    }

   public function listarDependentes() {

        $dados = Array(
            'pagina' => 'lista_dependentes',
            'titulo' => 'Lista de Dependentes',
        );




        $this->load->view('Principal_popup', $dados);
    }   
    
    
}
?>
