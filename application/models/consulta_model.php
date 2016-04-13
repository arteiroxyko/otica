<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consulta_model extends CI_Model {

    public function cadastrarConsulta($dados = null) {
        if ($dados != null) {

                   
            $this->db->trans_start();


            if (element('longe_od_esferico', $dados) != null ||
                    element('longe_od_cilindrico', $dados) != null ||
                    element('longe_od_eixo', $dados) != null ||
                    element('longe_od_dnp', $dados) != null ||
                    element('longe_oe_esferico', $dados) != null ||
                    element('longe_oe_cilindrico', $dados) != null ||
                    element('longe_oe_eixo', $dados) != null ||
                    element('longe_oe_dnp', $dados) != null ||
                    element('perto_od_esferico', $dados) != null ||
                    element('perto_od_cilindrico', $dados) != null ||
                    element('perto_od_eixo', $dados) != null ||
                    element('perto_od_dnp', $dados) != null ||
                    element('perto_oe_esferico', $dados) != null ||
                    element('perto_oe_cilindrico', $dados) != null ||
                    element('perto_oe_eixo', $dados) != null ||
                    element('perto_oe_dnp', $dados) != null) {

                //Insere informações de receita
                if (element('id_dependente', $dados) == NULL) {
                    $id_dependente = null;
                } else {
                    $id_dependente = element('id_dependente', $dados);
                }

                $receita = array(
                    'crm' => '' . element('crm', $dados),
                    'medico' => '' . element('medico', $dados),
                    'data' => $this->util->data_user_para_mysql(element('data_consulta', $dados)),
                    'id_cliente' => element('id_cliente', $dados),
                    'id_dependente' => $id_dependente,
                    'dp' => element('dp', $dados),
                    'observacao' => '' . element('obervacoes', $dados),
                );
                $this->db->insert('receita', $receita); //insere no BD
                $id_receita = $this->db->insert_id(); //Pega o ultimo ID inserido no BD
                //LONGE OD
                if (element('longe_od_esferico', $dados) != null ||
                        element('longe_od_cilindrico', $dados) != null ||
                        element('longe_od_eixo', $dados) != null ||
                        element('longe_od_dnp', $dados) != null) {

                    $longe_od = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('longe_od_esferico', $dados)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('longe_od_cilindrico', $dados)),
                        'eixo' => element('longe_od_eixo', $dados),
                        'dnp' => element('longe_od_dnp', $dados),
                    );
                    $this->db->insert('diagnostico', $longe_od); //insere no BD
                    $id_diagnostico = $this->db->insert_id(); //Pega o ultimo ID inserido no BD

                    $informacoes_olho = array(
                        'id_diagnostico' => $id_diagnostico,
                        'distancia' => 'Longe',
                        'lado' => 'OD',
                    );
                    $this->db->insert('informacoes_olho', $informacoes_olho); //insere no BD
                }
                //LONGE OE
                if (element('longe_oe_esferico', $dados) != null ||
                        element('longe_oe_cilindrico', $dados) != null ||
                        element('longe_oe_eixo', $dados) != null ||
                        element('longe_oe_dnp', $dados) != null) {

                    $longe_oe = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('longe_oe_esferico', $dados)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('longe_oe_cilindrico', $dados)),
                        'eixo' => element('longe_oe_eixo', $dados),
                        'dnp' => element('longe_oe_dnp', $dados),
                    );
                    $this->db->insert('diagnostico', $longe_oe); //insere no BD
                    $id_diagnostico = $this->db->insert_id(); //Pega o ultimo ID inserido no BD

                    $informacoes_olho = array(
                        'id_diagnostico' => $id_diagnostico,
                        'distancia' => 'Longe',
                        'lado' => 'OE',
                    );
                    $this->db->insert('informacoes_olho', $informacoes_olho); //insere no BD
                }

                //PERTO OD
                if (element('perto_od_esferico', $dados) != null ||
                        element('perto_od_cilindrico', $dados) != null ||
                        element('perto_od_eixo', $dados) != null ||
                        element('perto_od_dnp', $dados) != null) {

                    $perto_od = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('perto_od_esferico', $dados)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('perto_od_cilindrico', $dados)),
                        'eixo' => element('perto_od_eixo', $dados),
                        'dnp' => element('perto_od_dnp', $dados),
                    );
                    $this->db->insert('diagnostico', $perto_od); //insere no BD
                    $id_diagnostico = $this->db->insert_id(); //Pega o ultimo ID inserido no BD

                    $informacoes_olho = array(
                        'id_diagnostico' => $id_diagnostico,
                        'distancia' => 'Perto',
                        'lado' => 'OD',
                    );
                    $this->db->insert('informacoes_olho', $informacoes_olho); //insere no BD
                }
                // PERTO OE
                if (element('perto_oe_esferico', $dados) != null ||
                        element('perto_oe_cilindrico', $dados) != null ||
                        element('perto_oe_eixo', $dados) != null ||
                        element('perto_oe_dnp', $dados) != null) {

                    $perto_oe = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('perto_oe_esferico', $dados)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('perto_oe_cilindrico', $dados)),
                        'eixo' => element('perto_oe_eixo', $dados),
                        'dnp' => element('perto_oe_dnp', $dados),
                    );
                    $this->db->insert('diagnostico', $perto_oe); //insere no BD
                    $id_diagnostico = $this->db->insert_id(); //Pega o ultimo ID inserido no BD

                    $informacoes_olho = array(
                        'id_diagnostico' => $id_diagnostico,
                        'distancia' => 'Perto',
                        'lado' => 'OE',
                    );
                    $this->db->insert('informacoes_olho', $informacoes_olho); //insere no BD
                }

                $consulta = array(
                    'id_agendamento' => '' . element('id_agendamento', $dados),
                    'id_medico' => '' . element('id_medico', $dados),
                    'id_receita' => $id_receita,
                );


                $this->db->insert('consulta', $consulta); //insere no BD



                if ($this->db->trans_complete()) {

                    $this->agendamento_model->AtualizaAgendamento(element('id_agendamento', $dados), 'Presente');
                    $this->session->set_flashdata('msgOk', 'Dados Salvos com sucesso'); //Adiciona na sessão temporaria o status do cadastro 
                    redirect('receita/exibeReceita/' . $id_receita);
                } else {
                    $this->session->set_flashdata('msg', 'Erro ao salvar os dados'); //Adiciona na sessão temporaria o status do cadastro
                    redirect(current_url() . '/' . element('id_agendamento', $dados));
                }
            } else {
                $this->session->set_flashdata('msg', 'Erro ao salvar os dados, todos os campos estão vazios'); //Adiciona na sessão temporaria o status do cadastro           
                redirect(current_url() . '/' . element('id_agendamento', $dados));
            }
        }
    }

}

?>