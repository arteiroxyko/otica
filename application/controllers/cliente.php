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

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helpers('url');
        $this->load->helper('form');
        $this->load->model('cliente_model');
        $this->load->model('receita_model');
        $this->load->model('dependente_model');
        $this->load->model('venda_model');
        $this->load->library('form_validation');
        $this->load->library('table');
            
        $this->login_model->logado();//Verifica se o usuário está logado
            
          
        $this->form_validation->set_error_delimiters('<erro class="errorFormulario">','</erro>');
             
    }
    
    public function index() {

        $dados = Array(
            'pagina' => 'adiciona_cliente',
            'titulo' => 'Cadastro de Cliente'
        );

        $this->load->view('Principal', $dados);
    }

    public function cadastrarCliente() {

        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|max_length[100]|strtolower|valid_email');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required|max_length[15]|valid_cpf|is_unique[cliente.cpf]');
        $this->form_validation->set_rules('data_nascimento', 'Data Nascimento', 'trim');
        $this->form_validation->set_rules('num_telefone1', 'Telefone Residencial', 'trim|min_length[14]|max_length[15]');
        $this->form_validation->set_rules('num_telefone2', 'Telefone Celular', 'trim|min_length[14]|max_length[15]');
        $this->form_validation->set_rules('rua', 'RUA', 'trim|max_length[80]');
        $this->form_validation->set_rules('bairro', 'BAIRRO', 'trim|max_length[50]|');
        $this->form_validation->set_rules('cidade', 'CIDADE', 'trim||max_length[50]');
        $this->form_validation->set_rules('complemento', 'COMPLEMENTO', 'trim|max_length[20]');
        $this->form_validation->set_rules('estado', 'ESTADO', 'trim|max_length[2]');
        $this->form_validation->set_rules('cep', 'CEP', 'trim|max_length[10]');
        
               
        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'email', 'cpf', 'data_nascimento', 'num_telefone1',
                'num_telefone2', 'rua', 'bairro', 'cidade', 'complemento', 'estado', 'cep'), $this->input->post());
            $this->cliente_model->cadastrarCliente($dados);
        } else {

            $dados = array(
                'titulo' => 'Cadastro de Cliente',
                'pagina' => 'adiciona_cliente',
            );

            $this->load->view('Principal', $dados);
        }
    }

    public function listarClientes() {

        $dados = Array(
            'pagina' => 'listar_clientes',
            'titulo' => 'Pesquisa de Cliente',
            'clientes' => $this->cliente_model->listarClientes('')->result(),
        );




        $this->load->view('Principal', $dados);
    }

        public function listaCliente() {

        $dados = Array(
            'pagina' => 'lista_cliente',
            'titulo' => 'Visualiza Cliente',
            'cliente' => $this->cliente_model->retornaCliente($this->uri->segment(3)),
        );
        
        $this->load->view('Principal', $dados);
    }

    public function atualizarCliente() {

        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|max_length[100]|strtolower|valid_email');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required|max_length[15]|valid_cpf');
        $this->form_validation->set_rules('data_nascimento', 'Data Nascimento', 'trim');
        $this->form_validation->set_rules('num_telefone1', 'Telefone Residencial', 'trim|min_length[14]|max_length[15]');
        $this->form_validation->set_rules('num_telefone2', 'Telefone Celular', 'trim|min_length[14]|max_length[15]');
        $this->form_validation->set_rules('rua', 'RUA', 'trim|max_length[80]');
        $this->form_validation->set_rules('bairro', 'BAIRRO', 'trim|max_length[50]|');
        $this->form_validation->set_rules('cidade', 'CIDADE', 'trim||max_length[50]');
        $this->form_validation->set_rules('complemento', 'COMPLEMENTO', 'trim|max_length[20]');
        $this->form_validation->set_rules('estado', 'ESTADO', 'trim|max_length[2]');
        $this->form_validation->set_rules('cep', 'CEP', 'trim|max_length[10]');
        if ($this->form_validation->run() == true) {

            $dados = elements(array('nome', 'email', 'cpf', 'data_nascimento', 'num_telefone1',
                'num_telefone2', 'rua', 'numero', 'bairro', 'cidade', 'complemento', 'estado', 'cep'), $this->input->post());

            $this->cliente_model->atualizaCliente(
                    $dados, array('id_pessoa' => $this->input->post('id_pessoa'),
                'id_cliente' => $this->input->post('id_cliente'),
            ));
        }

        $dados = array(
            'titulo' => 'Alterar dados do cliente',
            'pagina' => 'altera_cliente',
        );

        $this->load->view('principal', $dados);
    }

    public function deletarCliente() {

        if ($this->uri->segment(3) != NULL) {

            $id_pessoa = $this->uri->segment(3);
       
            $this->cliente_model->deleteCliente($id_pessoa);
              
        }
    }
    
//    public function pesquisaCliente(){
//            
//        $this->form_validation->set_rules('pesquisa');
//        $this->form_validation->run();
//            $dados = Array(
//            'pagina' => 'listar_clientes',
//            'titulo' => 'Lista Todos os Clientes',
//            'clientes' => $this->cliente_model->listarClientes($this->input->post('pesquisa'))->result(),
//        );
//        $this->load->view('Principal', $dados);
//    }
    
    public function cadastrarDependente() {
        
        $this->form_validation->set_rules('nomeDependente', 'NOME', 'trim|required|max_length[100]|ucwords');
        $this->form_validation->set_rules('dataNascimentoDependente', 'Data Nascimento', 'trim');
        $this->form_validation->set_rules('responsavelDependente', 'RESPONSAVEL', 'trim|max_length[20]|ucwords');
               
      if($this->form_validation->run()==true){

            $dependente = elements(array('nomeDependente', 'dataNascimentoDependente', 'responsavelDependente'), $this->input->post());
            
            
            $dados = array(
                'titulo' => 'Cadastro de Depedente',
                'pagina' => 'adiciona_dependente',
               );

            $this->load->view('Principal_popup', $dados);
            
            
           
      }else{
            $dados = array(
                'titulo' => 'Cadastro de Depedente',
                'pagina' => 'adiciona_dependente',
            );

            $this->load->view('Principal_popup', $dados);
    }}
    }
 ?>
