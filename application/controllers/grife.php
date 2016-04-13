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

class grife extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('array');
		$this -> load -> model('grife_model');
                $this->load->model('util_model');
                $this -> load -> library('uri');
		$this -> load -> library('form_validation');
		$this -> load -> library('session');
		$this -> load -> library('table');
                $this -> load -> library('util');
                
                $this->login_model->logado();//Verifica se o usuário está logado

	}

	public function index() {
		$dados = array('pagina' => 'adiciona_grife', 'titulo' => 'Cadastro de Grife');
		$this -> load -> view('Principal', $dados);
	}
        
        public function adiciona() {
            $this -> form_validation -> set_rules('nome', 'Nome', 'trim|max_length[60]|ucwords|required');
            
            if ($this -> form_validation -> run()) {
                $dados = elements(array('nome'), $this -> input -> post());
                $this -> grife_model -> do_insert($dados);
                
            } else {
                $dados = array('titulo' => 'Cadastro de Grife', 'pagina' => 'adiciona_grife');
                $this -> load -> view('Principal', $dados);
            }
	}

	public function lista() {
		$dados = array('pagina' => 'lista_grife', 'titulo' => 'Pesquisa de Grife', 
		'grife' => $this -> grife_model -> getAll() -> result());

		$this -> load -> view('Principal', $dados);
	}
        
        public function pesquisa() {
            $this->form_validation->set_rules('pesquisa');
            $this->form_validation->run();
            $dados = Array(
            'pagina' => 'lista_grife',
            'titulo' => 'Manter Grife',
            'grife' => $this->grife_model->do_select($this->input->post('pesquisa'))->result(),
            );
            
            $this -> load -> view('Principal', $dados);
	}

	public function update() {
            $this -> form_validation -> set_rules('nome', 'Nome', 'trim|max_length[50]|ucwords|required');
            
            if ($this->form_validation->run() == true) {
                $dados = elements(array('nome'), $this->input->post());
                $this->grife_model->do_update($dados, array('id_grife' => $this->input->post('id_grife')));
            }
		$dados = array('titulo' => 'Alterar Grife', 'pagina' => 'atualiza_grife');
		$this -> load -> view('Principal_popup', $dados);
            }

	public function delete() {
		$dados = array('titulo' => 'CRUD &raquo; Delete', 'tela' => 'Delete');
		$id = $this -> uri -> segment(3);

		if (! $id == NULL) {
                    $this->util_model->deletarComEvento($this->grife_model->do_delete($id), 'a', 'Grife', 'grife/lista');
                }
                
		$this -> load -> view('Principal', $dados);
	}

}