<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medico_model extends CI_Model {

    public function cadastrarMedico($dados = null) {
        if ($dados != null) {

            $this->db->trans_start(); //Começa uma transação no banco de dados
            //Trata os elementos de Medico
            $medico = array(
                'nome' => element('nome', $dados),
                'crm' => element('crm', $dados),
                'id_usuario' => element('id_usuario', $dados),
                
            );
            $this->db->insert('medico', $medico); //insere no BD

            if($this->db->trans_complete())

            $this->session->set_flashdata('msgOk', 'Cadastro efetuado com sucesso'); //Adiciona na sessão temporaria o status do cadastro
            }else{
            $this->session->set_flashdata('msg', 'Erro ao cadastrar médico'); //Adiciona na sessão temporaria o status do cadastro

            }
            redirect(current_url());
        
    }

      public function retornaMedico($where=NULL) {

            if($where != null) $this->db->where($where);
            $medico = $this->db->get('medico')->result();
            return $medico;
        }
   
}

