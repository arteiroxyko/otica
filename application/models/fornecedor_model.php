<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fornecedor_model extends CI_Model {

    public function do_insert($dados = null) {
        if ($dados != null) {

            $this->db->trans_start();
            $pessoa = array('nome' => ''.element('nome', $dados), 'email' => ''.element('email', $dados),);
            $this->db->insert('pessoa', $pessoa);

            $id_pessoa = $this->db->insert_id();

            $fornecedor = array('cnpj' => ''.element('cnpj', $dados), 'id_pessoa' => $id_pessoa,);
            $this->db->insert('fornecedor', $fornecedor);

            $telefone_fixo = array('num_telefone' => ''.element('num_telefone1', $dados), 'id_tipo_telefone' => '1', 'id_pessoa' => $id_pessoa,);

            $this->db->insert('telefone', $telefone_fixo);

            $telefone_celular = array('num_telefone' => ''.element('num_telefone2', $dados), 'id_tipo_telefone' => '2', 'id_pessoa' => $id_pessoa,);
            $this->db->insert('telefone', $telefone_celular);

            $this->db->trans_complete();

            $this->session->set_flashdata('cadastrook', 'Cadastro efetuado com sucesso');

            redirect('fornecedor/adiciona');
        }
    }

    public function getAll() {

        $this->db->select('pessoa.id as id_pessoa, pessoa.nome, pessoa.email, fornecedor.id as id_fornecedor, fornecedor.cnpj, telefone.num_telefone');
        $this->db->from('pessoa');
        $this->db->join('fornecedor', 'fornecedor.id_pessoa = pessoa.id');
        $this->db->join('telefone', 'pessoa.id = telefone.id_pessoa');
        $this->db->group_by('pessoa.id');

        return $this->db->get();
    }

    public function get_byid($id_pessoa = NULL, $id_fornecedor = NULL) {

        if ($id_fornecedor != NULL || $id_pessoa != NULL) {

            $this->db->where('id', $id_pessoa);
            $this->db->limit(1);
            $pessoa = $this->db->get('pessoa')->row();

            $this->db->where('id', $id_fornecedor);
            $this->db->limit(1);
            $cliente = $this->db->get('fornecedor')->row();

            $this->db->where('id_pessoa', $id_pessoa);
            $telefone = $this->db->get('telefone')->result();

            $dados = array('pessoa' => $pessoa, 'fornecedor' => $cliente, 'telefone' => $telefone,);
            return $dados;
        }
    }

    public function do_update($dados = NULL, $condicao = NULL) {

        if ($dados != null || $condicao != null) {

            $this->db->trans_start();

            $pessoa = array('nome' => ''.element('nome', $dados), 'email' => ''.element('email', $dados),);

            $condicao_pessoa = array('id' => $condicao['id_pessoa'],);
            $this->db->update('pessoa', $pessoa, $condicao_pessoa);

            $fornecedor = array('cnpj' => ''.element('cnpj', $dados));

            $condicao_fornecedor = array('id_pessoa' => $condicao['id_pessoa'],);
            $this->db->update('fornecedor', $fornecedor, $condicao_fornecedor);

            $telefone_fixo = array('num_telefone' => ''.element('num_telefone1', $dados),);
            $condicao_telefone_fixo = array('id_pessoa' => $condicao['id_pessoa'], 'id_tipo_telefone' => 1,);
            $this->db->update('telefone', $telefone_fixo, $condicao_telefone_fixo);

            $telefone_celular = array('num_telefone' => ''.element('num_telefone2', $dados),);
            $condicao_telefone_celular = array('id_pessoa' => $condicao['id_pessoa'], 'id_tipo_telefone' => 2,);
            $this->db->update('telefone', $telefone_celular, $condicao_telefone_celular);

            if ($this->db->trans_complete()) {
                $this->session->set_flashdata('statusUpdate', 'Alterado com sucesso');
            } else {
                $this->session->set_flashdata('statusUpdate', 'Não foi possível alterar o fornecedor');
            }

            redirect(current_url());
        }
        redirect('fornecedor/lista');
    }

    public function do_delete($id = null) {

        if ($id != null) {

            $this->db->where('id_pessoa', $id);
            $this->db->delete('fornecedor');
            $this->db->where('id', $id);
            $this->db->delete('pessoa');
            
            return $this->db->_error_number();
        }
        return false;
    }

}
