<?php     ?><!DOCTYPE html>   
        <script type="text/javascript" src="http://localhost/otica/public/js/agendamento.js"></script> 
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/agendamento/estilo/table_jui.css" />
        <link rel="stylesheet" href="http://localhost/otica/public/jquery/agendamento/estilo/jquery-ui-1.8.4.custom.css" />
        <script type="text/javascript" src="http://localhost/otica/public/jquery/agendamento/js/jquery.mim.js"></script>
        <script type="text/javascript" src="http://localhost/otica/public/jquery/agendamento/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#example').dataTable({
                    "bPaginate": true,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                   "sLengthMenu": "<br>Escolha o cliente a ser agendado"
                  }
                });
            });
        </script>
                <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#example1').dataTable({
                    "bPaginate": true,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                                     "oLanguage": {
                   "sLengthMenu": "<br>Lista de clientes Agendados para a data escolhida"
                  }
                   
                });
            });
        </script>

    
    
  
    <?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agendamento extends CI_Controller {

    public function __construct() {
        parent::__construct();
            $this->load->helper('url');
                $prefs = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => base_url('agendamento/horarioConsulta'),
            'month_type' => 'long',
            'day_type' => 'short',
            'template' =>
            '{table_open}<table class="calendar">{/table_open}
    {week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
   {cal_cell_content}<div class="day_listing"> <a href="{content}">{day}</a></div>{/cal_cell_content}
   {cal_cell_content_today}<div class="today"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
   {cal_cell_no_content}<div class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
    {cal_cell_no_content_today}<div class="today">{day}</div>{/cal_cell_no_content_today}
');
        
        $this->load->model('agendamento_model');
        $this->load->model('dependente_model');
        $this->load->model('cliente_model');
        $this->load->library('table');
        $this->load->library('uri');
        $this->load->library('calendar', $prefs);
        $this->load->helper('date');
        $this->load->library('table');
        $this->login_model->logado();//Verifica se o usuário está logado

    }

    public function index() {

        redirect('agendamento/horarioConsulta/' . date('d') . '/' . date('m') . '/' . date('Y'));
    }

    public function horarioConsulta($anoCalendario = NULL, $mesCalendario = NULL, $diaCalendario = NULL) {
        if ($anoCalendario == null)
            $anoCalendario = $this->uri->segment(3); //Captura o ano da URL
        if ($mesCalendario == NULL)
            $mesCalendario = $this->uri->segment(4); //Captura o mes da URL
        if ($diaCalendario == NULL)
            $diaCalendario = $this->uri->segment(5); //Captura o mes da URL
        $dados = Array(
            'pagina' => 'agenda_cliente',
            'titulo' => 'Agendamento de Consulta',
            'horarioAgendamento' => $this->agendamento_model->listarConsultasDia($anoCalendario . '/' . $mesCalendario . '/' . $diaCalendario)->result(),
        );
        $this->load->view('Principal', $dados);
    }

    public function cadastrarAgendamento() {

        if ($this->input->post() != NULL) {

            $agendamento = elements(array('idCliente', 'horario', 'data','dependente'), $this->input->post());
            
          
            $this->agendamento_model->cadastrarAgendamento($agendamento);
        } else {

            $dados = Array(
                'pagina' => 'agenda_cliente',
                'titulo' => 'Agendamento de Consulta'
            );


            $this->load->view('Principal', $dados);
        }
    }

    public function deletarAgendamento() {

        if ($this->uri->segment(6) != NULL) {

            $id_agendamento = $this->uri->segment(6);

            if ($this->agendamento_model->deleteAgendamento($id_agendamento)=='0') {
                $this->session->set_flashdata('msg', 'Agendamento deletado com sucesso!');
            }else if($this->agendamento_model->deleteAgendamento($id_agendamento)=='1451'){
            $this->session->set_flashdata('msg', 'Não é possível excluir esse agendamento, porque \no cliente já foi consultado.');
            
        }else{
            $this->session->set_flashdata('msg', 'Não é possível excluir esse agendamento, erro interno.');

        }
            
            
            
            redirect('agendamento/horarioConsulta/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
            
    }
    }
    
    public function agendamentoDeCliente(){

            $dados = array(
            'titulo' => 'Cadastrar Agendamento',
            'pagina' => 'agendamento_cliente',
        );

        $this->load->view('principal_popup', $dados);
        
        
    }
}
?>