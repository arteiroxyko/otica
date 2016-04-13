<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receita_model extends CI_Model {

    public function retornaReceita($id_receita = NULL) {
        if ($id_receita != NULL) {

            //Captura a receita
            $this->db->where('id', $id_receita);
            $this->db->limit(1);
            $receita = $this->db->get('receita')->row();

            //captura o cliente
            $this->db->where('id', $receita->id_cliente);
            $this->db->limit(1);
            $cliente = $this->db->get('cliente')->row();

            $this->db->where('id', $cliente->id_pessoa);
            $this->db->limit(1);
            $pessoa = $this->db->get('pessoa')->row();
            
            $this->db->where('id', $receita->id_dependente);
            $this->db->limit(1);
            $dependente = $this->db->get('dependente')->row();            
            
            $this->db->where('id_cliente', $receita->id_cliente);
            $this->db->limit(1);
            $endereco = $this->db->get('endereco')->row();

            $this->db->where('id_pessoa', $pessoa->id);
            $telefone = $this->db->get('telefone')->result();

            //Captura o diagnostico e informações do olho
            $this->db->select('cilindrico,eixo,esferico,dnp,distancia,lado');
            $this->db->from('diagnostico');
            $this->db->join('informacoes_olho', 'informacoes_olho.id_diagnostico = diagnostico.id');
            $this->db->where("id_receita = ".$id_receita);
            $dianostico = $this->db->get()->result();




            $dados = array(
                'receita'=>$receita,
                'cliente'=>$cliente,
                'pessoa' => $pessoa,
                'dependente'=>$dependente,
                'endereco' => $endereco,
                'telefone' => $telefone,
                'diagnostico'=>$dianostico,
            );
            
            return $dados;//Retorna um array com todos os dados
        }
    }
    
    public function receitasCliente($id_cliente = NULL) {
        if ($id_cliente != NULL) {
            //Captura a receita
            $this->db->where('id_cliente', $id_cliente);
            $this->db->from('receita');
            return $this->db->get()->result();
        }
    }
    
    public function diagnosticoReceita($id_receita = null) {
        //Captura o diagnostico e informações do olho
        $this->db->select('cilindrico,eixo,esferico,dnp,distancia,lado');
        $this->db->from('diagnostico');
        $this->db->join('informacoes_olho', 'informacoes_olho.id_diagnostico = diagnostico.id');
        $this->db->where("id_receita = ".$id_receita);
        return $this->db->get()->result();
    }
    
    public function cadastraReceita($dados = null) {
        if ($dados != null) {
            $this->db->trans_start();
            
            if (element('id_cliente', $dados) == null) {
                $this->session->set_flashdata('msg', 'Escolha um cliente para cadastrar a receita'); //Adiciona na sessão temporaria o status do cadastro           
                redirect(current_url()."?idCliente=".element('id_cliente', $dados)."&nomeCliente=".element('nomeCliente', $dados)."&cpfCliente=".element('cpfCliente', $dados)."&emailCliente=".element('emailCliente', $dados)."&medico=".element('medico', $dados)."&crm=".element('crm', $dados)."&data=".element('data', $dados));
            }
            
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
                $receita = array(
                    'crm' => element('crm', $dados, null),
                    'medico' => element('medico', $dados, null),
                    'data' => element('data', $dados, null),
                    'id_cliente' => element('id_cliente', $dados, null),
                    'id_dependente' => element('dependente', $dados, null),
                    'dp' => element('dp', $dados, null),
                    'observacao' => element('obervacoes', $dados, null),
                );
                $this->db->insert('receita', $receita); //insere no BD
                $id_receita = $this->db->insert_id(); //Pega o ultimo ID inserido no BD
                
                //LONGE OD
                if (element('longe_od_esferico', $dados, null) != null ||
                        element('longe_od_cilindrico', $dados, null) != null ||
                        element('longe_od_eixo', $dados, null) != null ||
                        element('longe_od_dnp', $dados, null) != null) {

                    $longe_od = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('longe_od_esferico', $dados, null)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('longe_od_cilindrico', $dados, null)),
                        'eixo' => element('longe_od_eixo', $dados, null),
                        'dnp' => element('longe_od_dnp', $dados, null),
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
                        'esferico' => $this->util->virgulaParaPonto(element('longe_oe_esferico', $dados, null)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('longe_oe_cilindrico', $dados, null)),
                        'eixo' => element('longe_oe_eixo', $dados, null),
                        'dnp' => element('longe_oe_dnp', $dados, null),
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
                if (element('perto_od_esferico', $dados, null) != null ||
                        element('perto_od_cilindrico', $dados, null) != null ||
                        element('perto_od_eixo', $dados, null) != null ||
                        element('perto_od_dnp', $dados, null) != null) {

                    $perto_od = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('perto_od_esferico', $dados, null)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('perto_od_cilindrico', $dados, null)),
                        'eixo' => element('perto_od_eixo', $dados, null),
                        'dnp' => element('perto_od_dnp', $dados, null),
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
                if (element('perto_oe_esferico', $dados, null) != null ||
                        element('perto_oe_cilindrico', $dados, null) != null ||
                        element('perto_oe_eixo', $dados, null) != null ||
                        element('perto_oe_dnp', $dados, null) != null) {

                    $perto_oe = array(
                        'id_receita' => $id_receita,
                        'esferico' => $this->util->virgulaParaPonto(element('perto_oe_esferico', $dados, null)),
                        'cilindrico' => $this->util->virgulaParaPonto(element('perto_oe_cilindrico', $dados, null)),
                        'eixo' => element('perto_oe_eixo', $dados, null),
                        'dnp' => element('perto_oe_dnp', $dados, null),
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
                
                if ($this->db->trans_complete()) {
                    $this->session->set_flashdata('msgOk', 'Dados Salvos com sucesso'); //Adiciona na sessão temporaria o status do cadastro 
                    redirect('receita/adicionaReceita');
                } else {
                    $this->session->set_flashdata('msg', 'Erro ao salvar os dados'); //Adiciona na sessão temporaria o status do cadastro
                    redirect(current_url()."?idCliente=".element('id_cliente', $dados)."&nomeCliente=".element('nomeCliente', $dados)."&cpfCliente=".element('cpfCliente', $dados)."&emailCliente=".element('emailCliente', $dados)."&medico=".element('medico', $dados)."&crm=".element('crm', $dados)."&data=".element('data', $dados));
//                    redirect($this->session->userdata('paginaAnterior'));
                }
            } else {
                $this->session->set_flashdata('msg', 'Erro ao salvar os dados, todos os campos estão vazios'); //Adiciona na sessão temporaria o status do cadastro           
                redirect(current_url()."?idCliente=".element('id_cliente', $dados)."&nomeCliente=".element('nomeCliente', $dados)."&cpfCliente=".element('cpfCliente', $dados)."&emailCliente=".element('emailCliente', $dados)."&medico=".element('medico', $dados)."&crm=".element('crm', $dados)."&data=".element('data', $dados));
//                redirect($this->session->userdata('paginaAnterior'));
            }
        }
    }
}

?>