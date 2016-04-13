<script type="text/javascript" src="http://localhost/otica/public/js/consultaOftalmologica.js"></script>        
<link href="http://localhost/otica/public/jquery/estilo/table_jui.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/estilo/jquery-ui-1.8.4.custom.css" />
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.mim.js"></script>
        <script type="text/javascript" src="http://localhost/otica/public/jquery/js/jquery.dataTables.min.js"></script>
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

class Consulta extends CI_Controller {

    public function __construct() {
        parent::__construct();
            
        $this->load->helper('url');
        $this->load->model('agendamento_model');
        $this->load->model('dependente_model');
        $this->load->model('cliente_model');
        $this->load->model('medico_model');
        $this->load->model('consulta_model');
        $this->load->library('table');
        $this->load->library('form_validation');
        $this->load->library('uri');
        $this->load->helper('date');
        
                 $this->login_model->logado();//Verifica se o usuário está logado
    
    }

    public function index() {

        redirect('consulta/horarioConsulta');
    }

    public function horarioConsulta() {
            
            $dados = Array(
            'pagina' => 'consulta_cliente',
            'titulo' => 'Consulta Oftalmológica',
            'horarioAgendamento' => $this->agendamento_model->listarConsultas('data_consulta <="'.date('d/m/Y').'" and status = "Pendente" or status = "Faltou" and data_consulta="'.date('d/m/y').'"'),
        );
            
        
        $this->load->view('Principal', $dados);
    }

 public function atualizarAgendamento() {
     
     $idCliente = $this->uri->segment(3);
     $status = $this->uri->segment(4);
     
     $this->agendamento_model->AtualizaAgendamento($idCliente,$status);
     
 }
 
 public function cadastrarConsulta() {
     
        $this->form_validation->set_rules('id_agendamento', 'ID_AGENDAMENTO', 'trim|required');

      
        if ($this->form_validation->run()) {
            
            $dados = elements(array('id_agendamento', 'id_medico','crm', 'medico','data_consulta', 'id_cliente',
                'id_dependente','longe_od_esferico', 'longe_od_cilindrico', 'longe_od_eixo', 'longe_od_dnp','longe_oe_esferico', 
                'longe_oe_cilindrico', 'longe_oe_eixo', 'longe_oe_dnp','perto_od_esferico', 'perto_od_cilindrico', 
                'perto_od_eixo', 'perto_od_dnp','perto_oe_esferico', 'perto_oe_cilindrico', 'perto_oe_eixo', 
                'perto_oe_dnp','dp','obervacoes'
                ), $this->input->post());
            $this->consulta_model->cadastrarConsulta($dados);
        } else {
            
            $id_agendamento=$this->uri->segment(3);
            //Resgata as informações do banco.
                
            $dados = array(
                'titulo' => 'Dados da Consulta Oftalmológica',
                'pagina' => 'adiciona_consulta',
                'agendamento' => $this->agendamento_model->listarConsultas('agendamento.id ='.$id_agendamento),
            );

            $this->load->view('Principal_popup', $dados);
        }
 }
 
 
    }


?>