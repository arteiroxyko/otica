<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/table_jui.css" />
<link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js">
</script>
<script type="text/javascript" src="http://localhost/otica/public/js/produto.js"></script>

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

class Produto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->model('produto_model');
        $this->load->model('fornecedor_model');
        $this->load->model('grife_model');
        $this->load->model('util_model');
        $this->load->library('uri');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');

        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {
        $dados = array('pagina' => 'adiciona_produto', 'titulo' => 'Cadastro de Produto', 'carrega' => 0,
            'todos_fornecedor' => $this->fornecedor_model->getAll()->result(),
            'todas_grife' => $this->grife_model->getAll()->result());
        $this->load->view('Principal', $dados);
    }

    public function adiciona() {
        //Dados da tabela produto
        $this->form_validation->set_rules('cod_barra', 'Código de Barras', 'trim|max_length[20]');
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('descricao', 'Descricao', 'trim');
        $this->form_validation->set_rules('preco_custo', 'Preço de Custo', 'trim|ucwords|required');
        $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'trim|ucwords|required');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|max_length[11]');
        $this->form_validation->set_rules('validade', 'Validade', 'trim');

        //Verifica se e uma armação
        if ($this->input->post('produto') == 1) {
            //Dados da tabela amracao
            $this->form_validation->set_rules('largura_lente', 'Largura da lente');
            $this->form_validation->set_rules('largura_ponte', 'Largura da Ponte');
            $this->form_validation->set_rules('comprimento_haste', 'Comprimento da haste');
            $this->form_validation->set_rules('modelo', 'modelo', 'trim');
            $this->form_validation->set_rules('grife', 'Grife');
            $this->form_validation->set_rules('fornecedor', 'Fornecedor');
        }

        if ($this->form_validation->run()) {
            $dados = elements(array('cod_barra', 'nome', 'descricao', 'preco_custo', 'preco_venda', 'quantidade', 'validade',
                'largura_lente', 'largura_ponte', 'comprimento_haste', 'modelo', 'grife', 'fornecedor',
                'produto'), $this->input->post());
            $this->produto_model->do_insert($dados);
        }

        $dados = array('titulo' => 'Cadastro de Produto', 'pagina' => 'adiciona_produto', 'carrega' => $this->input->post('produto'),
            'todos_fornecedor' => $this->fornecedor_model->getAll()->result(),
            'todas_grife' => $this->grife_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function lista() {
        $dados = array('pagina' => 'lista_produto', 'titulo' => 'Pesquisa de Produto',
            'produto' => $this->produto_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function visualiza() {
        $dados = array('pagina' => 'visualiza_produto', 'titulo' => 'Visualiza Produto',
            'todos_fornecedor' => $this->fornecedor_model->getAll()->result(),
            'produto' => $this->produto_model->get_byid($this->uri->segment(3)),
            'todas_grife' => $this->grife_model->getAll()->result());

        $this->load->view('Principal', $dados);
    }

    public function update() {
        //Dados da tabela produto
        $this->form_validation->set_rules('cod_barra', 'Código de Barras', 'trim|max_length[20]');
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('descricao', 'Descricao', 'trim');
        $this->form_validation->set_rules('preco_custo', 'Preço de Custo', 'trim|ucwords|required');
        $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'trim|ucwords|required');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|max_length[11]');
        $this->form_validation->set_rules('validade', 'Validade', 'trim');

        //Verifica se e uma armação
        if ($this->input->post('produto') == 1) {
            //Dados da tabela amracao
            $this->form_validation->set_rules('largura_lente', 'Largura da lente', 'trim');
            $this->form_validation->set_rules('largura_ponte', 'Largura da Ponte', 'trim');
            $this->form_validation->set_rules('comprimento_haste', 'Comprimento da haste', 'trim');
            $this->form_validation->set_rules('modelo', 'modelo', 'trim');
            $this->form_validation->set_rules('grife', 'Grife', 'trim');
            $this->form_validation->set_rules('fornecedor', 'Fornecedor', 'trim');
        }

        if ($this->form_validation->run()) {
            $dados = elements(array('cod_barra', 'nome', 'descricao', 'preco_custo', 'preco_venda', 'quantidade', 'status', 'validade',
                'largura_lente', 'largura_ponte', 'comprimento_haste', 'modelo', 'grife', 'fornecedor',
                'produto'), $this->input->post());

            $this->produto_model->do_update(
            $dados, $this->input->post('id_produto'));
        }

        $dados = array('titulo' => 'Alterar dados do Produto', 'pagina' => 'atualiza_produto');
        $this->load->view('Principal_popup', $dados);
    }
    
    public function delete() {
        $dados = array('titulo' => 'CRUD &raquo; Delete', 'tela' => 'Delete');
        $id = $this->uri->segment(3);

        if (! $id == NULL) {
            $this->util_model->deletarComEvento($this->produto_model->do_delete($id), 'o', 'Produto', 'produto/lista');
        }
        
        $this->load->view('Principal', $dados);
    }
}