<link href="http://localhost/otica/public/jquery/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost/otica/public/jquery/datagrid/jquery.min.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/datagrid/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://localhost/otica/public/jquery/datagrid/jquery.ui.datagrid.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#example').dataTable({
            "bPaginate": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bSort": false
        });
    });
</script>
<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('table');
        $this->load->library('form_validation');
        $this->load->library('uri');
        $this->load->helper('date');
        $this->load->model('cliente_model');
        $this->load->model('produto_model');
        $this->load->model('venda_model');


        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {

        redirect('venda/cadastrarVenda');
    }

    public function cadastrarVenda() {
               $dados = array(
                'titulo' => 'Venda de Produtos',
                'pagina' => 'adiciona_venda',
            );

            $this->load->view('Principal', $dados);
        
    
    }

    public function listarClientes() {



        $dados = array(
            'titulo' => 'Listar Clientes',
            'pagina' => 'listar_clientes_venda',
        );

        $this->load->view('Principal_popup', $dados);
    }

    public function listarProdutos() {


        $dados = array(
            'titulo' => 'Listar Produtos',
            'pagina' => 'listar_produtos_venda',
        );

        $this->load->view('Principal_popup', $dados);
    }

    public function listarProdutosURL() {

        if ($this->uri->segment(4) == NULL || $this->uri->segment(3) == NULL) {

            $this->session->set_flashdata('msg', 'Produto não encontrado');
            redirect(base_url('venda/cadastrarVenda'));
        }


        $produtos = $this->produto_model->do_select($this->uri->segment(4), $this->uri->segment(3))->result();

        if ($produtos != null) {

            $this->session->set_flashdata('autoFocusQuantidade', 'autofocus');
            $this->session->set_userdata('nome_produto_temp', $produtos[0]->nome);
            $this->session->set_userdata('codigo_produto_temp', $produtos[0]->id_produto);
            $this->session->set_userdata('codigo_barras_temp', $produtos[0]->cod_barra);
            $this->session->set_userdata('preco_venda_temp', $this->util->pontoParaVirgula($produtos[0]->preco_venda));
            $this->session->set_userdata('quantidade_temp', '1');
            $this->session->set_userdata('quantidade_max', $produtos[0]->quantidade);
            $this->session->set_userdata('id_produto_temp', $produtos[0]->id_produto);
        } else {
            $this->session->set_flashdata('msg', 'Produto não encontrado');

            $this->session->set_userdata('nome_produto_temp', NULL);
            $this->session->set_userdata('codigo_produto_temp', NULL);
            $this->session->set_userdata('codigo_barras_temp', NULL);
            $this->session->set_userdata('preco_venda_temp', NULL);
            $this->session->set_userdata('quantidade_temp', NULL);
            $this->session->set_userdata('id_produto_temp', NULL);
        }


        redirect(base_url('venda/cadastrarVenda'));
    }

    public function adicionaProduto() {

        $id_produto = $_GET['id_produto'];
        $nome_produto = $_GET['nome_produto'];
        $preco_venda = $_GET['preco_venda'];
        $quantidade_produto = $_GET['quantidade_produto'];

        if ($id_produto == null || $nome_produto == null || $preco_venda == null || $quantidade_produto == null) {
            $this->session->set_flashdata('msg', 'Não foi possível adicionar o produto tente novamente.');
            redirect(base_url('venda/cadastrarVenda'));
        }


        if ($this->session->userdata('itens') == null) {

            $itens = array($produtos = array('idProduto' => $id_produto, 'nomeProduto' => $nome_produto, 'precoVenda' => $preco_venda, 'quantidadeProduto' => $quantidade_produto));
            $this->session->set_userdata('itens', $itens);
        } else {
            $itens = $this->session->userdata('itens');
            array_push($itens, $produtos = array('idProduto' => $id_produto, 'nomeProduto' => $nome_produto, 'precoVenda' => $preco_venda, 'quantidadeProduto' => $quantidade_produto));
            $this->session->set_userdata('itens', $itens);
        }
        $this->session->set_userdata('codigo_barras_temp', null);
        $this->session->set_userdata('codigo_produto_temp', null);
        $this->session->set_userdata('quantidade_temp', null);
        $this->session->set_userdata('nome_produto_temp', null);
        $this->session->set_userdata('preco_venda_temp', null);

        redirect(base_url('venda/cadastrarVenda'));
    }

    public function adicionaLente() {
        //Sem cliente não pode adicionar lente
        if ($this->session->userdata('id_cliente') == '0') {
            echo"<script>alert('Para adicionar uma lente é necessário associar um cliente!');window.close();</script>";
        }

        $this->form_validation->set_rules('referencia', 'referencia', 'trim|required');
        $this->form_validation->set_rules('nome_lente', 'nome_lente', 'trim|required');
        $this->form_validation->set_rules('preco_venda', 'preco_venda', 'trim|required');
        if ($this->form_validation->run() == true) {
            if ($this->session->userdata('lente') == null) {

                $array_lente = array($lente = array(
                'referencia' => $this->input->post('referencia'),
                'nome_lente' => $this->input->post('nome_lente'),
                'preco_venda' => $this->input->post('preco_venda'),
                'quantidade_lente' => '1'));
                $this->session->set_userdata('lente', $array_lente);
            } else {
                $array_lente = $this->session->userdata('lente');
                array_push($array_lente, $lente = array(
                    'referencia' => $this->input->post('referencia'),
                    'nome_lente' => $this->input->post('nome_lente'),
                    'preco_venda' => $this->input->post('preco_venda'),
                    'quantidade_lente' => '1'));
                $this->session->set_userdata('lente', $array_lente);
            }
            echo"<script>window.close();window.opener.location.reload();</script>";
        }
        $dados = array(
            'titulo' => 'Cadastro de Lente',
            'pagina' => 'adiciona_lente_venda',
        );

        $this->load->view('Principal_popup', $dados);
    }

    public function adicionaServico() {

        $this->form_validation->set_rules('nome', 'nome', 'trim|required');
        $this->form_validation->set_rules('preco', 'preco', 'trim|required');
        $this->form_validation->set_rules('descricao', 'descricao', 'trim');
        if ($this->form_validation->run() == true) {
            if ($this->session->userdata('servico') == null) {

                $array_servico = array($servico = array(
                'nome' => $this->input->post('nome'),
                'preco' => $this->input->post('preco'),
                'descricao' => $this->input->post('descricao'),
                'quantidade_servico' => '1'));
                $this->session->set_userdata('servico', $array_servico);
            } else {
                $array_servico = $this->session->userdata('servico');
                array_push($array_servico, $lente = array(
                    'nome' => $this->input->post('nome'),
                    'preco' => $this->input->post('preco'),
                    'descricao' => $this->input->post('descricao'),
                    'quantidade_servico' => '1'));
                $this->session->set_userdata('servico', $array_servico);
            }
            echo"<script>window.close();window.opener.location='".base_url('venda/cadastrarVenda')."';</script>";
        }
        $dados = array(
            'titulo' => 'Cadastro de Serviço',
            'pagina' => 'adiciona_servico_venda',
        );

        $this->load->view('Principal_popup', $dados);
    }

    public function adicionaDesconto() {

        $valor_desconto_venda = $this->util->virgulaParaPonto($_GET['valor_desconto_venda']);
        $subtotal_venda = $this->util->virgulaParaPonto($_GET['subtotal_venda']);

        if ($valor_desconto_venda >= $subtotal_venda) {
            $this->session->set_flashdata('msg', 'O desconto é maior que o valor da compra.');
            redirect(base_url('venda/cadastrarVenda'));
        } else {

            $this->session->set_userdata('valor_desconto_venda', $valor_desconto_venda);
            redirect(base_url('venda/cadastrarVenda'));
        }
    }

    public function adicionarCheques() {
    
        if ($this->input->post('parcelas') != null) {
            
            $cheques = array();
            for ($i = 1; $i < $this->input->post('parcelas') + 1; $i++) {
                
                if ($this->input->post('data_'.$i) != null && $this->input->post('valor_'.$i) != null && $this->input->post('descricao_'.$i) != null) {
                   array_push($cheques, array(
                        'data' => $this->input->post('data_' . $i),
                        'valor' => $this->util->virgulaParaPonto($this->input->post('valor_' . $i)),
                        'descricao' => $this->input->post('descricao_' . $i),
                    ));
                    $valorCheques = $valorCheques + $this->util->virgulaParaPonto($this->input->post('valor_' . $i));
                }
            }
            $this->session->set_userdata('cheques', $cheques);
            $this->session->set_userdata('valorCheques', $valorCheques);
            $this->session->set_flashdata('msg', 'Cheques cadastrado com sucesso');
            $this->session->set_userdata('formaPgto','4');
            $this->session->set_userdata('parcelas',$this->input->post('parcelas'));
            echo"<script>window.close();window.opener.location.reload();</script>";

                }
        $dados = array(
            'titulo' => 'Cadastro de Cheques',
            'pagina' => 'adiciona_cheque_venda',
        );

        $this->load->view('Principal_popup', $dados);
    }

    public function limparVenda() {

        $this->session->unset_userdata('produtos');
        $this->session->unset_userdata('nome_cliente');
        $this->session->unset_userdata('cpf_cliente');
        $this->session->unset_userdata('id_cliente');
        $this->session->unset_userdata('autoFocusQuantidade');
        $this->session->unset_userdata('codigo_barras_temp');
        $this->session->unset_userdata('codigo_produto_temp');
        $this->session->unset_userdata('quantidade_temp');
        $this->session->unset_userdata('quantidade_max');
        $this->session->unset_userdata('nome_produto_temp');
        $this->session->unset_userdata('preco_venda_temp');
        $this->session->unset_userdata('itens');
        $this->session->unset_userdata('lente');
        $this->session->unset_userdata('servico');
        $this->session->unset_userdata('valor_desconto_venda');
        $this->session->unset_userdata('id_cliente');
        $this->session->unset_userdata('id_produto_temp');
        $this->session->unset_userdata('Cheques');
        $this->session->unset_userdata('valorCheques');
        $this->session->unset_userdata('formaPgto');
        $this->session->unset_userdata('parcelas');
        
        $this->cadastrarVenda();
    }

    public function gerarOrcamento() {
        if ($this->session->userdata('id_cliente') == 0) {
            $idCliente = null;
        } else {
            $idCliente = $this->session->userdata('id_cliente');
        }
        $dados = array(
            'data' => date('d-m-Y'),
            'forma_pagamento' => $this->input->post('forma_pagamento'),
            'vendedor' => $this->session->userdata('nome'),
            'desconto' => $this->util->virgulaParaPonto($this->input->post('desconto')),
            'status' => 'Pendente',
            'id_cliente' => $idCliente,
            'itens' => $this->session->userdata('itens'),
            'lentes' => $this->session->userdata('lente'),
            'servicos' => $this->session->userdata('servico'),
        );
        $this->venda_model->cadastrarOrcamento($dados);
    }

    public function exibeOrcamento() {

        $id_orcamento = $this->uri->segment(3);

        $dados = Array(
            'pagina' => 'lista_orcamento',
            'titulo' => 'Visualiza Orçamento',
            'dados_orcamento' => $this->venda_model->retornaOrcamento($id_orcamento),
        );
        $this->load->view('Principal_popup', $dados);
    }
    public function gerarVenda() {
        if ($this->session->userdata('id_cliente') == 0) {
            $idCliente = null;
        } else {
            $idCliente = $this->session->userdata('id_cliente');
        }
            $total = $this->util->virgulaParaPonto($this->input->post('total'));
            $desconto = $this->session->userdata('valor_desconto_venda');
            $total_cheque= $this->util->virgulaParaPonto($this->session->userdata('valorCheques'));
            
        if($this->session->userdata('formaPgto')== '4'){
              if($total-$total_cheque < -0.01 || $total-$total_cheque > 0.01){
                
                $this->session->set_flashdata('msg','O valor total dos cheques não está igual ao valor total da venda, é necessário corrigir esse problema para para finalizar a venda!');
                redirect('venda/cadastrarVenda');
              
            }
        $dados = array(
            'data' => date('d-m-Y'),
            'forma_pagamento' => $this->session->userdata('formaPgto'),
            'vendedor' => $this->session->userdata('nome'),
            'desconto' => $desconto,
            'id_cliente' => $idCliente,
            'itens' => $this->session->userdata('itens'),
            'lentes' => $this->session->userdata('lente'),
            'servicos' => $this->session->userdata('servico'),
            'cheques' => $this->session->userdata('cheques'),
            );
        }else{
            $dados = array(
            'data' => date('d-m-Y'),
            'forma_pagamento' => $this->session->userdata('formaPgto'),
            'vendedor' => $this->session->userdata('nome'),
            'desconto' => $desconto,
            'id_cliente' => $idCliente,
            'itens' => $this->session->userdata('itens'),
            'lentes' => $this->session->userdata('lente'),
            'servicos' => $this->session->userdata('servico'),
            );
        }
        
        $this->venda_model->cadastrarVenda($dados);
    }
    
    public function dadosSessao(){
        
        if($_GET['descontoSessao']!= NULL) $this->session->set_userdata('valor_desconto_venda',$_GET['descontoSessao']);
        if($_GET['formaPgto']!= NULL) $this->session->set_userdata('formaPgto',$_GET['formaPgto']);
        
    }
    
    public function exibeVenda() {

        $id_venda = $this->uri->segment(3);

        $dados = Array(
            'pagina' => 'lista_venda',
            'titulo' => 'Visualiza Venda',
            'dados_venda' => $this->venda_model->retornaVenda($id_venda),
        );
        $this->load->view('Principal_popup', $dados);
    }
    
     public function listaVendasCliente(){

        $id_cliente = $this->uri->segment(3);
        
        $dados = Array(
        'pagina' => 'listar_venda_cliente',
        'titulo' => 'Listar Vendas',
        'vendas' => $this->venda_model->vendasCliente($id_cliente)
        );
        $this->load->view('Principal_popup', $dados);
    }
    
        public function listaOrcamentos() {
        $dados = array('pagina' => 
            'lista_orcamentos_pendentes', 
            'titulo' => 'Orçamentos Pendentes', 
            'orcamentos' => $this->venda_model->listaOrcamentos());
        $this->load->view('Principal', $dados);
    }
    
        public function deletarOrcamento() {

        if ($this->uri->segment(3) != NULL) {

            $id_orcamento = $this->uri->segment(3);
       
            $this->venda_model->deleteOrcamento($id_orcamento);
            redirect($this->session->userdata('paginaAnterior'));  
        }
    }
    
     public function finalizarOrcamento() {
         
         //Limpa as variaveis que estão no cache
         
        $this->session->unset_userdata('nome_cliente');
        $this->session->unset_userdata('cpf_cliente');
        $this->session->unset_userdata('id_cliente');
        $this->session->unset_userdata('itens');
        $this->session->unset_userdata('produtos');
        $this->session->unset_userdata('lente');
        $this->session->unset_userdata('servico');


        $this->session->unset_userdata('autoFocusQuantidade');
        $this->session->unset_userdata('codigo_barras_temp');
        $this->session->unset_userdata('codigo_produto_temp');
        $this->session->unset_userdata('quantidade_temp');
        $this->session->unset_userdata('quantidade_max');
        $this->session->unset_userdata('nome_produto_temp');
        $this->session->unset_userdata('preco_venda_temp');
        
        $this->session->unset_userdata('valor_desconto_venda');
        $this->session->unset_userdata('id_produto_temp');
        $this->session->unset_userdata('Cheques');
        $this->session->unset_userdata('valorCheques');
        $this->session->unset_userdata('formaPgto');
        $this->session->unset_userdata('parcelas');
         
        //Captura o id do orçamento
        $id_orcamento = $this->uri->segment(3);
        
       $orcamento =  $this->venda_model->retornaOrcamento($id_orcamento);
       
       $this->session->set_userdata('nome_cliente',$orcamento['pessoa']->nome);
       $this->session->set_userdata('cpf_cliente',$orcamento['cliente']->cpf);
       $this->session->set_userdata('id_cliente',$orcamento['cliente']->id);
       //Trata os itens para mostrar na tela de vendas
       $itensVenda = array();
       foreach ($orcamento['itens'] as $itens){
           array_push($itensVenda,array(
               'idProduto'=>$itens->id_produto,
               'nomeProduto'=>$itens->nome,
               'quantidadeProduto'=>$itens->quantidade,
               'precoVenda' => number_format($itens->preco_unitario,'2',',',''),
               ));
}
            $this->session->set_userdata('itens',$itensVenda);
            
//trata as lentes para mostrar na tela de vendas
       $lentesVenda = array();
       foreach ($orcamento['lentes'] as $lentes){
           array_push($lentesVenda,array(
               'referencia'=>$lentes->referencia,
               'nome_lente'=>$lentes->nome,
               'quantidade_lente'=>'1',
               'preco_venda' => number_format($lentes->preco_venda,'2',',',''),
               ));
}
            $this->session->set_userdata('lente',$lentesVenda);
            
//trata as lentes para mostrar na tela de vendas
       $servicosVenda = array();
       foreach ($orcamento['servicos'] as $servicos){
           array_push($servicosVenda,array(
               'nome'=>$servicos->nome,
               'quantidade_servico'=>'1',
               'preco' => number_format($servicos->preco_venda,'2',',',''),
               ));
}
            $this->session->set_userdata('servico',$servicosVenda);
        
        
        
        
        
        
        
        
        
        
        
        
        $this->cadastrarVenda();
    }
    
    
}
?>