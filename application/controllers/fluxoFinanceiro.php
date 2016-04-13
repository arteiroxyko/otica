<link rel="stylesheet" href="http://localhost/otica/public/jquery/datagrid/jquery-ui.css" />
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

class FluxoFinanceiro extends CI_Controller {

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
        $this->load->model('fluxoFinanceiro_model');


        $this->login_model->logado(); //Verifica se o usuário está logado
    }

    public function index() {

        redirect('fluxoFinanceiro/gerarRelatorio');
    }
    
    public function gerarRelatorio() {
        $dados = Array(
            'pagina' => 'fluxo_financeiro',
            'titulo' => 'Relatório de Fluxo Financeiro'
        );
        $this->load->view('Principal', $dados);
    }
    
    public function relatorio(){
        
               $dados = Array(
            'pagina' => 'fluxo_financeiro',
            'titulo' => 'Relatório de Fluxo Financeiro',
            );
       
       
             $this->load->view('Principal', $dados);

       
    }
    
        public function relatorioPopUp() {
                 
        
            $inputDataInicial = $_POST['dataInicial'];
            $inputDataFinal = $_POST['dataFinal'];
            $contas_pagar = $_POST['contas_pagar'];
            $vendas = $_POST['vendas'];
           
            $dadosRelatorio = $this->fluxoFinanceiro_model->gerarRelatorio($inputDataInicial,$inputDataFinal,$contas_pagar,$vendas);
            
            
        $dados = Array(
            'pagina' => 'relatorio_fluxo_financeiro',
            'titulo' => 'Relatório de Fluxo Financeiro',
            'dadosRelatorio'=> $dadosRelatorio,
            'dataInicial'=>$inputDataInicial,
            'dataFinal'=>$inputDataFinal,
        );
        $this->load->view('Principal', $dados);
    }
    
    
}
?>